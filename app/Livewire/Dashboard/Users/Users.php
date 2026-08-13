<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public function updatingSearch(): void
    {
        $this->resetPage();
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

    #[Title('Membros')]
    public function render()
    {
        $title = 'Membros';

        $users = User::role('member')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                        ->orWhere('email', 'LIKE', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(35);

        return view('livewire.dashboard.users.users', [
            'title' => $title,
            'users' => $users,
        ]);
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Membro?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteUser',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteUser')]
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'Membro excluído com sucesso.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ! $user->status;
        $user->save();
    }
}
