<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Settings;
use App\Models\Config;
use App\Models\Member;
use App\Models\User;
use App\Models\YoutubeVideo;
use Database\Seeders\RolesAndPermissionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Igreja Semear',
            'template' => 'default',
            'email' => 'igreja@semear.com.br',
            'cell_phone' => '(11) 99999-9999',
            'display_address' => 'Rua da Igreja, 100 - Ubatuba/SP',
            'maintenance_mode' => false,
        ]);

        View::share('configuracoes', Config::find(1));
        View::share('viewPaginas', collect());

        $this->seed(RolesAndPermissionsTableSeeder::class);
    }

    public function test_public_site_renders_when_maintenance_off(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('Em manutenção');
    }

    public function test_public_site_redirects_to_manutencao_when_on(): void
    {
        Config::where('id', 1)->update(['maintenance_mode' => true]);

        $this->get('/')
            ->assertRedirect(route('web.manutencao'));
    }

    public function test_member_area_redirects_to_manutencao_when_on(): void
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

        Config::where('id', 1)->update(['maintenance_mode' => true]);

        $this->actingAs($user)
            ->get('/minha-conta')
            ->assertRedirect(route('web.manutencao'));
    }

    public function test_staff_bypasses_maintenance(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        Config::where('id', 1)->update(['maintenance_mode' => true]);

        $this->actingAs($admin)
            ->get('/')
            ->assertOk();
    }

    public function test_manutencao_page_shows_message_contacts_and_last_culto(): void
    {
        Config::where('id', 1)->update([
            'maintenance_mode' => true,
            'maintenance_message' => 'Voltamos em breve com novidades!',
        ]);

        YoutubeVideo::create([
            'title' => 'Culto de Domingo',
            'youtube_id' => 'abc123xyz',
            'type' => YoutubeVideo::TYPE_CULTO,
            'status' => true,
            'publish_at' => now(),
        ]);

        $this->get('/manutencao')
            ->assertOk()
            ->assertSee('Voltamos em breve com novidades!')
            ->assertSee('igreja@semear.com.br')
            ->assertSee('Culto de Domingo')
            ->assertSee('abc123xyz');
    }

    public function test_expired_maintenance_until_disables_maintenance(): void
    {
        Config::where('id', 1)->update([
            'maintenance_mode' => true,
            'maintenance_until' => now()->subDay(),
        ]);

        $this->get('/')
            ->assertOk();
    }

    public function test_settings_saves_maintenance_fields(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Settings::class)
            ->set('configData.maintenance_mode', true)
            ->set('configData.maintenance_message', 'Em breve novidades!')
            ->set('configData.maintenance_until', '2026-12-31T18:00')
            ->call('update')
            ->assertHasNoErrors();

        $config = Config::find(1);

        $this->assertTrue((bool) $config->maintenance_mode);
        $this->assertSame('Em breve novidades!', $config->maintenance_message);
        $this->assertNotNull($config->maintenance_until);
    }
}