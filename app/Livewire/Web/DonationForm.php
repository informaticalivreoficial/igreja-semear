<?php

namespace App\Livewire\Web;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Models\Donation;
use App\Services\Donations\DonationService;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use App\Services\Payments\PaymentService;
use App\Support\Money;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DonationForm extends Component
{
    public int $step = 1;

    public string $type = '';

    public string $amountInput = '';

    public float $amount = 0;

    public string $description = '';

    public bool $isAnonymous = false;

    public string $name = '';

    public string $email = '';

    public string $cpf = '';

    public string $paymentMethod = 'pix';

    public string $cardToken = '';

    public ?string $paymentMethodId = null;

    public ?int $donationId = null;

    public ?string $qrCode = null;

    public ?string $qrCodeImage = null;

    public ?string $pixCopyPaste = null;

    public bool $paid = false;

    public string $errorMessage = '';

    public bool $processing = false;

    protected $listeners = ['refreshPayment' => 'checkPayment'];

    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $this->name = $user->name;
        $this->email = $user->email;

        if ($user->member && $user->member->cpf) {
            $this->cpf = $user->member->cpf;
        }
    }

    public function selectType(string $type): void
    {
        if (! DonationTypeEnum::tryFrom($type)) {
            return;
        }

        $this->type = $type;
        $this->errorMessage = '';
        $this->step = 2;
    }

    public function selectAmount(string $value): void
    {
        $this->amountInput = $value;
        $this->updateAmount();
    }

    public function updatedAmountInput(): void
    {
        $this->updateAmount();
    }

    protected function updateAmount(): void
    {
        $this->amount = Money::normalize($this->amountInput);
    }

    public function nextStep(): void
    {
        $this->errorMessage = '';

        if ($this->step === 2 && ! $this->validateAmount()) {
            return;
        }

        if ($this->step === 3 && ! $this->validateIdentification()) {
            return;
        }

        $this->step++;
    }

    public function previousStep(): void
    {
        $this->errorMessage = '';

        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function selectPaymentMethod(string $method): void
    {
        if (PaymentMethodEnum::tryFrom($method)) {
            $this->paymentMethod = $method;
            $this->errorMessage = '';
        }
    }

    public function payWithCard(string $token, ?string $paymentMethodId = null): void
    {
        if ($this->paymentMethod !== PaymentMethodEnum::Card->value) {
            return;
        }

        $this->cardToken = $token;
        $this->paymentMethodId = $paymentMethodId;
        $this->createDonation();
    }

    public function createDonation(): void
    {
        if ($this->processing) {
            return;
        }

        if ($this->donationId) {
            $this->checkPayment();

            return;
        }

        if (! $this->validateAmount() || ! $this->validateIdentification()) {
            return;
        }

        $this->processing = true;
        $this->errorMessage = '';

        try {
            $donation = app(DonationService::class)->createDonation([
                'member_id' => auth()->user()?->member?->id,
                'type' => $this->type,
                'description' => $this->description,
                'amount' => $this->amount,
                'is_anonymous' => $this->isAnonymous,
            ]);

            $this->donationId = $donation->id;

            $payment = app(PaymentService::class)->processDonation(
                $donation,
                PaymentMethodEnum::from($this->paymentMethod),
                [
                    'name' => $this->isAnonymous ? null : $this->name,
                    'email' => $this->isAnonymous ? null : $this->email,
                    'cpf' => $this->isAnonymous ? null : preg_replace('/\D/', '', $this->cpf),
                ],
                ['token' => $this->cardToken, 'paymentMethodId' => $this->paymentMethodId],
            );

            $payload = $payment->gateway_payload ?? [];

            if ($payment->method === PaymentMethodEnum::Pix->value) {
                $this->qrCode = data_get($payload, 'qr_code') ?? data_get($payload, 'qr_codes.0.text');
                $this->qrCodeImage = data_get($payload, 'qr_code_image');
                $this->pixCopyPaste = $this->qrCode;
            }

            if ($payment->isPaid()) {
                $this->paid = true;
                $this->dispatch('toast', [
                    'type' => 'success',
                    'message' => 'Doação confirmada! Muito obrigado pela sua contribuição.',
                ]);
            }

            if ($payment->status === 'failed') {
                $this->errorMessage = $this->cardFailureMessage(
                    data_get($payload, 'status_detail') ?? data_get($payload, 'charges.0.payment_response.message')
                );
                $this->dispatch('toast', ['type' => 'error', 'message' => $this->errorMessage]);
            }

            if (
                $this->paymentMethod === PaymentMethodEnum::Card->value
                && ! $payment->isPaid()
                && $payment->status !== 'failed'
            ) {
                $this->dispatch('toast', [
                    'type' => 'info',
                    'message' => 'Pagamento em processamento. Assim que for aprovado, sua doação será confirmada.',
                ]);
            }
        } catch (PaymentGatewayException $e) {
            Log::error('Falha ao processar doação', ['donation_id' => $this->donationId, 'error' => $e->getMessage()]);
            $this->failDonation();
            $this->errorMessage = 'Não foi possível gerar o pagamento. Tente novamente em instantes.';
            $this->dispatch('toast', ['type' => 'error', 'message' => $this->errorMessage]);
        } catch (\Throwable $e) {
            Log::error('Erro inesperado na doação', ['error' => $e->getMessage()]);
            $this->failDonation();
            $this->errorMessage = 'Ocorreu um erro inesperado. Tente novamente.';
            $this->dispatch('toast', ['type' => 'error', 'message' => $this->errorMessage]);
        } finally {
            $this->processing = false;
        }
    }

    protected function failDonation(): void
    {
        if (! $this->donationId) {
            return;
        }

        $donation = Donation::find($this->donationId);

        if ($donation && ! $donation->isPaid()) {
            app(DonationService::class)->markFailed($donation);
        }
    }

    public function checkPayment(): void
    {
        if (! $this->donationId) {
            return;
        }

        $donation = Donation::with('payment')->find($this->donationId);

        if (! $donation) {
            return;
        }

        if ($donation->status === DonationStatusEnum::Paid->value) {
            $this->paid = true;
            $this->errorMessage = '';
        }
    }

    protected function validateAmount(): bool
    {
        if ($this->amount <= 0) {
            $this->errorMessage = 'Informe um valor maior que zero.';

            return false;
        }

        if ($this->amount < 1) {
            $this->errorMessage = 'O valor mínimo é R$ 1,00.';

            return false;
        }

        return true;
    }

    protected function validateIdentification(): bool
    {
        if ($this->isAnonymous) {
            return true;
        }

        if (mb_strlen(trim($this->name)) < 3) {
            $this->errorMessage = 'Informe o seu nome completo.';

            return false;
        }

        if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errorMessage = 'Informe um e-mail válido.';

            return false;
        }

        $cpf = preg_replace('/\D/', '', $this->cpf);

        if ($cpf !== '' && strlen($cpf) !== 11) {
            $this->errorMessage = 'CPF inválido.';

            return false;
        }

        return true;
    }

    protected function cardFailureMessage(?string $statusDetail): string
    {
        return match (strtoupper((string) $statusDetail)) {
            'DECLINED', 'REJECTED' => 'O cartão foi recusado pelo banco emissor.',
            'INSUFFICIENT_FUNDS', 'CC_REJECTED_INSUFFICIENT_AMOUNT' => 'Cartão sem limite disponível.',
            'EXPIRED_CARD' => 'Cartão vencido.',
            'INVALID_CARD', 'CC_REJECTED_CARD_ERROR' => 'Número do cartão inválido.',
            'CC_REJECTED_OTHER_REASON' => 'Não foi possível processar o cartão. Verifique os dados.',
            default => 'O pagamento não foi aprovado. Tente novamente.',
        };
    }

    public function restart(): void
    {
        $this->reset([
            'step', 'type', 'amountInput', 'amount', 'description', 'isAnonymous',
            'name', 'email', 'cpf', 'paymentMethod', 'cardToken', 'donationId',
            'qrCode', 'qrCodeImage', 'pixCopyPaste', 'paid', 'errorMessage',
        ]);

        $this->mount();
        $this->step = 1;
    }

    public function render()
    {
        $donation = $this->donationId ? Donation::find($this->donationId) : null;

        return view('livewire.web.donation-form', [
            'types' => DonationTypeEnum::labels(),
            'methods' => PaymentMethodEnum::labels(),
            'donation' => $donation,
        ])->extends('web.default.master.master');
    }
}