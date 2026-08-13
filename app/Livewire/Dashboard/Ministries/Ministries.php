<?php

namespace App\Livewire\Dashboard\Ministries;

use App\Models\Ministry;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Ministries extends Component
{
    use WithPagination;

    public int $perPage = 25;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

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
        $title = 'Ministérios';

        $ministries = Ministry::with(['leader', 'members'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                        ->orWhere('description', 'LIKE', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.dashboard.ministries.ministries', [
            'title' => $title,
            'ministries' => $ministries,
        ]);
    }

    public function toggleStatus($id)
    {
        $ministry = Ministry::findOrFail($id);
        $ministry->status = ! $ministry->status;
        $ministry->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Ministério?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteMinistry',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteMinistry')]
    public function deleteMinistry($id): void
    {
        Ministry::findOrFail($id)->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'O Ministério foi removido!',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }
}
