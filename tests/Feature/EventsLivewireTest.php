<?php

namespace Tests\Feature;

use App\Livewire\Web\Events;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventsLivewireTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_set_filter_by_type_without_reload(): void
    {
        $this->makeEvent(['title' => 'Culto da Família', 'type' => 'culto']);
        $this->makeEvent(['title' => 'Conferência', 'type' => 'evento']);

        Livewire::test(Events::class)
            ->call('setFilter', 'tipo', 'culto')
            ->assertSee('Culto da Família')
            ->assertDontSee('Conferência');
    }

    public function test_set_period_filter(): void
    {
        $this->makeEvent(['title' => 'Evento Futuro', 'start_at' => now()->addDays(10)]);
        $this->makeEvent(['title' => 'Evento Passado', 'start_at' => now()->subDays(10)]);

        Livewire::test(Events::class)
            ->set('periodo', 'proximos')
            ->assertSee('Evento Futuro')
            ->assertDontSee('Evento Passado');

        Livewire::test(Events::class)
            ->set('periodo', 'passados')
            ->assertSee('Evento Passado')
            ->assertDontSee('Evento Futuro');
    }

    public function test_search_filter(): void
    {
        $this->makeEvent(['title' => 'Acampamento de Verão']);
        $this->makeEvent(['title' => 'Vigília de Oração']);

        Livewire::test(Events::class)
            ->set('busca', 'Acampamento')
            ->assertSee('Acampamento de Verão')
            ->assertDontSee('Vigília de Oração');
    }

    public function test_url_bound_properties_are_synced(): void
    {
        Livewire::test(Events::class)
            ->call('setFilter', 'tipo', 'culto')
            ->assertSet('tipo', 'culto')
            ->assertSet('periodo', 'todos');
    }
}