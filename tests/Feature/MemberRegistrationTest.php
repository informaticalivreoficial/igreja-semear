<?php

namespace Tests\Feature;

use App\Mail\Web\CreateMember;
use App\Models\User;
use App\Notifications\NewMemberRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MemberRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'João da Silva',
            'birthday' => '10/05/1990',
            'gender' => 'masculino',
            'email' => 'joao@exemplo.com',
            'whatsapp' => '(11) 99999-9999',
            'civil_status' => 'solteiro',
            'baptism' => 'false',
            'bairro' => '',
            'cidade' => '',
        ], $overrides);
    }

    public function test_registration_creates_user_and_member(): void
    {
        Mail::fake();
        Notification::fake();

        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);

        $this->get('/cadastro-novo-membro-send?'.http_build_query($this->payload()))
            ->assertOk()
            ->assertJsonFragment(['cadastro' => 'Cadastro realizado com sucesso!']);

        $this->assertDatabaseHas('users', ['email' => 'joao@exemplo.com', 'baptism' => 0]);

        $user = User::where('email', 'joao@exemplo.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('member'));
        $this->assertNotNull($user->member);
        $this->assertDatabaseHas('members', ['user_id' => $user->id]);

        Mail::assertSent(CreateMember::class, 1);
    }

    public function test_registration_notifies_admins_via_database(): void
    {
        Mail::fake();
        Notification::fake();

        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->get('/cadastro-novo-membro-send?'.http_build_query($this->payload()))
            ->assertOk();

        Notification::assertSentTo($admin, NewMemberRegistered::class);
    }

    public function test_registration_rejects_invalid_birthday_format(): void
    {
        Mail::fake();
        Notification::fake();

        $this->get('/cadastro-novo-membro-send?'.http_build_query($this->payload(['birthday' => '1990-05-10'])))
            ->assertOk()
            ->assertJson(['error' => 'Informe uma <strong>Data de Nascimento</strong> válida (dd/mm/aaaa).']);

        $this->assertDatabaseMissing('users', ['email' => 'joao@exemplo.com']);
    }
}