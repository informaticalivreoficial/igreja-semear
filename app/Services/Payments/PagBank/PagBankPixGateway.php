<?php

namespace App\Services\Payments\PagBank;

use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;

class PagBankPixGateway extends PagBankGateway
{
    public function create(GatewayCreateRequest $request): GatewayPayment
    {
        $this->ensureConfigured();

        $data = [
            'reference_id' => $request->externalReference,
            'customer' => $this->buildCustomer($request),
            'items' => $this->buildItems($request),
            'qr_codes' => [
                [
                    'amount' => ['value' => (int) round($request->amount * 100)],
                    'expiration_date' => now()->addMinutes(30)->format('Y-m-d\TH:i:s-03:00'),
                ],
            ],
        ];

        if ($notificationUrl = $this->notificationUrl()) {
            $data['notification_urls'] = [$notificationUrl];
        }

        try {
            $order = $this->client()->post('/orders', $data)->json();
        } catch (\Throwable $e) {
            throw $this->wrap($e, 'Falha ao criar cobrança PIX');
        }

        $order['qr_code'] = data_get($order, 'qr_codes.0.text');
        $order['qr_code_image'] = $this->qrCodeImageUrl(data_get($order, 'qr_codes.0.links'));

        return $this->mapFromOrder($order);
    }

    protected function qrCodeImageUrl(?array $links): ?string
    {
        foreach ($links ?? [] as $link) {
            if (($link['rel'] ?? '') === 'QRCODE.PNG') {
                return $link['href'] ?? null;
            }
        }

        return null;
    }
}