<?php

namespace App\Livewire\Dashboard\PrayerRequests;

use App\Models\PrayerRequest;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PrayerRequests extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 25;

    public string $statusFilter = 'pendente';

    public ?int $answeringId = null;

    public string $answer = '';

    public function openAnswer($id): void
    {
        $this->answeringId = $id;
        $this->answer = PrayerRequest::findOrFail($id)->answer ?? '';
    }

    public function closeAnswer(): void
    {
        $this->reset('answeringId', 'answer');
    }

    public function saveAnswer(): void
    {
        $this->validate([
            'answer' => 'required|string',
        ]);

        PrayerRequest::where('id', $this->answeringId)->update([
            'answer' => $this->answer,
            'status' => PrayerRequest::STATUS_RESPONDIDO,
            'answered_by' => auth()->id(),
            'answered_at' => now(),
        ]);

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Pedido respondido!', 'showConfirmButton' => false]);
        $this->closeAnswer();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Pedido?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deletePrayer',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deletePrayer')]
    public function deletePrayer($id): void
    {
        PrayerRequest::findOrFail($id)->delete();

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Pedido removido!', 'showConfirmButton' => false]);
    }

    public function render()
    {
        $requests = PrayerRequest::query()
            ->with('member')
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.dashboard.prayer-requests.prayer-requests', [
            'title' => 'Pedidos de oração',
            'requests' => $requests,
        ]);
    }
}
