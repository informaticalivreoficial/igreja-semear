<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-calendar-alt"></i> Eventos</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Eventos</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <input type="text"
                        wire:model.live.debounce.500ms="search"
                        class="form-control form-control-sm w-44"
                        placeholder="Pesquisar">

                    <select wire:model.live="statusFilter" class="form-control form-control-sm w-36">
                        <option value="">Status</option>
                        <option value="1">Ativos</option>
                        <option value="0">Inativos</option>
                    </select>
                </div>

                <a wire:navigate href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Novo
                </a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($events->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
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
                            <tr class="{{ $event->status ? '' : 'bg-amber-50/70' }}">
                                <td>
                                    <span class="badge badge-info mr-2">{{ ucfirst($event->type ?? 'evento') }}</span>
                                    {{ $event->title }}
                                </td>
                                <td class="text-center whitespace-nowrap">{{ $event->start_at?->format('d/m/Y H:i') }}</td>
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
                                    <div class="flex items-center justify-center gap-2">
                                        <a title="Editar Evento" href="{{ route('admin.events.edit', $event->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Evento"
                                            wire:click="setDeleteId({{ $event->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($events->hasMorePages())
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
