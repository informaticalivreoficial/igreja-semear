<?php

namespace App\Services\Payments\Data;

use DateTimeInterface;

class GatewayPayment
{
    public function __construct(
        public readonly string $gatewayId,
        public readonly string $status,
        public readonly ?string $statusDetail = null,
        public readonly ?DateTimeInterface $paidAt = null,
        public readonly ?string $qrCode = null,
        public readonly ?string $qrCodeBase64 = null,
        public readonly array $raw = [],
    ) {
    }
}
