<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hands-helping mr-2"></i> {{ $ministry?->exists ? 'Editar Ministério' : 'Cadastrar Ministério' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ministries.index') }}">Ministérios</a></li>
                        <li class="breadcrumb-item active">{{ $ministry?->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="labelforms"><b>*Nome</b></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Nome do Ministério" wire:model="name">
                            @error('name')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Cor</b></label>
                            <input type="color" class="form-control form-control-color" style="height: 38px;"
                                wire:model="color">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
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
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
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
                </div>

                <div class="card text-muted">
                    <div class="card-header">
                        <h4><strong>Membros</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="labelforms"><b>Papel no ministério</b></label>
                                    <select class="form-control" wire:model="memberRole">
                                        <option value="membro">Membro</option>
                                        <option value="coordenador">Coordenador</option>
                                        <option value="secretario">Secretário(a)</option>
                                        <option value="musico">Músico(a)</option>
                                        <option value="adorador">Adorador(a)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="labelforms"><b>Membros selecionados</b></label>
                                <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;">
                                    @forelse ($memberIds as $id)
                                        @php $member = $members->firstWhere('id', (int) $id); @endphp
                                        @if ($member)
                                            <div class="form-check" wire:key="member-{{ $id }}">
                                                <input class="form-check-input" type="checkbox"
                                                    id="member-{{ $id }}" value="{{ $id }}" wire:model="memberIds">
                                                <label class="form-check-label" for="member-{{ $id }}">{{ $member->name }}</label>
                                            </div>
                                        @endif
                                    @empty
                                        <span class="text-muted">Nenhum membro selecionado. Marque abaixo.</span>
                                    @endforelse
                                </div>
                                <div class="mt-3" x-data="{}">
                                    <input type="text" id="member-search" class="form-control form-control-sm mb-2"
                                        placeholder="Buscar membro..." @input="$refs.memberlist.querySelectorAll('.form-check').forEach(el => el.style.display = el.textContent.toLowerCase().includes($event.target.value.toLowerCase()) ? '' : 'none')">
                                    <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;" x-ref="memberlist">
                                        @foreach ($members as $member)
                                            <div class="form-check" wire:key="allmember-{{ $member->id }}">
                                                <input class="form-check-input" type="checkbox"
                                                    id="allmember-{{ $member->id }}" value="{{ $member->id }}" wire:model="memberIds">
                                                <label class="form-check-label" for="allmember-{{ $member->id }}">{{ $member->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('memberIds')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card text-muted">
                    <div class="card-header">
                        <h4><strong>Descrição</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="labelforms"><b>Descrição</b></label>
                                    <textarea class="form-control" rows="4" wire:model="description"
                                        placeholder="Descreva o ministério, sua visão e atividades..."></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="labelforms"><b>Imagem de capa</b></label>
                                    <input type="file" class="form-control-file" wire:model="cover">
                                    @error('cover')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror
                                    @if ($ministry->cover)
                                        <img src="{{ asset('storage/' . $ministry->cover) }}" class="img-fluid mt-2 rounded" style="max-height: 120px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-right">
                    <div class="col-12 pb-4 mt-3">
                        <button type="submit" class="btn btn-lg btn-success p-3">
                            <i class="nav-icon fas fa-check mr-2"></i>{{ $ministry?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
