<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Settings;
use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}