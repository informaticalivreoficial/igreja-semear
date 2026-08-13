<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-bullhorn"></i> {{ $announcement?->exists ? 'Editar Aviso' : 'Cadastrar Aviso' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.announcements.index') }}">Avisos</a></span>
            <span class="breadcrumb-item active">{{ $announcement?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <div class="form-group">
                        <label class="labelforms"><b>*Título</b></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="Título do aviso">
                        @error('title')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Data de publicação</b></label>
                        <input type="text" class="form-control" wire:model="publish_at" placeholder="dd/mm/aaaa">
                    </div>
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>*Conteúdo</b></label>
                    <textarea rows="6" class="form-control @error('content') is-invalid @enderror" wire:model="content" placeholder="Escreva o conteúdo do aviso..."></textarea>
                    @error('content')
                        <span class="error erro-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>Imagem de capa</b></label>
                    <input type="file" class="form-control" wire:model="cover" accept="image/*">
                    @error('cover')
                        <span class="error erro-feedback">{{ $message }}</span>
                    @enderror
                    @if ($cover)
                        <div class="mt-2">
                            <img src="{{ $cover->temporaryUrl() }}" alt="Preview" class="h-32 rounded-lg object-cover">
                        </div>
                    @elseif ($announcement?->exists && $announcement->cover)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$announcement->cover) }}" alt="Capa atual" class="h-32 rounded-lg object-cover">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" wire:model="status">
                        <span class="form-check-label"><b>Ativo</b></span>
                    </label>
                </div>

                <div class="mt-4 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check mr-2"></i>{{ $announcement?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
