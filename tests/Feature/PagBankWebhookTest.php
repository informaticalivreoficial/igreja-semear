<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PagBankWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_unsupported_gateway_returns_404(): void
    {
        $this->postJson('/webhooks/payments/outro')
            ->assertNotFound();
    }

    public function test_pagbank_webhook_with_invalid_signature_returns_401(): void
    {
        config()->set('services.pagbank.token', 'tok123');

        $payload = ['id' => 'ORDE_TESTE', 'charges' => [['id' => 'CHAR_1', 'status' => 'PAID']]];

        $this->withHeader('x-authenticity-token', 'hash-invalido')
            ->postJson('/webhooks/payments/pagbank', $payload)
            ->assertUnauthorized();
    }

    public function test_pagbank_webhook_with_valid_signature_returns_200(): void
    {
        config()->set('services.pagbank.token', 'tok123');

        $payload = ['id' => 'ORDE_TESTE', 'charges' => [['id' => 'CHAR_1', 'status' => 'PAID']]];

        $signature = hash('sha256', 'tok123-'.json_encode($payload));

        $this->withHeader('x-authenticity-token', $signature)
            ->postJson('/webhooks/payments/pagbank', $payload)
            ->assertOk()
            ->assertJson(['received' => true]);
    }

    public function test_webhook_marks_payment_as_paid(): void
    {
        Http::fake([
            '*/orders/ORDE_TESTE' => Http::response([
                'id' => 'ORDE_TESTE',
                'charges' => [[
                    'id' => 'CHAR_1',
                    'status' => 'PAID',
                    'paid_at' => '2026-08-16T10:00:00-03:00',
                ]],
            ], 200),
        ]);

        $donation = Donation::factory()->create(['status' => 'pending']);

        $payment = Payment::create([
            'payable_type' => Donation::class,
            'payable_id' => $donation->id,
            'amount' => 50.0,
            'method' => 'pix',
            'status' => 'pending',
            'gateway' => 'pagbank_pix',
            'gateway_id' => 'ORDE_TESTE',
        ]);

        $this->postJson('/webhooks/payments/pagbank', [
            'id' => 'ORDE_TESTE',
            'charges' => [['id' => 'CHAR_1', 'status' => 'PAID']],
        ])->assertOk();

        $this->assertTrue($payment->refresh()->isPaid());
        $this->assertEquals('paid', $donation->refresh()->status);
    }
}