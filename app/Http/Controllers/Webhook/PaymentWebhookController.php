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
        if (! in_array($gateway, ['pagbank', 'mercadopago'])) {
            return response()->json(['error' => 'Gateway não suportado.'], 404);
        }

        try {
            $this->verifySignature($request, $gateway);
        } catch (\Throwable $e) {
            Log::warning('Webhook com assinatura inválida', ['gateway' => $gateway, 'message' => $e->getMessage()]);

            return response()->json(['error' => 'Assinatura inválida.'], 401);
        }

        $this->paymentService->handleWebhook($gateway, (string) $request->input('type', 'payment'), $request->all());

        return response()->json(['received' => true]);
    }

    protected function verifySignature(Request $request, string $gateway): void
    {
        if ($gateway === 'pagbank') {
            $this->verifyPagBankSignature($request);

            return;
        }

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

    protected function verifyPagBankSignature(Request $request): void
    {
        $token = (string) config('services.pagbank.token');
        $header = $request->header('x-authenticity-token');

        if ($token === '' || blank($header)) {
            // Sem credenciais/assinatura o status real é confirmado via consulta ao
            // gateway dentro do PaymentService.
            return;
        }

        $expected = hash('sha256', $token.'-'.$request->getContent());

        if (! hash_equals($expected, $header)) {
            throw new \RuntimeException('Assinatura PagBank inválida.');
        }
    }
}
