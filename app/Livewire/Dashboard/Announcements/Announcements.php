<?php

namespace App\Livewire\Dashboard\Announcements;

use App\Models\Announcement;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Announcements extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 25;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Aviso?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteAnnouncement',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteAnnouncement')]
    public function deleteAnnouncement($id): void
    {
        Announcement::findOrFail($id)->delete();

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Aviso removido!', 'showConfirmButton' => false]);
    }

    public function render()
    {
        $announcements = Announcement::query()
            ->with('creator')
            ->when($this->search, fn ($q) => $q->where('title', 'LIKE', "%{$this->search}%"))
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.dashboard.announcements.announcements', [
            'title' => 'Avisos',
            'announcements' => $announcements,
        ]);
    }
}
