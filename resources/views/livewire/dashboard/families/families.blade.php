<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-users"></i> Famílias</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Famílias</span>
        </nav>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm w-64"
                    placeholder="Pesquisar família">

                <button wire:click="openCreate" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Família
                </button>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($families->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-center">Membros</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($families as $family)
                            <tr>
                                <td class="font-semibold">{{ $family->name }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $family->members_count }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="openEdit({{ $family->id }})" class="btn btn-xs btn-default" title="Editar"><i class="fas fa-pen"></i></button>
                                        <button wire:click="setDeleteId({{ $family->id }})" class="btn btn-xs btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($families->hasMorePages())
                    <div class="mt-4 text-center">
                        <button wire:click="$set('perPage', {{ $perPage + 25 }})" class="btn btn-primary">
                            <i class="fas fa-spinner mr-2"></i> Carregar mais
                        </button>
                    </div>
                @endif
            @else
                <div class="alert alert-info p-3">Nenhuma família cadastrada.</div>
            @endif
        </div>
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" wire:click.self="closeForm">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $editingId ? 'Editar Família' : 'Nova Família' }}
                    </h3>
                    <button wire:click="closeForm" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit="save" class="mt-5">
                    <label class="form-label">Nome da família</label>
                    <input type="text" wire:model="name" class="form-control" placeholder="Ex.: Família Silva">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" wire:click="closeForm" class="btn btn-sm btn-default">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
