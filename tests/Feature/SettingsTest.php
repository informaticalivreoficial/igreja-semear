<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Settings;
use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_settings_normalizes_iso_serialized_date(): void
    {
        Config::create([
            'id' => 1,
            'app_name' => 'Semear Teste',
            'init_date' => '2016-08-14',
        ]);

        $this->actingAs(User::factory()->create());

        Livewire::test(Settings::class)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', ['id' => 1, 'init_date' => '2016-08-14']);
    }

    public function test_update_persists_new_config_fields(): void
    {
        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        $this->actingAs(User::factory()->create());

        Livewire::test(Settings::class)
            ->set('configData.telegram', 'https://t.me/semear')
            ->set('configData.display_address', 'Rua da Igreja, 100 - Ubatuba/SP')
            ->set('configData.terms_conditions', 'Termos de uso da igreja.')
            ->set('configData.cookies_preference', 'Usamos cookies para sua navegação.')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', [
            'id' => 1,
            'telegram' => 'https://t.me/semear',
            'display_address' => 'Rua da Igreja, 100 - Ubatuba/SP',
            'terms_conditions' => 'Termos de uso da igreja.',
            'cookies_preference' => 'Usamos cookies para sua navegação.',
        ]);
    }

    public function test_update_rejects_invalid_telegram_url(): void
    {
        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        $this->actingAs(User::factory()->create());

        Livewire::test(Settings::class)
            ->set('configData.telegram', 'nao-e-uma-url')
            ->call('update')
            ->assertHasErrors(['configData.telegram']);
    }

    public function test_update_accepts_masked_cep_and_stores_digits_only(): void
    {
        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        $this->actingAs(User::factory()->create());

        Livewire::test(Settings::class)
            ->set('configData.zipcode', '11680-000')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', ['id' => 1, 'zipcode' => '11680000']);
    }

    public function test_logo_upload_is_saved_as_webp(): void
    {
        Storage::fake('public');

        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        $this->actingAs(User::factory()->create());

        $file = UploadedFile::fake()->image('logo.png', 800, 300);

        Livewire::test(Settings::class)
            ->set('logo', $file)
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', ['id' => 1]);

        $path = Config::find(1)->logo;

        $this->assertNotNull($path);
        $this->assertStringEndsWith('.webp', $path);
        $this->assertTrue(Storage::disk('public')->exists($path));
    }
}