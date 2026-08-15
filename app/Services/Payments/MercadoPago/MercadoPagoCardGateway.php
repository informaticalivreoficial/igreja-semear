<?php

namespace App\Services\Payments\MercadoPago;

use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Exceptions\PaymentGatewayException;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoCardGateway extends MercadoPagoGateway
{
    public function create(GatewayCreateRequest $request): GatewayPayment
    {
        if (blank($request->token)) {
            throw new PaymentGatewayException('Token do cartão não informado.');
        }

        $data = $this->buildRequest($request);
        $data['payment_method_id'] = 'card';
        $data['token'] = $request->token;
        $data['installments'] = $request->installments ?? 1;

        try {
            $payment = $this->client()->create($data);
        } catch (MPApiException $e) {
            throw $this->wrap($e, 'Falha ao processar pagamento com cartão');
        }

        return $this->map($payment);
    }
}
