<?php

namespace App\Services\Payments\PagBank;

use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Exceptions\PaymentGatewayException;

class PagBankCardGateway extends PagBankGateway
{
    public function create(GatewayCreateRequest $request): GatewayPayment
    {
        $this->ensureConfigured();

        if (blank($request->token)) {
            throw new PaymentGatewayException('Dados do cartão não informados.');
        }

        $data = [
            'reference_id' => $request->externalReference,
            'customer' => $this->buildCustomer($request),
            'items' => $this->buildItems($request),
            'charges' => [
                [
                    'reference_id' => $request->externalReference,
                    'description' => mb_substr($request->description, 0, 255) ?: 'Doação Igreja Semear',
                    'amount' => [
                        'value' => (int) round($request->amount * 100),
                        'currency' => config('services.pagbank.currency', 'BRL'),
                    ],
                    'payment_method' => [
                        'type' => 'CREDIT_CARD',
                        'installments' => $request->installments ?? 1,
                        'capture' => true,
                        'soft_descriptor' => 'IGREJA SEMEAR',
                        'card' => [
                            'encrypted' => $request->token,
                            'store' => false,
                        ],
                        'holder' => [
                            'name' => mb_substr(trim((string) $request->payerName), 0, 100) ?: 'Doador Igreja Semear',
                            'tax_id' => $request->payerCpf,
                        ],
                    ],
                ],
            ],
        ];

        if ($notificationUrl = $this->notificationUrl()) {
            $data['notification_urls'] = [$notificationUrl];
        }

        try {
            $order = $this->client()->post('/orders', $data)->json();
        } catch (\Throwable $e) {
            throw $this->wrap($e, 'Falha ao processar pagamento com cartão');
        }

        return $this->mapFromOrder($order);
    }
}