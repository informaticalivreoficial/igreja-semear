<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-calendar-alt"></i> {{ $event?->exists ? 'Editar Evento' : 'Cadastrar Evento' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Eventos</a></span>
            <span class="breadcrumb-item active">{{ $event?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group lg:col-span-1">
                        <label class="labelforms"><b>*Título</b></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" placeholder="Título do Evento" wire:model="title">
                        @error('title')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Tipo</b></label>
                        <select class="form-control" wire:model="type">
                            <option value="evento">Evento</option>
                            <option value="culto">Culto</option>
                            <option value="campanha">Campanha</option>
                            <option value="especial">Especial</option>
                        </select>
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
                        <h4 class="card-title text-slate-700"><strong>Data e Local</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>*Início</b></label>
                                <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror"
                                    wire:model="start_at">
                                @error('start_at')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Término</b></label>
                                <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror"
                                    wire:model="end_at">
                                @error('end_at')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Local</b></label>
                                <input type="text" class="form-control"
                                    placeholder="Local do evento" wire:model="location">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Conteúdo</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-3">
                            <div class="form-group lg:col-span-2" wire:ignore>
                                <label class="labelforms"><b>Descrição</b></label>
                                <x-editor-quill
                                    :value="$description"
                                    model="description"
                                />
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Imagem de capa</b></label>
                                <input type="file" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2
                                    file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
                                    wire:model="cover">
                                @error('cover')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                                @if ($event->cover)
                                    <img src="{{ asset('storage/' . $event->cover) }}" class="mt-2 rounded-lg border border-slate-200" style="max-height: 160px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check mr-2"></i>{{ $event?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
