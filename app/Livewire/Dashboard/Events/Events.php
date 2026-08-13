<?php

namespace App\Livewire\Dashboard\Events;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Events extends Component
{
    use WithPagination;

    public int $perPage = 25;

    protected $paginationTheme = 'tailwind';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $sortField = 'start_at';

    public string $sortDirection = 'desc';

    public string $statusFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        $title = 'Eventos';

        $events = Event::with('creator')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'LIKE', "%{$this->search}%")
                        ->orWhere('location', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.dashboard.events.events', [
            'title' => $title,
            'events' => $events,
        ]);
    }

    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);
        $event->status = ! $event->status;
        $event->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Evento?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteEvent',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteEvent')]
    public function deleteEvent($id): void
    {
        Event::findOrFail($id)->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'O Evento foi removido!',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }
}
