<?php

namespace App\Livewire\Dashboard\Registrations;

use App\Models\EventRegistration;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Registrations extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 25;

    public string $statusFilter = '';

    public function setStatus($registrationId, $status): void
    {
        EventRegistration::where('id', $registrationId)->update(['status' => $status]);

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Status atualizado!', 'showConfirmButton' => false]);
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Inscrição?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteRegistration',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteRegistration')]
    public function deleteRegistration($id): void
    {
        EventRegistration::findOrFail($id)->delete();

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Inscrição removida!', 'showConfirmButton' => false]);
    }

    public function render()
    {
        $registrations = EventRegistration::query()
            ->with(['event', 'member'])
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.dashboard.registrations.registrations', [
            'title' => 'Inscrições em eventos',
            'registrations' => $registrations,
        ]);
    }
}
