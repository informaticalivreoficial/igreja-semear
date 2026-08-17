<?php

namespace App\Services\Payments\PagBank;

use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Data\GatewayWebhook;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class PagBankGateway implements PaymentGatewayInterface
{
    public function name(): string
    {
        return 'pagbank';
    }

    protected function baseUrl(): string
    {
        return config('services.pagbank.sandbox', true)
            ? 'https://sandbox.api.pagseguro.com'
            : 'https://api.pagseguro.com';
    }

    protected function token(): string
    {
        return (string) config('services.pagbank.token');
    }

    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl())
            ->withToken($this->token())
            ->acceptJson()
            ->asJson()
            ->throw();
    }

    protected function ensureConfigured(): void
    {
        if ($this->token() === '') {
            throw new PaymentGatewayException('Credenciais do PagBank não configuradas.');
        }
    }

    public function find(string $gatewayId): GatewayPayment
    {
        try {
            $order = $this->client()->get("/orders/{$gatewayId}")->json();
        } catch (\Throwable $e) {
            throw $this->wrap($e, "Falha ao consultar pedido {$gatewayId}");
        }

        return $this->mapFromOrder($order);
    }

    public function cancel(string $gatewayId): GatewayPayment
    {
        try {
            $order = $this->client()->get("/orders/{$gatewayId}")->json();
        } catch (\Throwable $e) {
            throw $this->wrap($e, "Falha ao consultar pedido para cancelamento {$gatewayId}");
        }

        $chargeId = data_get($order, 'charges.0.id');

        if (! $chargeId) {
            throw new PaymentGatewayException("Cobrança não encontrada para o pedido {$gatewayId}.");
        }

        try {
            $charge = $this->client()->post("/charges/{$chargeId}/cancel")->json();
        } catch (\Throwable $e) {
            throw $this->wrap($e, "Falha ao cancelar cobrança {$chargeId}");
        }

        return $this->mapFromCharge($charge);
    }

    public function handleWebhook(string $event, array $payload): GatewayWebhook
    {
        $gatewayId = data_get($payload, 'id') ?? data_get($payload, 'charges.0.id');

        return new GatewayWebhook(
            event: $event,
            gatewayId: $gatewayId ? (string) $gatewayId : null,
            status: $this->statusFromCharge(data_get($payload, 'charges.0.status')),
            payload: $payload,
        );
    }

    protected function buildCustomer(GatewayCreateRequest $request): array
    {
        return array_filter([
            'name' => mb_substr(trim((string) $request->payerName), 0, 100) ?: 'Doador Igreja Semear',
            'email' => $request->payerEmail,
            'tax_id' => $request->payerCpf,
        ], fn ($value) => $value !== null && $value !== '');
    }

    protected function buildItems(GatewayCreateRequest $request): array
    {
        return [
            [
                'reference_id' => $request->externalReference,
                'name' => mb_substr($request->description, 0, 255) ?: 'Doação Igreja Semear',
                'quantity' => 1,
                'unit_amount' => (int) round($request->amount * 100),
            ],
        ];
    }

    protected function mapFromOrder(array $order): GatewayPayment
    {
        $charge = data_get($order, 'charges.0', []);

        return new GatewayPayment(
            gatewayId: (string) ($order['id'] ?? ''),
            status: $this->statusFromCharge(data_get($charge, 'status')),
            statusDetail: data_get($charge, 'payment_response.message'),
            paidAt: data_get($charge, 'paid_at') ? Carbon::parse(data_get($charge, 'paid_at')) : null,
            qrCode: data_get($order, 'qr_code') ?? data_get($order, 'qr_codes.0.text'),
            qrCodeBase64: data_get($order, 'qr_code_base64'),
            raw: $order,
        );
    }

    protected function mapFromCharge(array $charge): GatewayPayment
    {
        return new GatewayPayment(
            gatewayId: (string) ($charge['id'] ?? ''),
            status: $this->statusFromCharge(data_get($charge, 'status')),
            statusDetail: data_get($charge, 'payment_response.message'),
            paidAt: data_get($charge, 'paid_at') ? Carbon::parse(data_get($charge, 'paid_at')) : null,
            raw: $charge,
        );
    }

    protected function statusFromCharge(?string $status): string
    {
        return match ($status) {
            'PAID' => 'approved',
            'DECLINED' => 'rejected',
            'CANCELED' => 'cancelled',
            default => 'pending',
        };
    }

    protected function notificationUrl(): ?string
    {
        $appUrl = rtrim((string) config('app.url'), '/');
        $host = parse_url($appUrl, PHP_URL_HOST);

        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return null;
        }

        return $appUrl.'/webhooks/payments/pagbank';
    }

    protected function wrap(\Throwable $e, string $message): PaymentGatewayException
    {
        $status = null;
        $body = null;

        if ($e instanceof \Illuminate\Http\Client\RequestException) {
            $status = $e->response->status();
            $body = $e->response->body();
        }

        Log::error($message, [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'status_code' => $status,
            'response' => $body,
        ]);

        return new PaymentGatewayException($message, 0, $e);
    }
}