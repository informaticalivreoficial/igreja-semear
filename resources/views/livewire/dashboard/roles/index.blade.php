<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-shield-alt"></i> {{ $isEdit ? 'Editar' : 'Cadastrar' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a wire:navigate href="{{ route('admin.roles') }}">Cargos</a></span>
            <span class="breadcrumb-item active">{{ $isEdit ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-body text-slate-600">
            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'save' }}">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row">
                    <input type="text" wire:model="name" placeholder="Nome do Cargo" class="form-control flex-1">
                    <button type="submit" class="btn btn-success">{{ $isEdit ? 'Atualizar' : 'Criar' }}</button>
                    @if ($isEdit)
                        <button type="button" wire:click="resetForm" class="btn btn-default">Cancelar</button>
                    @endif
                </div>

                <div class="mb-2">
                    <label class="labelforms block font-bold">Permissões</label>
                    <div class="mt-3 flex flex-wrap gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-4">
                        @foreach ($permissions as $permission)
                            <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-slate-200">
                                <input type="checkbox" class="rounded border-slate-300 text-forest-600 focus:ring-gold-400" wire:model="selectedPermissions" value="{{ $permission->name }}">
                                <span class="ml-1">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </form>

            @if (session()->has('message'))
                <div class="mt-4 text-green-600">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cargo</th>
                            <th>Permissões</th>
                            <th class="w-28">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="font-semibold text-slate-700">{{ $role->name }}</td>
                                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="edit({{ $role->id }})" class="btn btn-xs btn-default" title="Editar"><i class="fas fa-pen"></i></button>
                                        <button wire:click="delete({{ $role->id }})" class="btn btn-xs btn-danger text-white"><i class="fas fa-trash"></i></button>
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
