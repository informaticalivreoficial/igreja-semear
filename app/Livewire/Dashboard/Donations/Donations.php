<?php

namespace App\Livewire\Dashboard\Donations;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Models\Config;
use App\Models\Donation;
use Livewire\Component;
use Livewire\WithPagination;

class Donations extends Component
{
    use WithPagination;

    public int $perPage = 25;

    protected $paginationTheme = 'tailwind';

    public string $search = '';

    public string $typeFilter = '';

    public string $statusFilter = '';

    public string $methodFilter = '';

    public string $startDate = '';

    public string $endDate = '';

    public bool $donationsEnabled = true;

    public ?int $selectedDonationId = null;

    public function mount(): void
    {
        $this->donationsEnabled = (bool) (Config::find(1)?->donations_enabled ?? true);
    }

    public function toggleDonations(): void
    {
        $config = Config::find(1);

        if (! $config) {
            return;
        }

        $config->donations_enabled = ! $this->donationsEnabled;
        $config->save();

        $this->donationsEnabled = (bool) $config->donations_enabled;

        $this->dispatch('toast', [
            'type' => $this->donationsEnabled ? 'success' : 'warning',
            'message' => $this->donationsEnabled
                ? 'Doações habilitadas no site.'
                : 'Doações desabilitadas no site.',
        ]);
    }

    public function getSelectedDonationProperty()
    {
        return $this->selectedDonationId
            ? Donation::with(['member.user', 'payment'])->find($this->selectedDonationId)
            : null;
    }

    public function openDetails($id): void
    {
        $this->selectedDonationId = (int) $id;
    }

    public function closeDetails(): void
    {
        $this->selectedDonationId = null;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingMethodFilter(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    protected function query()
    {
        return Donation::query()
            ->with(['member.user', 'payment'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('member.user', function ($u) {
                        $u->where('name', 'LIKE', "%{$this->search}%");
                    })
                        ->orWhereHas('member', function ($m) {
                            $m->where('name', 'LIKE', "%{$this->search}%");
                        })
                        ->orWhere('description', 'LIKE', "%{$this->search}%")
                        ->orWhere('uuid', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->typeFilter !== '', function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->methodFilter !== '', function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('payment', function ($p) {
                        $p->where('method', $this->methodFilter);
                    })
                        ->orWhere('payment_method', $this->methodFilter);
                });
            })
            ->when($this->startDate !== '', function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate !== '', function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            });
    }

    public function render()
    {
        $donations = $this->query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        $totals = Donation::query()
            ->where('status', DonationStatusEnum::Paid->value)
            ->when($this->startDate !== '', fn ($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate !== '', fn ($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->selectRaw('type, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        $totalGeral = (float) $totals->sum('total');

        $manualMethods = [
            'dinheiro' => 'Dinheiro',
            'pix' => 'PIX',
            'transferencia' => 'Transferência',
            'debito' => 'Débito',
            'credito' => 'Crédito',
            'boleto' => 'Boleto',
            'outro' => 'Outro',
        ];

        $methods = collect(PaymentMethodEnum::labels())
            ->merge($manualMethods)
            ->merge(
                Donation::whereNotNull('payment_method')
                    ->distinct()
                    ->pluck('payment_method')
                    ->mapWithKeys(fn ($method) => [$method => ucfirst($method)])
            )
            ->unique()
            ->sortBy(fn ($label) => $label)
            ->all();

        return view('livewire.dashboard.donations.donations', [
            'title' => 'Doações',
            'donations' => $donations,
            'totals' => $totals,
            'totalGeral' => $totalGeral,
            'types' => DonationTypeEnum::labels(),
            'statuses' => DonationStatusEnum::labels(),
            'methods' => $methods,
        ]);
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'typeFilter', 'statusFilter', 'methodFilter', 'startDate', 'endDate']);
    }
}
