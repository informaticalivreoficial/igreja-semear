<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-images"></i> {{ $slide?->exists ? 'Editar Banner' : 'Cadastrar Banner' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.slides.index') }}">Slides</a></span>
            <span class="breadcrumb-item active">{{ $slide?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group">
                        <label class="labelforms"><b>*Título</b></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            placeholder="Título do banner" wire:model="title">
                        @error('title')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Subtítulo</b></label>
                        <input type="text" class="form-control" placeholder="Subtítulo do banner" wire:model="subtitle">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Categoria</b></label>
                        <input type="text" class="form-control" placeholder="Ex.: Destaque, Promoção..." wire:model="category">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Rótulo do Botão</b></label>
                        <input type="text" class="form-control" placeholder="Ex.: Saiba mais" wire:model="button_label">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Link</b></label>
                        <input type="text" class="form-control" placeholder="https://..." wire:model="link">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Expira em</b></label>
                        <div class="relative">
                            <i class="far fa-calendar-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text"
                                class="form-control pl-9"
                                x-data="{ value: @entangle('expires_at').defer }"
                                x-init="flatpickr($el, { dateFormat: 'd/m/Y', allowInput: true, defaultDate: value || null })"
                                wire:model="expires_at" placeholder="dd/mm/aaaa">
                        </div>
                        @error('expires_at')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>Conteúdo</b></label>
                    <textarea class="form-control" rows="4" placeholder="Descrição do banner" wire:model="content"></textarea>
                </div>

                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <div class="form-group">
                        <label class="labelforms"><b>Imagem</b></label>
                        <input type="file" class="block w-full text-sm text-slate-500
                            file:mr-4 file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2
                            file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
                            wire:model="image">
                        @error('image')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                        @if ($imagePath)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$imagePath) }}" alt="Prévia"
                                    class="rounded-lg border border-slate-200" style="max-height: 120px;">
                            </div>
                        @endif
                        @if ($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Prévia"
                                    class="rounded-lg border border-slate-200" style="max-height: 120px;">
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Opções</b></label>
                        <div class="space-y-3 rounded-xl border border-slate-200 bg-slate-50/60 p-4">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-forest-600 focus:ring-gold-400" id="show_title" wire:model="show_title">
                                <span class="text-sm text-slate-700">Exibir título</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-forest-600 focus:ring-gold-400" id="target" wire:model="target">
                                <span class="text-sm text-slate-700">Abrir link em nova aba</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-forest-600 focus:ring-gold-400" id="is_active" wire:model="is_active">
                                <span class="text-sm text-slate-700">Ativo</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check mr-2"></i>{{ $slide?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
