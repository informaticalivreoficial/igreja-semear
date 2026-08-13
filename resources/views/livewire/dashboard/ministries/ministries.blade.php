<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hands-helping"></i> Ministérios</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Ministérios</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm w-44"
                    placeholder="Pesquisar">

                <a wire:navigate href="{{ route('admin.ministries.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Novo
                </a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($ministries->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="cursor-pointer" wire:click="sortBy('name')">
                                    Nome <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="text-center">Líder</th>
                                <th class="text-center">Membros</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ministries as $ministry)
                            <tr class="{{ $ministry->status ? '' : 'bg-amber-50/70' }}">
                                <td>
                                    <span class="mr-2 inline-block rounded-md" style="width: 14px; height: 14px; background: {{ $ministry->color ?? '#343a40' }};"></span>
                                    <span class="font-medium text-slate-700">{{ $ministry->name }}</span>
                                </td>
                                <td class="text-center">{{ $ministry->leader?->name ?? '—' }}</td>
                                <td class="text-center">{{ $ministry->members_count ?? $ministry->members->count() }}</td>
                                <td class="text-center">
                                    <x-forms.switch-toggle
                                        wire:key="safe-switch-{{ $ministry->id }}"
                                        wire:click="toggleStatus({{ $ministry->id }})"
                                        :checked="$ministry->status"
                                        size="sm"
                                        color="green"
                                    />
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a title="Editar Ministério" href="{{ route('admin.ministries.edit', $ministry->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Ministério"
                                            wire:click="setDeleteId({{ $ministry->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($ministries->hasMorePages())
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
