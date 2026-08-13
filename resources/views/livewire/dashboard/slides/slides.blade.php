<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-images mr-2"></i> Banners - Slides</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Slides</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-8 my-2">
                    <div class="card-tools">
                        <input type="text"
                            wire:model.live.debounce.500ms="search"
                            class="form-control form-control-sm"
                            style="max-width: 220px;"
                            placeholder="Pesquisar slide">
                    </div>
                </div>
                <div class="col-12 col-sm-4 my-2 text-sm-right">
                    <a wire:navigate href="{{ route('admin.slides.create') }}"
                        class="btn btn-sm btn-default">
                        <i class="fas fa-plus mr-2"></i> Cadastrar Novo
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if ($slides->count())
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Imagem</th>
                            <th>Título</th>
                            <th class="text-center">Categoria</th>
                            <th class="text-center">Expira em</th>
                            <th class="text-center">Exibir Título</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slides as $slide)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $slide->getUrlImagemAttribute() ?: asset('backend/assets/images/image.jpg') }}"
                                    alt="{{ $slide->titulo }}" width="80" height="45"
                                    style="object-fit: cover; border-radius: 4px;">
                            </td>
                            <td>
                                <b>{{ $slide->titulo }}</b>
                                @if ($slide->subtitulo)
                                    <br><small class="text-muted">{{ $slide->subtitulo }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $slide->categoria ?? '—' }}</td>
                            <td class="text-center">{{ $slide->expira?->format('d/m/Y') ?? '—' }}</td>
                            <td class="text-center">
                                @if ($slide->exibir_titulo)
                                    <span class="badge badge-success">Sim</span>
                                @else
                                    <span class="badge badge-secondary">Não</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <x-forms.switch-toggle
                                    :checked="(bool) $slide->status"
                                    wire:click="toggleStatus({{ $slide->id }})" />
                            </td>
                            <td class="text-center">
                                <a title="Editar Slide" href="{{ route('admin.slides.edit', $slide->id) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button"
                                    class="btn btn-xs bg-danger text-white"
                                    title="Excluir Slide"
                                    wire:click="setDeleteId({{ $slide->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $slides->links() }}
                </div>
            @else
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
