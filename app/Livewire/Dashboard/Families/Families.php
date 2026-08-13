<?php

namespace App\Livewire\Dashboard\Families;

use App\Models\Family;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Families extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 25;

    public string $search = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $name = '';

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset('editingId', 'name');
        $this->showForm = true;
    }

    public function openEdit($id): void
    {
        $family = Family::findOrFail($id);
        $this->editingId = $family->id;
        $this->name = $family->name;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->reset('showForm', 'editingId', 'name');
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            Family::findOrFail($this->editingId)->update(['name' => $this->name]);
            $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Família atualizada!', 'showConfirmButton' => false]);
        } else {
            Family::create(['name' => $this->name]);
            $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Família cadastrada!', 'showConfirmButton' => false]);
        }

        $this->closeForm();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Família?',
            'text' => 'Os membros vinculados ficarão sem família.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteFamily',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteFamily')]
    public function deleteFamily($id): void
    {
        $family = Family::findOrFail($id);
        $family->members()->update(['family_id' => null, 'family_role' => null]);
        $family->delete();

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Família removida!', 'showConfirmButton' => false]);
    }

    public function render()
    {
        $families = Family::query()
            ->withCount('members')
            ->when($this->search, fn ($q) => $q->where('name', 'LIKE', "%{$this->search}%"))
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.dashboard.families.families', [
            'title' => 'Famílias',
            'families' => $families,
        ]);
    }
}
