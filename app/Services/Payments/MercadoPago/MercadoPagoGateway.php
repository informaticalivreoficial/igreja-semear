<?php

namespace App\Services\Payments\MercadoPago;

use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Data\GatewayWebhook;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

abstract class MercadoPagoGateway implements PaymentGatewayInterface
{
    protected function client(): PaymentClient
    {
        MercadoPagoConfig::setAccessToken((string) config('services.mercadopago.token'));

        return new PaymentClient;
    }

    public function name(): string
    {
        return 'mercadopago';
    }

    public function find(string $gatewayId): GatewayPayment
    {
        try {
            $payment = $this->client()->get((int) $gatewayId);
        } catch (MPApiException $e) {
            throw $this->wrap($e, "Falha ao consultar pagamento {$gatewayId}");
        }

        return $this->map($payment);
    }

    public function cancel(string $gatewayId): GatewayPayment
    {
        try {
            $payment = $this->client()->cancel((int) $gatewayId);
        } catch (MPApiException $e) {
            throw $this->wrap($e, "Falha ao cancelar pagamento {$gatewayId}");
        }

        return $this->map($payment);
    }

    public function handleWebhook(string $event, array $payload): GatewayWebhook
    {
        $gatewayId = data_get($payload, 'data.id');

        return new GatewayWebhook(
            event: $event,
            gatewayId: $gatewayId ? (string) $gatewayId : null,
            status: $this->statusFromEvent($event),
            payload: $payload,
        );
    }

    protected function statusFromEvent(string $event): string
    {
        return match ($event) {
            'payment.created' => 'pending',
            'payment.updated' => 'updated',
            'payment.approved' => 'approved',
            'payment.rejected' => 'rejected',
            'payment.cancelled' => 'cancelled',
            'payment.refunded' => 'refunded',
            default => 'unknown',
        };
    }

    protected function buildRequest(GatewayCreateRequest $request): array
    {
        return [
            'transaction_amount' => round($request->amount, 2),
            'description' => mb_substr($request->description, 0, 255),
            'external_reference' => $request->externalReference,
            'notification_url' => $this->notificationUrl(),
            'metadata' => array_merge($request->metadata ?? [], [
                'donation_reference' => $request->externalReference,
            ]),
            'payer' => [
                'email' => $request->payerEmail,
                'first_name' => $request->payerName,
                'identification' => $request->payerCpf ? [
                    'type' => 'CPF',
                    'number' => $request->payerCpf,
                ] : null,
            ],
        ];
    }

    protected function map(mixed $payment): GatewayPayment
    {
        $transactionData = $payment->point_of_interaction?->transaction_data ?? null;

        return new GatewayPayment(
            gatewayId: (string) $payment->id,
            status: $payment->status ?? 'pending',
            statusDetail: $payment->status_detail ?? null,
            paidAt: $payment->date_approved ? Carbon::parse($payment->date_approved) : null,
            qrCode: $transactionData->qr_code ?? null,
            qrCodeBase64: $transactionData->qr_code_base64 ?? null,
            raw: json_decode(json_encode($payment), true) ?? [],
        );
    }

    protected function notificationUrl(): string
    {
        return url('/webhooks/payments/mercadopago');
    }

    protected function wrap(MPApiException $e, string $message): PaymentGatewayException
    {
        Log::error($message, [
            'status_code' => $e->getStatusCode(),
            'response' => $e->getApiResponse()?->getContent(),
        ]);

        return new PaymentGatewayException($message, 0, $e);
    }
}
