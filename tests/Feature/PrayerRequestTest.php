<?php

namespace Tests\Feature;

use App\Livewire\Web\PrayerRequest;
use App\Mail\Web\PrayerRequest as PrayerRequestMail;
use App\Models\Config;
use App\Models\User;
use App\Notifications\NewPrayerRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class PrayerRequestTest extends TestCase
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

    public function test_valid_submission_creates_prayer_request_and_notifies_admins(): void
    {
        Mail::fake();
        Notification::fake();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Livewire::test(PrayerRequest::class)
            ->set('name', 'João da Silva')
            ->set('email', 'joao@exemplo.com')
            ->set('phone', '(11) 99999-9999')
            ->set('message', 'Peço oração pela minha família e saúde.')
            ->set('privacy', true)
            ->call('send')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('prayer_requests', ['email' => 'joao@exemplo.com']);

        Mail::assertSent(PrayerRequestMail::class);
        Notification::assertSentTo($admin, NewPrayerRequest::class);
    }

    public function test_invalid_phone_is_rejected(): void
    {
        Mail::fake();
        Notification::fake();

        Livewire::test(PrayerRequest::class)
            ->set('name', 'João da Silva')
            ->set('email', 'joao@exemplo.com')
            ->set('phone', '12345')
            ->set('message', 'Peço oração pela minha família e saúde.')
            ->set('privacy', true)
            ->call('send')
            ->assertHasErrors(['phone']);
    }

    public function test_requires_privacy_acceptance(): void
    {
        Mail::fake();
        Notification::fake();

        Livewire::test(PrayerRequest::class)
            ->set('name', 'João da Silva')
            ->set('email', 'joao@exemplo.com')
            ->set('message', 'Peço oração pela minha família e saúde.')
            ->call('send')
            ->assertHasErrors(['privacy']);
    }
}