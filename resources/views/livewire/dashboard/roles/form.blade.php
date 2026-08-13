<div>
    @section('title', 'Cargo')

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-group">
                        <label class="labelforms"><b>Nome do Cargo</b></label>
                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" />
                        @error('name')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Permissões</b></label>
                        <div class="mt-2 grid max-h-64 grid-cols-1 gap-x-4 overflow-y-auto rounded-xl border border-slate-200 bg-slate-50/60 p-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($allPermissions as $permission)
                                <label class="flex items-center gap-2 py-1">
                                    <input type="checkbox" class="rounded border-slate-300 text-forest-600 focus:ring-gold-400" wire:model="permissions" value="{{ $permission->name }}">
                                    <span class="text-sm text-slate-700">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary mt-4">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
