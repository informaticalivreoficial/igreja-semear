<?php

namespace App\Http\Controllers\Webhook;

use App\Services\Payments\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Webhook\WebhookSignatureValidator;

class PaymentWebhookController
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function __invoke(Request $request, string $gateway): JsonResponse
    {
        if ($gateway !== 'mercadopago') {
            return response()->json(['error' => 'Gateway não suportado.'], 404);
        }

        try {
            $this->verifySignature($request);
        } catch (\Throwable $e) {
            Log::warning('Webhook com assinatura inválida', ['message' => $e->getMessage()]);

            return response()->json(['error' => 'Assinatura inválida.'], 401);
        }

        $this->paymentService->handleWebhook($gateway, (string) $request->input('type'), $request->all());

        return response()->json(['received' => true]);
    }

    protected function verifySignature(Request $request): void
    {
        $secret = (string) config('services.mercadopago.webhook_secret');

        if ($secret === '' || blank($request->header('x-signature'))) {
            // Notificações de QR Code PIX não são assinadas; o status real é sempre
            // confirmado via consulta ao gateway dentro do PaymentService.
            return;
        }

        WebhookSignatureValidator::validate(
            $request->header('x-signature'),
            $request->header('x-request-id'),
            $request->query('data.id'),
            $secret,
            5 * 60,
        );
    }
}
