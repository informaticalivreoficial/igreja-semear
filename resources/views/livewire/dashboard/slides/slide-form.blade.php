<div>
    @section('title', $titlee)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-images mr-2"></i> {{ $slide?->exists ? 'Editar Banner' : 'Cadastrar Banner' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.slides.index') }}">Slides</a></li>
                        <li class="breadcrumb-item active">{{ $slide?->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Título</b></label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                placeholder="Título do banner" wire:model="titulo">
                            @error('titulo')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Subtítulo</b></label>
                            <input type="text" class="form-control" placeholder="Subtítulo do banner" wire:model="subtitulo">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Categoria</b></label>
                            <input type="text" class="form-control" placeholder="Ex.: Destaque, Promoção..." wire:model="categoria">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Rótulo do Botão</b></label>
                            <input type="text" class="form-control" placeholder="Ex.: Saiba mais" wire:model="botaolabel">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Link</b></label>
                            <input type="text" class="form-control" placeholder="https://..." wire:model="link">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Expira em</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text"
                                    class="form-control"
                                    x-data="{ value: @entangle('expira').defer }"
                                    x-init="flatpickr($el, { dateFormat: 'd/m/Y', allowInput: true, defaultDate: value || null })"
                                    wire:model="expira" placeholder="dd/mm/aaaa">
                            </div>
                            @error('expira')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="labelforms"><b>Conteúdo</b></label>
                            <textarea class="form-control" rows="4" placeholder="Descrição do banner" wire:model="content"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Imagem</b></label>
                            <input type="file" class="form-control-file" wire:model="imagem">
                            @error('imagem')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                            @if ($imagemPath)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$imagemPath) }}" alt="Prévia"
                                        class="img-fluid" style="max-height: 120px; border-radius: 4px;">
                                </div>
                            @endif
                            @if ($imagem)
                                <div class="mt-2">
                                    <img src="{{ $imagem->temporaryUrl() }}" alt="Prévia"
                                        class="img-fluid" style="max-height: 120px; border-radius: 4px;">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Opções</b></label>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="exibir_titulo" wire:model="exibir_titulo">
                                <label class="custom-control-label" for="exibir_titulo">Exibir título</label>
                            </div>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="target" wire:model="target">
                                <label class="custom-control-label" for="target">Abrir link em nova aba</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" wire:model="status">
                                <label class="custom-control-label" for="status">Ativo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-right">
                    <div class="col-12 pb-4 mt-3">
                        <button type="submit" class="btn btn-lg btn-success p-3">
                            <i class="nav-icon fas fa-check mr-2"></i>{{ $slide?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
