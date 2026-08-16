<?php

namespace Tests\Feature;

use App\Livewire\Components\SupportModal;
use App\Mail\Admin\SupportRequestMail;
use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class SupportModalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::create([
            'id' => 1,
            'app_name' => 'Semear',
        ]);
    }

    public function test_open_listener_shows_modal(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(SupportModal::class)
            ->dispatch('open-support-modal')
            ->assertSet('showSupport', true);
    }

    public function test_send_support_sends_email_to_developer(): void
    {
        Mail::fake();

        $user = User::factory()->create(['name' => 'João Teste', 'email' => 'joao@example.com']);
        $this->actingAs($user);

        Livewire::test(SupportModal::class)
            ->set('message', 'Preciso de ajuda com o painel.')
            ->call('sendSupport')
            ->assertHasNoErrors();

        Mail::assertSent(SupportRequestMail::class, function (SupportRequestMail $mail) use ($user) {
            $this->assertStringContainsString('Preciso de ajuda com o painel.', $mail->data['mensagem']);
            $this->assertSame('João Teste', $mail->data['user_name']);
            $this->assertSame('joao@example.com', $mail->data['user_email']);

            return true;
        });
    }

    public function test_send_support_requires_message(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(SupportModal::class)
            ->set('message', 'curto')
            ->call('sendSupport')
            ->assertHasErrors(['message' => 'min']);

        Mail::assertNothingSent();
    }
}