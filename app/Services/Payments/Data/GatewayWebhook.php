<?php

namespace App\Services\Payments\Data;

class GatewayWebhook
{
    public function __construct(
        public readonly string $event,
        public readonly ?string $gatewayId,
        public readonly string $status,
        public readonly array $payload,
    ) {
    }
}
