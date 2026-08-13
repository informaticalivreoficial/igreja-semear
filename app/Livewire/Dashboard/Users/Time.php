<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Time extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    protected function roleNames(): array
    {
        $roles = ['admin', 'editor'];

        if (auth()->user()?->isSuperAdmin()) {
            $roles[] = 'super admin';
        }

        return $roles;
    }

    public function render()
    {
        $title = 'Equipe';

        $roleLabels = [
            'super admin' => 'Super Administrador',
            'admin' => 'Administrador',
            'editor' => 'Editor',
            'member' => 'Membro',
        ];

        $users = User::role($this->roleNames())
            ->with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'LIKE', "%{$this->search}%")
                        ->orWhere('email', 'LIKE', "%{$this->search}%");
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        return view('livewire.dashboard.users.time', [
            'users' => $users,
            'roleLabels' => $roleLabels,
            'title' => $title,
        ]);
    }

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

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ! $user->status;
        $user->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Usuário?',
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
            'text' => 'Usuário excluído com sucesso.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }
}
