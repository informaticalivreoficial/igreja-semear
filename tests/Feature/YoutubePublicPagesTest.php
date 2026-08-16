<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\YoutubeVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class YoutubePublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Igreja Semear',
            'template' => 'default',
            'youtube' => 'https://youtube.com/@semear',
            'youtube_channel_name' => 'Comunidade Cristã Semear',
        ]);

        View::share('configuracoes', Config::find(1));
        View::share('viewPaginas', collect());
    }

    public function test_cultos_online_page_renders_live_and_ultimos_cultos(): void
    {
        YoutubeVideo::factory()->culto()->create(['title' => 'Culto Ao Vivo Agora', 'is_live' => true]);
        YoutubeVideo::factory()->culto()->create(['title' => 'Culto da Família']);

        $this->get(route('web.cultos'))
            ->assertOk()
            ->assertSee('Cultos Online')
            ->assertSee('Culto Ao Vivo Agora')
            ->assertSee('Culto da Família');
    }

    public function test_cultos_online_shows_proxima_transmissao(): void
    {
        Config::where('id', 1)->update(['next_transmission_at' => now()->addDay()->format('Y-m-d H:i:s')]);

        YoutubeVideo::factory()->culto()->create(['title' => 'Culto de Domingo']);

        $this->get(route('web.cultos'))
            ->assertOk()
            ->assertSee('Próxima transmissão');
    }

    public function test_pregacoes_page_renders_with_search_and_categories(): void
    {
        YoutubeVideo::factory()->pregacao()->create([
            'title' => 'O Poder da Gratidão',
            'category' => 'Estudos bíblicos',
        ]);
        YoutubeVideo::factory()->pregacao()->create([
            'title' => 'Andando no Sobrenatural',
            'category' => 'Jovens',
        ]);

        $this->get(route('web.pregacoes'))
            ->assertOk()
            ->assertSee('Pregações')
            ->assertSee('O Poder da Gratidão')
            ->assertSee('Andando no Sobrenatural')
            ->assertSee('Estudos bíblicos');
    }

    public function test_pregacoes_page_filters_by_search(): void
    {
        YoutubeVideo::factory()->pregacao()->create([
            'title' => 'Mensagem Especial de Natal',
            'category' => 'Estudos bíblicos',
        ]);
        YoutubeVideo::factory()->pregacao()->create([
            'title' => 'Devocional Diário',
            'category' => 'Jovens',
        ]);

        $this->get(route('web.pregacoes', ['busca' => 'Natal']))
            ->assertOk()
            ->assertSee('Mensagem Especial de Natal')
            ->assertDontSee('Devocional Diário');
    }

    public function test_old_transmissao_route_redirects_to_cultos_online(): void
    {
        $this->get(route('web.transmissao'))
            ->assertRedirect(route('web.cultos'));
    }

    public function test_home_shows_live_widget(): void
    {
        YoutubeVideo::factory()->culto()->live()->create(['title' => 'Transmissão de Domingo']);

        $this->get(route('web.home'))
            ->assertOk()
            ->assertSee('Ao vivo agora')
            ->assertSee('Transmissão de Domingo');
    }

    public function test_home_shows_ultimo_culto_when_not_live(): void
    {
        YoutubeVideo::factory()->culto()->create(['title' => 'Último Culto Gravado']);

        $this->get(route('web.home'))
            ->assertOk()
            ->assertSee('Último culto')
            ->assertSee('Último Culto Gravado');
    }
}