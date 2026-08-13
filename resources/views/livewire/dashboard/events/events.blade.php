<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt mr-2"></i> Eventos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Eventos</li>
                    </ol>
                </div>
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
                                placeholder="Pesquisar">

                            <select wire:model.live="statusFilter"
                                    class="form-control form-control-sm"
                                    style="max-width: 140px;">
                                <option value="">Status</option>
                                <option value="1">Ativos</option>
                                <option value="0">Inativos</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 my-2 text-sm-right">
                    <a wire:navigate href="{{ route('admin.events.create') }}"
                        class="btn btn-sm btn-default">
                        <i class="fas fa-plus mr-2"></i> Cadastrar Novo
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($events->count())
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="cursor-pointer" wire:click="sortBy('title')">
                                Título <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Local</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        <tr class="{{ $event->status ? '' : 'bg-warning' }}">
                            <td>
                                <span class="badge badge-info mr-2">{{ ucfirst($event->type ?? 'evento') }}</span>
                                {{ $event->title }}
                            </td>
                            <td class="text-center">{{ $event->start_at?->format('d/m/Y H:i') }}</td>
                            <td class="text-center">{{ $event->location ?? '—' }}</td>
                            <td class="text-center">
                                <x-forms.switch-toggle
                                    wire:key="safe-switch-{{ $event->id }}"
                                    wire:click="toggleStatus({{ $event->id }})"
                                    :checked="$event->status"
                                    size="sm"
                                    color="green"
                                />
                            </td>
                            <td class="text-center">
                                <a title="Editar Evento" href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button"
                                    class="btn btn-xs bg-danger text-white"
                                    title="Excluir Evento"
                                    wire:click="setDeleteId({{ $event->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($events->hasMorePages())
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
