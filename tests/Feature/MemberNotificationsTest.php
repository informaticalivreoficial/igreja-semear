<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use App\Notifications\NewEventRegistration;
use App\Notifications\NewPrayerRequest;
use Database\Seeders\RolesAndPermissionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MemberNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Semear Teste',
            'template' => 'default',
            'email' => 'igreja@teste.com',
        ]);

        $this->seed(RolesAndPermissionsTableSeeder::class);
    }

    private function makeMemberUser(): User
    {
        $user = User::factory()->create();
        Member::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'cell_phone' => $user->cell_phone,
            'birthday' => '10/05/1990',
            'status' => 1,
        ]);

        return $user;
    }

    private function makeAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        return $admin;
    }

    public function test_store_oracao_notifies_admins(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = $this->makeAdmin();
        $member = $this->makeMemberUser();

        $this->actingAs($member)
            ->from('/minha-conta/oracoes')
            ->post('/minha-conta/oracoes', ['message' => 'Peço oração pela minha família e pela igreja.'])
            ->assertSessionHas('toast');

        $this->assertDatabaseHas('prayer_requests', [
            'member_id' => $member->member->id,
            'name' => $member->name,
        ]);

        Notification::assertSentTo($admin, NewPrayerRequest::class);
    }

    public function test_inscrever_notifies_admins(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = $this->makeAdmin();
        $member = $this->makeMemberUser();

        $event = Event::create([
            'title' => 'Culto de Celebração',
            'slug' => 'culto-celebracao-notificacao',
            'type' => 'culto',
            'start_at' => now()->addDays(5),
            'status' => 1,
            'created_by' => $admin->id,
        ]);

        $this->actingAs($member)
            ->from('/minha-conta/agenda')
            ->post('/minha-conta/inscrever', ['event_id' => $event->id])
            ->assertSessionHas('toast');

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'member_id' => $member->member->id,
            'status' => 'pendente',
        ]);

        Notification::assertSentTo($admin, NewEventRegistration::class);
    }

    public function test_member_sidebar_hides_familia_and_contribuicoes(): void
    {
        $member = $this->makeMemberUser();

        $this->actingAs($member)
            ->get('/minha-conta/perfil')
            ->assertOk()
            ->assertDontSee('Minha família')
            ->assertDontSee('Contribuições')
            ->assertSee('Minhas inscrições');
    }
}
