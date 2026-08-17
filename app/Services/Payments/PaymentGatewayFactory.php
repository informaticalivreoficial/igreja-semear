<?php

namespace App\Services\Payments;

use App\Enums\PaymentMethodEnum;
use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\MercadoPago\MercadoPagoCardGateway;
use App\Services\Payments\MercadoPago\MercadoPagoPixGateway;
use App\Services\Payments\PagBank\PagBankCardGateway;
use App\Services\Payments\PagBank\PagBankPixGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    public static function for(PaymentMethodEnum $method): PaymentGatewayInterface
    {
        return match ($method) {
            PaymentMethodEnum::Pix => app(PagBankPixGateway::class),
            PaymentMethodEnum::Card => app(PagBankCardGateway::class),
        };
    }

    public static function byName(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'pagbank_pix' => app(PagBankPixGateway::class),
            'pagbank_card' => app(PagBankCardGateway::class),
            // Legado (retorno fácil ao Mercado Pago sem migração de dados).
            'mercadopago_pix' => app(MercadoPagoPixGateway::class),
            'mercadopago_card' => app(MercadoPagoCardGateway::class),
            default => throw new InvalidArgumentException("Gateway não suportado: {$gateway}"),
        };
    }

    public static function byWebhook(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'pagbank' => app(PagBankPixGateway::class),
            'mercadopago' => app(MercadoPagoPixGateway::class),
            default => throw new InvalidArgumentException("Gateway não suportado: {$gateway}"),
        };
    }
}