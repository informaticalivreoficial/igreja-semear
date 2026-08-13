<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-alt mr-2"></i> {{ $event?->exists ? 'Editar Evento' : 'Cadastrar Evento' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Eventos</a></li>
                        <li class="breadcrumb-item active">{{ $event?->exists ? 'Editar' : 'Cadastrar' }}</li>
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
                            <label class="labelforms"><b>*Título</b></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="title" placeholder="Título do Evento" wire:model="title">
                            @error('title')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group">
                            <label class="labelforms"><b>Tipo</b></label>
                            <select class="form-control" wire:model="type">
                                <option value="evento">Evento</option>
                                <option value="culto">Culto</option>
                                <option value="campanha">Campanha</option>
                                <option value="especial">Especial</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
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
                        <h4><strong>Data e Local</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>*Início</b></label>
                                    <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror"
                                        wire:model="start_at">
                                    @error('start_at')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>Término</b></label>
                                    <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror"
                                        wire:model="end_at">
                                    @error('end_at')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>Local</b></label>
                                    <input type="text" class="form-control"
                                        placeholder="Local do evento" wire:model="location">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card text-muted">
                    <div class="card-header">
                        <h4><strong>Conteúdo</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-group" wire:ignore>
                                    <label class="labelforms"><b>Descrição</b></label>
                                    <x-editor-quill
                                        :value="$description"
                                        model="description"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>Imagem de capa</b></label>
                                    <input type="file" class="form-control-file" wire:model="cover">
                                    @error('cover')
                                        <span class="error erro-feedback">{{ $message }}</span>
                                    @enderror
                                    @if ($event->cover)
                                        <img src="{{ asset('storage/' . $event->cover) }}" class="img-fluid mt-2 rounded" style="max-height: 160px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-right">
                    <div class="col-12 pb-4 mt-3">
                        <button type="submit" class="btn btn-lg btn-success p-3">
                            <i class="nav-icon fas fa-check mr-2"></i>{{ $event?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
