<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hand-holding-heart"></i> Doações</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Doações</span>
        </nav>
    </div>

    {{-- Totais --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700">
                    <i class="fas fa-money-bill-wave text-lg"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-slate-800">R$ {{ number_format($totalGeral, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Total (filtro)</p>
                </div>
            </div>
        </div>

        @foreach ($types as $key => $label)
            @php $row = $totals->get($key); @endphp
            <div class="card overflow-hidden">
                <div class="flex items-center gap-4 p-5">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-{{ $loop->first ? 'brand' : ($loop->index === 1 ? 'accent' : 'sky') }}-100 text-{{ $loop->first ? 'brand' : ($loop->index === 1 ? 'accent' : 'sky') }}-700">
                        <i class="fas fa-{{ $key === 'tithe' ? 'church' : 'hands-helping' }} text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-slate-800">R$ {{ number_format((float) ($row->total ?? 0), 2, ',', '.') }}</p>
                        <p class="text-sm text-slate-500">{{ $label }} ({{ $row->count ?? 0 }})</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <div class="flex flex-1 flex-wrap items-center gap-2">
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm min-w-36 flex-1"
                    placeholder="Pesquisar contribuinte">

                <select wire:model.live="typeFilter" class="form-control form-control-sm w-28">
                    <option value="">Tipo</option>
                    @foreach ($types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter" class="form-control form-control-sm w-28">
                    <option value="">Status</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <select wire:model.live="methodFilter" class="form-control form-control-sm w-28">
                    <option value="">Pagamento</option>
                    @foreach ($methods as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model.live="startDate" class="form-control form-control-sm w-36">
                <input type="date" wire:model.live="endDate" class="form-control form-control-sm w-36">

                <button type="button" wire:click="clearFilters" class="btn btn-xs btn-default">
                    <i class="fas fa-times"></i> Limpar
                </button>
            </div>

            <div class="flex shrink-0 flex-wrap items-center gap-2">
                <span class="badge badge-info">{{ $donations->total() }} registros</span>
                <a wire:navigate href="{{ route('admin.donations.create') }}" class="btn btn-sm btn-default">
                    <i class="fas fa-plus"></i> Cadastrar Manual
                </a>
                <a wire:navigate href="{{ route('web.doacoes') }}" target="_blank" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Nova Doação
                </a>
            </div>
        </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($donations->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Contribuinte</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Data</th>
                                <th class="text-center">Pagamento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donations as $donation)
                            <tr>
                                <td>
                                    @if ($donation->is_anonymous)
                                        <span class="text-slate-500"><i class="fas fa-user-secret mr-1"></i> Anônimo</span>
                                    @else
                                        {{ $donation->contributor_name }}
                                    @endif
                                    <span class="badge badge-{{ $donation->source === 'manual' ? 'secondary' : 'info' }} ml-1">
                                        {{ $donation->source_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $donation->type === 'tithe' ? 'info' : ($donation->type === 'offering' ? 'success' : 'warning') }}">
                                        {{ $donation->type_label }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $donation->description ?? '—' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $donation->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-center uppercase">{{ $donation->method_label }}</td>
                                <td class="text-center font-semibold">R$ {{ $donation->amount_formatted }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $donation->status === 'paid' ? 'success' : ($donation->status === 'pending' ? 'warning' : ($donation->status === 'refunded' ? 'secondary' : 'danger')) }}">
                                        {{ $donation->status_label }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-xs btn-default"
                                        title="Ver detalhes"
                                        wire:click="openDetails({{ $donation->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($donations->hasMorePages())
                    <div class="text-center mt-4">
                        <button wire:click="loadMore" class="btn btn-primary">
                            <i class="fas fa-spinner mr-2"></i> Carregar mais
                        </button>
                    </div>
                @endif
            @else
                <div class="alert alert-info p-3">
                    Não foram encontrados registros!
                </div>
            @endif
        </div>
    </div>

    {{-- Detalhes --}}
    @if ($this->selectedDonation)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" wire:click.self="closeDetails">
            <div class="card w-full max-w-lg overflow-hidden shadow-xl">
                <div class="card-header flex items-center justify-between">
                    <h3 class="m-0"><i class="fas fa-receipt mr-2"></i>Detalhes da Doação</h3>
                    <button type="button" class="btn btn-xs btn-default" wire:click="closeDetails">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="card-body space-y-3">
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-slate-500">Referência</dt>
                            <dd class="font-mono text-xs">{{ $this->selectedDonation->uuid }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Data</dt>
                            <dd>{{ $this->selectedDonation->created_at?->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Tipo</dt>
                            <dd>{{ $this->selectedDonation->type_label }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Origem</dt>
                            <dd>
                                <span class="badge badge-{{ $this->selectedDonation->source === 'manual' ? 'secondary' : 'info' }}">
                                    {{ $this->selectedDonation->source_label }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Valor</dt>
                            <dd class="font-semibold">R$ {{ $this->selectedDonation->amount_formatted }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Contribuinte</dt>
                            <dd>
                                @if ($this->selectedDonation->is_anonymous)
                                    Anônimo
                                @else
                                    {{ $this->selectedDonation->member?->user?->name ?? $this->selectedDonation->member?->name ?? '—' }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Descrição</dt>
                            <dd>{{ $this->selectedDonation->description ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Método</dt>
                            <dd class="uppercase">{{ $this->selectedDonation->method_label }}</dd>
                        </div>
                    </dl>

                    @if ($this->selectedDonation->source === 'manual')
                        <div class="mt-4 flex justify-end border-t border-slate-100 pt-4">
                            <a wire:navigate href="{{ route('admin.donations.edit', $this->selectedDonation->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pen mr-1"></i> Editar
                            </a>
                        </div>
                    @endif

                    @if ($this->selectedDonation->payment)
                        <hr>
                        <h4 class="text-sm font-semibold mb-2">Pagamento</h4>
                        <dl class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-slate-500">Método</dt>
                                <dd class="uppercase">{{ $this->selectedDonation->payment->method_label }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Status</dt>
                                <dd>
                                    <span class="badge badge-{{ $this->selectedDonation->payment->status === 'paid' ? 'success' : ($this->selectedDonation->payment->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ \App\Enums\PaymentStatusEnum::from($this->selectedDonation->payment->status)?->label() }}
                                    </span>
                                </dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-slate-500">Gateway ID</dt>
                                <dd class="font-mono text-xs">{{ $this->selectedDonation->payment->gateway_id ?? '—' }}</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-slate-500">Pago em</dt>
                                <dd>{{ $this->selectedDonation->payment->paid_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                            </div>
                        </dl>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
