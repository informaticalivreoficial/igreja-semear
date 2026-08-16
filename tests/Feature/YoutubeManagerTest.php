<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Youtube\YoutubeManager;
use App\Models\Config;
use App\Models\User;
use App\Models\YoutubePlaylist;
use App\Models\YoutubeVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class YoutubeManagerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsSuperAdmin(): User
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('super admin');
        $this->actingAs($user);

        return $user;
    }

    public function test_admin_page_requires_auth_and_renders(): void
    {
        $this->actingAsSuperAdmin();

        $this->get('/admin/youtube')
            ->assertOk()
            ->assertSee('YouTube');
    }

    public function test_save_video_persists(): void
    {
        $this->actingAsSuperAdmin();

        Livewire::test(YoutubeManager::class)
            ->set('videoTitle', 'Culto de Domingo')
            ->set('videoYoutubeId', 'dQw4w9WgXcQ')
            ->set('videoType', 'culto')
            ->set('videoPublishAt', '15/08/2026')
            ->set('videoDescription', 'Mensagem da Palavra')
            ->call('saveVideo')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('youtube_videos', [
            'title' => 'Culto de Domingo',
            'youtube_id' => 'dQw4w9WgXcQ',
            'type' => 'culto',
            'status' => 1,
        ]);
    }

    public function test_save_video_normalizes_youtube_link(): void
    {
        $this->actingAsSuperAdmin();

        Livewire::test(YoutubeManager::class)
            ->set('videoTitle', 'Culto Especial')
            ->set('videoYoutubeId', 'https://www.youtube.com/watch?v=aqz-KE-bpKQ')
            ->set('videoPublishAt', '15/08/2026')
            ->call('saveVideo')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('youtube_videos', [
            'title' => 'Culto Especial',
            'youtube_id' => 'aqz-KE-bpKQ',
        ]);
    }

    public function test_update_video_accepts_browser_date_input_format(): void
    {
        $this->actingAsSuperAdmin();

        $video = YoutubeVideo::factory()->create(['publish_at' => '2026-07-01']);

        Livewire::test(YoutubeManager::class)
            ->call('openVideoForm', $video->id)
            ->assertSet('videoPublishAt', '2026-07-01')
            ->set('videoTitle', 'Culto Atualizado')
            ->set('videoPublishAt', '2026-08-15')
            ->call('saveVideo')
            ->assertHasNoErrors();

        $this->assertSame('Culto Atualizado', $video->fresh()->title);
        $this->assertSame('2026-08-15', $video->fresh()->publish_at->format('Y-m-d'));
    }

    public function test_toggle_live_keeps_only_one_live(): void
    {
        $this->actingAsSuperAdmin();

        $primeiro = YoutubeVideo::factory()->create(['is_live' => true]);
        $segundo = YoutubeVideo::factory()->create(['is_live' => false]);

        Livewire::test(YoutubeManager::class)
            ->call('toggleVideoLive', $segundo->id);

        $this->assertDatabaseHas('youtube_videos', ['id' => $primeiro->id, 'is_live' => 0]);
        $this->assertDatabaseHas('youtube_videos', ['id' => $segundo->id, 'is_live' => 1]);
    }

    public function test_save_playlist_persists(): void
    {
        $this->actingAsSuperAdmin();

        Livewire::test(YoutubeManager::class)
            ->set('playlistTitle', 'Cultos Online')
            ->set('playlistYoutubeId', 'PL4o29bINVT4GqUy6JfGH1HmFQo4bKZlQP')
            ->call('savePlaylist')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('youtube_playlists', [
            'title' => 'Cultos Online',
            'youtube_id' => 'PL4o29bINVT4GqUy6JfGH1HmFQo4bKZlQP',
            'status' => 1,
        ]);
    }

    public function test_save_channel_updates_config(): void
    {
        $this->actingAsSuperAdmin();

        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        Livewire::test(YoutubeManager::class)
            ->set('youtubeChannelName', 'Comunidade Cristã Semear')
            ->set('youtubeChannel', 'https://youtube.com/@semear')
            ->call('saveChannel')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', [
            'id' => 1,
            'youtube_channel_name' => 'Comunidade Cristã Semear',
            'youtube' => 'https://youtube.com/@semear',
        ]);
    }

    public function test_save_next_transmission_updates_config(): void
    {
        $this->actingAsSuperAdmin();

        Config::create(['id' => 1, 'app_name' => 'Semear Teste']);

        Livewire::test(YoutubeManager::class)
            ->set('nextTransmissionAt', '15/08/2026 19:00')
            ->call('saveConfig')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('config', [
            'id' => 1,
            'next_transmission_at' => '2026-08-15 19:00:00',
        ]);
    }
}