<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Donation;
use App\Models\Payment;
use App\Services\Donations\DonationService;
use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        private readonly PaymentGatewayFactory $factory,
        private readonly DonationService $donationService,
    ) {
    }

    public function processDonation(Donation $donation, PaymentMethodEnum $method, array $payer, array $options = []): Payment
    {
        return DB::transaction(function () use ($donation, $method, $payer, $options) {
            $payment = Payment::create([
                'payable_type' => Donation::class,
                'payable_id' => $donation->id,
                'amount' => $donation->amount,
                'method' => $method->value,
                'status' => PaymentStatusEnum::Pending->value,
                'gateway' => 'mercadopago_'.$method->value,
            ]);

            $this->donationService->attachPayment($donation, $payment);

            try {
                $result = $this->initiate($payment, $method, $payer, $options);
            } catch (PaymentGatewayException $e) {
                $payment->markAsFailed();
                $this->donationService->syncFromPayment($donation, $payment);
                throw $e;
            }

            if ($payment->status === PaymentStatusEnum::Failed->value) {
                $this->donationService->syncFromPayment($donation, $payment);
            }

            return $payment->refresh();
        });
    }

    public function initiate(Payment $payment, PaymentMethodEnum $method, array $payer, array $options = []): GatewayPayment
    {
        $gateway = $this->factory->for($method);

        $request = new GatewayCreateRequest(
            amount: (float) $payment->amount,
            description: $this->describe($payment),
            externalReference: $payment->uuid,
            payerName: $payer['name'] ?? null,
            payerEmail: $payer['email'] ?? null,
            payerCpf: $payer['cpf'] ?? null,
            token: $options['token'] ?? null,
            installments: $options['installments'] ?? 1,
            metadata: ['payment_uuid' => $payment->uuid],
        );

        $result = $gateway->create($request);

        $payment->gateway_id = $result->gatewayId;
        $payment->gateway_reference = $request->externalReference;
        $payment->gateway_payload = $result->raw;
        $payment->method = $method->value;
        $payment->gateway = $gateway->name().'_'.$method->value;

        $this->applyGatewayStatus($payment, $result);

        return $result;
    }

    public function handleWebhook(string $gatewayName, string $event, array $payload): void
    {
        $gateway = $this->factory->byName($gatewayName);
        $webhook = $gateway->handleWebhook($event, $payload);

        if (! $webhook->gatewayId) {
            Log::warning('Webhook sem gateway_id', ['gateway' => $gatewayName, 'payload' => $payload]);

            return;
        }

        $payment = Payment::query()->byGatewayId($webhook->gatewayId)->first();

        if (! $payment) {
            Log::warning('Pagamento não encontrado para webhook', ['gateway_id' => $webhook->gatewayId]);

            return;
        }

        if ($payment->isPaid()) {
            return;
        }

        try {
            $result = $gateway->find($webhook->gatewayId);
        } catch (PaymentGatewayException $e) {
            Log::error('Falha ao consultar pagamento no webhook', ['gateway_id' => $webhook->gatewayId]);

            return;
        }

        $payment->gateway_payload = $result->raw;
        $this->applyGatewayStatus($payment, $result);
    }

    public function refresh(Payment $payment): void
    {
        if (! $payment->gateway_id) {
            return;
        }

        $gateway = $this->factory->byName($payment->gateway);
        $result = $gateway->find($payment->gateway_id);

        $payment->gateway_payload = $result->raw;
        $this->applyGatewayStatus($payment, $result);
    }

    public function cancel(Payment $payment): void
    {
        if (! $payment->gateway_id) {
            $payment->markAsCancelled();
            $this->syncPayable($payment);

            return;
        }

        $gateway = $this->factory->byName($payment->gateway);
        $result = $gateway->cancel($payment->gateway_id);

        $payment->gateway_payload = $result->raw;
        $this->applyGatewayStatus($payment, $result);
    }

    protected function applyGatewayStatus(Payment $payment, GatewayPayment $result): void
    {
        match ($result->status) {
            'approved' => $payment->markAsPaid($result->paidAt),
            'rejected' => $payment->markAsFailed(),
            'cancelled' => $payment->markAsCancelled(),
            'refunded' => $payment->markAsRefunded(),
            default => null,
        };

        $payment->save();
        $this->syncPayable($payment);
    }

    protected function syncPayable(Payment $payment): void
    {
        if ($payment->payable instanceof Donation) {
            $this->donationService->syncFromPayment($payment->payable, $payment);
        }
    }

    protected function describe(Payment $payment): string
    {
        if ($payment->payable instanceof Donation) {
            return 'Doação - '.$payment->payable->type_label.' - Igreja Semear';
        }

        return 'Pagamento - Igreja Semear';
    }
}
