<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-heart mr-2"></i> Ofertas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Ofertas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R$ {{ number_format($total, 2, ',', '.') }}</h3>
                    <p>Total (filtro)</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>R$ {{ number_format($totalDizimo, 2, ',', '.') }}</h3>
                    <p>Dízimos</p>
                </div>
                <div class="icon"><i class="fas fa-church"></i></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>R$ {{ number_format($totalOferta, 2, ',', '.') }}</h3>
                    <p>Ofertas</p>
                </div>
                <div class="icon"><i class="fas fa-hands-helping"></i></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-8 my-2">
                    <div class="card-tools">
                        <div class="d-flex flex-wrap" style="gap: 6px;">
                            <input type="text"
                                wire:model.live.debounce.500ms="search"
                                class="form-control form-control-sm"
                                style="max-width: 200px;"
                                placeholder="Pesquisar membro">

                            <select wire:model.live="typeFilter"
                                    class="form-control form-control-sm"
                                    style="max-width: 130px;">
                                <option value="">Tipo</option>
                                <option value="oferta">Oferta</option>
                                <option value="dizimo">Dízimo</option>
                            </select>

                            <input type="month"
                                wire:model.live="monthFilter"
                                class="form-control form-control-sm"
                                style="max-width: 150px;">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 my-2 text-sm-right">
                    <a wire:navigate href="{{ route('admin.offerings.create') }}"
                        class="btn btn-sm btn-default">
                        <i class="fas fa-plus mr-2"></i> Cadastrar Nova
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($offerings->count())
                <table class="table table-bordered table-hover">
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
                            <td class="text-center">{{ $offering->offering_date?->format('d/m/Y') }}</td>
                            <td class="text-center">{{ ucfirst($offering->payment_method ?? '—') }}</td>
                            <td class="text-center"><b>R$ {{ number_format($offering->amount, 2, ',', '.') }}</b></td>
                            <td class="text-center">
                                <a title="Editar Oferta" href="{{ route('admin.offerings.edit', $offering->id) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button"
                                    class="btn btn-xs bg-danger text-white"
                                    title="Excluir Oferta"
                                    wire:click="setDeleteId({{ $offering->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($offerings->hasMorePages())
                    <div class="text-center mt-4">
                        <button wire:click="loadMore" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Carregar mais
                        </button>
                    </div>
                @endif
            @else
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
