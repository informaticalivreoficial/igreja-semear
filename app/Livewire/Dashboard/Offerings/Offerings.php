<?php

namespace App\Livewire\Dashboard\Offerings;

use App\Models\Offering;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Offerings extends Component
{
    use WithPagination;

    public int $perPage = 25;

    protected $paginationTheme = 'tailwind';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $typeFilter = '';

    public string $monthFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    protected function query()
    {
        return Offering::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($u) {
                        $u->where('name', 'LIKE', "%{$this->search}%");
                    })->orWhere('notes', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->typeFilter !== '', function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->monthFilter !== '', function ($query) {
                $query->whereRaw('DATE_FORMAT(offering_date, "%Y-%m") = ?', [$this->monthFilter]);
            });
    }

    public function render()
    {
        $title = 'Ofertas';

        $offerings = $this->query()
            ->orderBy('offering_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $total = $this->query()->sum('amount');

        $totalDizimo = $this->query()->where('type', 'dizimo')->sum('amount');
        $totalOferta = $this->query()->where('type', 'oferta')->sum('amount');

        return view('livewire.dashboard.offerings.offerings', [
            'title' => $title,
            'offerings' => $offerings,
            'total' => $total,
            'totalDizimo' => $totalDizimo,
            'totalOferta' => $totalOferta,
        ]);
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Oferta?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteOffering',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteOffering')]
    public function deleteOffering($id): void
    {
        Offering::findOrFail($id)->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'A Oferta foi removida!',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }
}
