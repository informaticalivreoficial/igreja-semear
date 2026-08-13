<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hands-helping mr-2"></i> Ministérios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Ministérios</li>
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
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 my-2 text-sm-right">
                    <a wire:navigate href="{{ route('admin.ministries.create') }}"
                        class="btn btn-sm btn-default">
                        <i class="fas fa-plus mr-2"></i> Cadastrar Novo
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($ministries->count())
                <table class="table table-bordered table-hover">
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
                        <tr class="{{ $ministry->status ? '' : 'bg-warning' }}">
                            <td>
                                <span class="d-inline-block mr-2" style="width: 14px; height: 14px; background: {{ $ministry->color ?? '#343a40' }}; border-radius: 3px;"></span>
                                {{ $ministry->name }}
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
                                <a title="Editar Ministério" href="{{ route('admin.ministries.edit', $ministry->id) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button"
                                    class="btn btn-xs bg-danger text-white"
                                    title="Excluir Ministério"
                                    wire:click="setDeleteId({{ $ministry->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($ministries->hasMorePages())
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
