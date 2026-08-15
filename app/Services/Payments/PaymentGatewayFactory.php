<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethodEnum;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\MercadoPago\MercadoPagoCardGateway;
use App\Services\Payments\MercadoPago\MercadoPagoPixGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    public static function for(PaymentMethodEnum $method): PaymentGatewayInterface
    {
        return match ($method) {
            PaymentMethodEnum::Pix => app(MercadoPagoPixGateway::class),
            PaymentMethodEnum::Card => app(MercadoPagoCardGateway::class),
        };
    }

    public static function byName(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'mercadopago_pix' => app(MercadoPagoPixGateway::class),
            'mercadopago_card' => app(MercadoPagoCardGateway::class),
            default => throw new InvalidArgumentException("Gateway não suportado: {$gateway}"),
        };
    }
}
