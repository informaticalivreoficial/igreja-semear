<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class EventosPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Igreja Semear',
            'template' => 'default',
        ]);

        View::share('configuracoes', Config::find(1));
        View::share('viewPaginas', collect());
    }

    private function makeEvent(array $overrides = []): Event
    {
        return Event::create(array_merge([
            'title' => 'Evento de Teste',
            'slug' => 'evento-'.uniqid(),
            'type' => 'evento',
            'start_at' => now()->addDays(5)->format('Y-m-d H:i:s'),
            'status' => 1,
            'created_by' => null,
        ], $overrides));
    }

    public function test_events_page_renders(): void
    {
        $this->makeEvent(['title' => 'Culto de Celebração']);

        $this->get(route('web.eventos'))
            ->assertOk()
            ->assertSee('Culto de Celebração')
            ->assertSee('Filtrar');
    }

    public function test_filters_events_by_type(): void
    {
        $this->makeEvent(['title' => 'Culto da Família', 'type' => 'culto']);
        $this->makeEvent(['title' => 'Conferência', 'type' => 'evento']);

        $this->get(route('web.eventos', ['tipo' => 'culto']))
            ->assertOk()
            ->assertSee('Culto da Família')
            ->assertDontSee('Conferência');
    }

    public function test_filters_events_by_period(): void
    {
        $this->makeEvent(['title' => 'Evento Futuro', 'start_at' => now()->addDays(10)]);
        $this->makeEvent(['title' => 'Evento Passado', 'start_at' => now()->subDays(10)]);

        $this->get(route('web.eventos', ['periodo' => 'proximos']))
            ->assertOk()
            ->assertSee('Evento Futuro')
            ->assertDontSee('Evento Passado');

        $this->get(route('web.eventos', ['periodo' => 'passados']))
            ->assertOk()
            ->assertSee('Evento Passado')
            ->assertDontSee('Evento Futuro');
    }

    public function test_filters_events_by_search(): void
    {
        $this->makeEvent(['title' => 'Acampamento de Verão']);
        $this->makeEvent(['title' => 'Vigília de Oração']);

        $this->get(route('web.eventos', ['busca' => 'Acampamento']))
            ->assertOk()
            ->assertSee('Acampamento de Verão')
            ->assertDontSee('Vigília de Oração');
    }

    public function test_inactive_events_are_hidden(): void
    {
        $this->makeEvent(['title' => 'Evento Ativo', 'status' => 1]);
        $this->makeEvent(['title' => 'Evento Inativo', 'status' => 0]);

        $this->get(route('web.eventos'))
            ->assertOk()
            ->assertSee('Evento Ativo')
            ->assertDontSee('Evento Inativo');
    }
}