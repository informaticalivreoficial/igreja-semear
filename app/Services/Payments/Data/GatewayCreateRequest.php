<?php

namespace App\Services\Payments\Data;

class GatewayCreateRequest
{
    public function __construct(
        public readonly float $amount,
        public readonly string $description,
        public readonly string $externalReference,
        public readonly ?string $payerName = null,
        public readonly ?string $payerEmail = null,
        public readonly ?string $payerCpf = null,
        public readonly ?string $token = null,
        public readonly ?int $installments = 1,
        public readonly ?array $metadata = [],
    ) {
    }
}
