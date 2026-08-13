<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hand-holding-heart"></i> Ofertas</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Ofertas</span>
        </nav>
    </div>

    {{-- Totais --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <i class="fas fa-money-bill-wave text-lg"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-slate-800">R$ {{ number_format($total, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Total (filtro)</p>
                </div>
            </div>
        </div>
        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                    <i class="fas fa-church text-lg"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-slate-800">R$ {{ number_format($totalDizimo, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Dízimos</p>
                </div>
            </div>
        </div>
        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                    <i class="fas fa-hands-helping text-lg"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-slate-800">R$ {{ number_format($totalOferta, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Ofertas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <input type="text"
                        wire:model.live.debounce.500ms="search"
                        class="form-control form-control-sm w-44"
                        placeholder="Pesquisar membro">

                    <select wire:model.live="typeFilter" class="form-control form-control-sm w-32">
                        <option value="">Tipo</option>
                        <option value="oferta">Oferta</option>
                        <option value="dizimo">Dízimo</option>
                    </select>

                    <input type="month"
                        wire:model.live="monthFilter"
                        class="form-control form-control-sm w-36">
                </div>

                <a wire:navigate href="{{ route('admin.offerings.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Nova
                </a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($offerings->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Membro</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Data</th>
                                <th class="text-center">Pagamento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offerings as $offering)
                            <tr>
                                <td>{{ $offering->user?->name ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $offering->type === 'dizimo' ? 'info' : 'success' }}">
                                        {{ ucfirst($offering->type) }}
                                    </span>
                                </td>
                                <td class="text-center whitespace-nowrap">{{ $offering->offering_date?->format('d/m/Y') }}</td>
                                <td class="text-center">{{ ucfirst($offering->payment_method ?? '—') }}</td>
                                <td class="text-center font-semibold">R$ {{ number_format($offering->amount, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a title="Editar Oferta" href="{{ route('admin.offerings.edit', $offering->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Oferta"
                                            wire:click="setDeleteId({{ $offering->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($offerings->hasMorePages())
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
</div>
