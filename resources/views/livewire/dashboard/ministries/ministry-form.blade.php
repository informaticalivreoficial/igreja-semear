<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hands-helping"></i> {{ $ministry?->exists ? 'Editar Ministério' : 'Cadastrar Ministério' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.ministries.index') }}">Ministérios</a></span>
            <span class="breadcrumb-item active">{{ $ministry?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="form-group">
                        <label class="labelforms"><b>*Nome</b></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Nome do Ministério" wire:model="name">
                        @error('name')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Cor</b></label>
                        <input type="color" class="h-10 w-full cursor-pointer rounded-lg border border-slate-300 p-1"
                            wire:model="color">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Líder</b></label>
                        <select class="form-control @error('leader_id') is-invalid @enderror" wire:model="leader_id">
                            <option value="">Selecione</option>
                            @foreach ($leaders as $leader)
                                <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                            @endforeach
                        </select>
                        @error('leader_id')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Status</b></label>
                        <div class="pt-2">
                            <x-forms.switch-toggle
                                wire:model="status"
                                :checked="$status"
                                size="md"
                                color="green"
                            />
                        </div>
                    </div>
                </div>

                <div class="card bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Membros</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="labelforms"><b>Papel no ministério</b></label>
                            <select class="form-control w-full sm:w-1/2" wire:model="memberRole">
                                <option value="membro">Membro</option>
                                <option value="coordenador">Coordenador</option>
                                <option value="secretario">Secretário(a)</option>
                                <option value="musico">Músico(a)</option>
                                <option value="adorador">Adorador(a)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-2">
                            <div>
                                <label class="labelforms"><b>Membros selecionados</b></label>
                                <div class="max-h-[220px] overflow-y-auto rounded-lg border border-slate-200 bg-white p-3">
                                    @forelse ($memberIds as $id)
                                        @php $member = $members->firstWhere('id', (int) $id); @endphp
                                        @if ($member)
                                            <label class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-brand-50" wire:key="member-{{ $id }}">
                                                <input class="rounded border-slate-300 text-brand-600 focus:ring-brand-400" type="checkbox"
                                                    id="member-{{ $id }}" value="{{ $id }}" wire:model="memberIds">
                                                <span class="text-sm text-slate-700">{{ $member->name }}</span>
                                            </label>
                                        @endif
                                    @empty
                                        <span class="text-sm text-slate-400">Nenhum membro selecionado. Marque abaixo.</span>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <label class="labelforms"><b>Buscar e adicionar membros</b></label>
                                <input type="text" id="member-search" class="form-control form-control-sm mb-2"
                                    placeholder="Buscar membro..." @input="$refs.memberlist.querySelectorAll('label').forEach(el => el.style.display = el.textContent.toLowerCase().includes($event.target.value.toLowerCase()) ? '' : 'none')">
                                <div class="max-h-[220px] overflow-y-auto rounded-lg border border-slate-200 bg-white p-3" x-ref="memberlist">
                                    @foreach ($members as $member)
                                        <label class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-brand-50" wire:key="allmember-{{ $member->id }}">
                                            <input class="rounded border-slate-300 text-brand-600 focus:ring-brand-400" type="checkbox"
                                                id="allmember-{{ $member->id }}" value="{{ $member->id }}" wire:model="memberIds">
                                            <span class="text-sm text-slate-700">{{ $member->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('memberIds')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Descrição</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label class="labelforms"><b>Descrição</b></label>
                                <textarea class="form-control" rows="4" wire:model="description"
                                    placeholder="Descreva o ministério, sua visão e atividades..."></textarea>
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Imagem de capa</b></label>
                                <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2
                                    file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
                                    wire:model="cover">
                                @error('cover')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                                @if ($ministry->cover)
                                    <img src="{{ asset('storage/' . $ministry->cover) }}" class="mt-2 rounded-lg border border-slate-200" style="max-height: 120px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-2 pb-2 sm:flex-row sm:justify-end">
                    <button type="submit" class="btn btn-primary btn-lg w-full sm:w-auto">
                        <i class="fas fa-check mr-2"></i>{{ $ministry?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
