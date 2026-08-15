<?php

namespace App\Livewire\Dashboard\PrayerRequests;

use App\Mail\Web\PrayerRequestAnswer;
use App\Models\PrayerRequest;
use App\Services\ConfigService;
use Illuminate\Support\Facades\Mail;
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

    public function saveAnswer(ConfigService $configService): void
    {
        $this->validate([
            'answer' => 'required|string',
        ]);

        $prayerRequest = PrayerRequest::findOrFail($this->answeringId);

        if (empty($prayerRequest->email)) {
            $this->dispatch('swal', [
                'icon' => 'warning',
                'timer' => 3000,
                'title' => 'Sem e-mail para envio!',
                'text' => 'Este pedido não possui e-mail cadastrado para enviar a resposta.',
                'showConfirmButton' => false,
            ]);

            return;
        }

        $config = $configService->getConfig();

        Mail::send(new PrayerRequestAnswer([
            'sitename' => $config->app_name ?? 'Semear',
            'siteemail' => $config->email,
            'reply_name' => $prayerRequest->name,
            'reply_email' => $prayerRequest->email,
            'answered_by_name' => auth()->user()->name,
            'message' => $prayerRequest->message,
            'answer' => $this->answer,
        ]));

        $prayerRequest->update([
            'answer' => null,
            'status' => PrayerRequest::STATUS_RESPONDIDO,
            'answered_by' => auth()->id(),
            'answered_at' => now(),
        ]);

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => 'Resposta enviada por e-mail!', 'showConfirmButton' => false]);
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
