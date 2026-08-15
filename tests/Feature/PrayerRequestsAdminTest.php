<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\PrayerRequests\PrayerRequests;
use App\Mail\Web\PrayerRequestAnswer;
use App\Models\Config;
use App\Models\PrayerRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class PrayerRequestsAdminTest extends TestCase
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

    private function makeAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        return $admin;
    }

    public function test_answering_sends_email_only_and_marks_as_responded(): void
    {
        Mail::fake();

        $this->actingAs($this->makeAdmin());

        $prayer = PrayerRequest::create([
            'name' => 'João da Silva',
            'email' => 'joao@exemplo.com',
            'phone' => '(11) 99999-9999',
            'message' => 'Peço oração pela minha família.',
            'status' => PrayerRequest::STATUS_PENDENTE,
        ]);

        Livewire::test(PrayerRequests::class)
            ->call('openAnswer', $prayer->id)
            ->set('answer', 'Estamos em oração por você e sua família!')
            ->call('saveAnswer')
            ->assertHasNoErrors();

        Mail::assertSent(PrayerRequestAnswer::class, function ($mail) {
            return $mail->hasTo('joao@exemplo.com');
        });

        $this->assertDatabaseHas('prayer_requests', [
            'id' => $prayer->id,
            'status' => PrayerRequest::STATUS_RESPONDIDO,
            'answer' => null,
        ]);
    }

    public function test_answering_without_email_keeps_pending_and_does_not_send(): void
    {
        Mail::fake();

        $this->actingAs($this->makeAdmin());

        $prayer = PrayerRequest::create([
            'name' => 'Sem E-mail',
            'email' => null,
            'phone' => null,
            'message' => 'Peço oração.',
            'status' => PrayerRequest::STATUS_PENDENTE,
        ]);

        Livewire::test(PrayerRequests::class)
            ->call('openAnswer', $prayer->id)
            ->set('answer', 'Resposta de teste')
            ->call('saveAnswer');

        Mail::assertNothingSent();

        $this->assertDatabaseHas('prayer_requests', [
            'id' => $prayer->id,
            'status' => PrayerRequest::STATUS_PENDENTE,
        ]);
    }
}