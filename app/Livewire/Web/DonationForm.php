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

    public ?int $donationId = null;

    public ?string $qrCode = null;

    public ?string $qrCodeBase64 = null;

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

        if ($this->step === 4 && $this->paymentMethod === PaymentMethodEnum::Pix->value) {
            $this->createDonation();
        }
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

    public function payWithCard(string $token): void
    {
        if ($this->paymentMethod !== PaymentMethodEnum::Card->value) {
            return;
        }

        $this->cardToken = $token;
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
                ['token' => $this->cardToken],
            );

            $payload = $payment->gateway_payload ?? [];

            if ($payment->method === PaymentMethodEnum::Pix->value) {
                $this->qrCode = data_get($payload, 'point_of_interaction.transaction_data.qr_code');
                $this->qrCodeBase64 = data_get($payload, 'point_of_interaction.transaction_data.qr_code_base64');
                $this->pixCopyPaste = data_get($payload, 'point_of_interaction.transaction_data.qr_code');
            }

            if ($payment->isPaid()) {
                $this->paid = true;
            }

            if ($payment->status === 'failed') {
                $this->errorMessage = $this->cardFailureMessage(data_get($payload, 'status_detail'));
            }
        } catch (PaymentGatewayException $e) {
            Log::error('Falha ao processar doação', ['donation_id' => $this->donationId, 'error' => $e->getMessage()]);
            $this->failDonation();
            $this->errorMessage = 'Não foi possível gerar o pagamento. Tente novamente em instantes.';
        } catch (\Throwable $e) {
            Log::error('Erro inesperado na doação', ['error' => $e->getMessage()]);
            $this->failDonation();
            $this->errorMessage = 'Ocorreu um erro inesperado. Tente novamente.';
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
        return match ($statusDetail) {
            'cc_rejected_insufficient_amount' => 'Cartão sem limite disponível.',
            'cc_rejected_other_reason', 'cc_rejected_card_error' => 'Não foi possível processar o cartão. Verifique os dados.',
            default => 'O pagamento não foi aprovado. Tente novamente.',
        };
    }

    public function restart(): void
    {
        $this->reset([
            'step', 'type', 'amountInput', 'amount', 'description', 'isAnonymous',
            'name', 'email', 'cpf', 'paymentMethod', 'cardToken', 'donationId',
            'qrCode', 'qrCodeBase64', 'pixCopyPaste', 'paid', 'errorMessage',
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