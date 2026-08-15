<?php

namespace Tests\Feature;

use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Models\Config;
use App\Models\User;
use App\Notifications\NewAtendimento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AtendimentoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Semear Teste',
            'email' => 'igreja@teste.com',
        ]);

        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nome' => 'João da Silva',
            'email' => 'joao@exemplo.com',
            'phone' => '(11) 99999-9999',
            'mensagem' => 'Gostaria de saber os horários dos cultos.',
            'privacy' => '1',
        ], $overrides);
    }

    public function test_valid_submission_sends_emails_and_notifies_admins(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->get('/sendEmail?'.http_build_query($this->payload()))
            ->assertOk()
            ->assertJsonPath('sucess', 'Obrigado João da Silva, sua mensagem foi enviada com sucesso!');

        Mail::assertSent(Atendimento::class);
        Mail::assertSent(AtendimentoRetorno::class);

        Notification::assertSentTo($admin, NewAtendimento::class);
    }

    public function test_invalid_phone_is_rejected(): void
    {
        Mail::fake();
        Notification::fake();

        $this->get('/sendEmail?'.http_build_query($this->payload(['phone' => '12345'])))
            ->assertOk()
            ->assertJson(['error' => 'Informe um <strong>Telefone</strong> válido: (00) 00000-0000.']);

        Mail::assertNothingSent();
    }

    public function test_privacy_is_required(): void
    {
        Mail::fake();
        Notification::fake();

        $this->get('/sendEmail?'.http_build_query($this->payload(['privacy' => null])))
            ->assertOk()
            ->assertJson(['error' => 'É necessário concordar com a <strong>Política de Privacidade</strong>.']);

        Mail::assertNothingSent();
    }

    public function test_honeypot_blocks_spam(): void
    {
        Mail::fake();
        Notification::fake();

        $this->get('/sendEmail?'.http_build_query($this->payload(['bairro' => 'spam'])))
            ->assertOk()
            ->assertJson(['error' => '<strong>ERRO</strong> Você está praticando SPAM!']);

        Mail::assertNothingSent();
    }
}