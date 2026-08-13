<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-shield-alt"></i> {{ $isEditing ? 'Editar' : 'Cadastrar' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a wire:navigate href="{{ route('admin.permissions') }}">Permissões</a></span>
            <span class="breadcrumb-item active">{{ $isEditing ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-body text-slate-600">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row">
                <input type="text" wire:model.defer="name" placeholder="Nome da permissão" class="form-control flex-1">
                <button type="submit" class="btn btn-success">{{ $isEditing ? 'Atualizar' : 'Salvar' }}</button>
                @if ($isEditing)
                    <button type="button" wire:click="resetForm" class="btn btn-default">Cancelar</button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th class="w-28">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="edit({{ $permission->id }})" class="btn btn-xs btn-default" title="Editar"><i class="fas fa-pen"></i></button>
                                        <button wire:click="delete({{ $permission->id }})" class="btn btn-xs btn-danger text-white"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
