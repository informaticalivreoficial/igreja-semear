<?php

namespace App\Livewire\Web;

use App\Models\Event;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Url]
    public string $tipo = '';

    #[Url]
    public string $periodo = 'todos';

    #[Url]
    public string $busca = '';

    public function updatedTipo(): void
    {
        $this->resetPage();
    }

    public function updatedPeriodo(): void
    {
        $this->resetPage();
    }

    public function updatedBusca(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $field, string $value): void
    {
        if (in_array($field, ['tipo', 'periodo'], true)) {
            $this->{$field} = $value;
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Event::where('status', 1);

        if (in_array($this->tipo, ['evento', 'culto', 'campanha', 'especial'], true)) {
            $query->where('type', $this->tipo);
        }

        if ($this->busca !== '') {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->busca}%")
                    ->orWhere('location', 'like', "%{$this->busca}%");
            });
        }

        if ($this->periodo === 'proximos') {
            $query->where('start_at', '>=', now());
        } elseif ($this->periodo === 'passados') {
            $query->where('start_at', '<', now());
        }

        $eventos = $query->orderBy('start_at')->paginate(9);

        return view('livewire.web.events', [
            'eventos' => $eventos,
        ]);
    }
}