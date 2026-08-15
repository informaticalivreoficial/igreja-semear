<?php

namespace App\Services\Payments\Contracts;

use App\Services\Payments\Data\GatewayCreateRequest;
use App\Services\Payments\Data\GatewayPayment;
use App\Services\Payments\Data\GatewayWebhook;

interface PaymentGatewayInterface
{
    public function name(): string;

    public function create(GatewayCreateRequest $request): GatewayPayment;

    public function find(string $gatewayId): GatewayPayment;

    public function cancel(string $gatewayId): GatewayPayment;

    public function handleWebhook(string $event, array $payload): GatewayWebhook;
}
