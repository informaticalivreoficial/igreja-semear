<?php

namespace App\Services\Payments\MercadoPago;

use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoPixGateway extends MercadoPagoGateway
{
    public function create(GatewayCreateRequest $request): GatewayPayment
    {
        $data = $this->buildRequest($request);
        $data['payment_method_id'] = 'pix';
        $data['date_of_expiration'] = now()->addMinutes(30)->format('Y-m-d\TH:i:s.000-03:00');

        try {
            $payment = $this->client()->create($data);
        } catch (MPApiException $e) {
            throw $this->wrap($e, 'Falha ao criar cobrança PIX');
        }

        return $this->map($payment);
    }
}
