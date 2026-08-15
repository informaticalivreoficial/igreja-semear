<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-images"></i> Banners - Slides</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Slides</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <input type="text"
                wire:model.live.debounce.500ms="search"
                class="form-control form-control-sm min-w-40 flex-1"
                placeholder="Pesquisar slide">

            <a wire:navigate href="{{ route('admin.slides.create') }}" class="btn btn-sm btn-primary shrink-0">
                <i class="fas fa-plus"></i> Cadastrar Novo
            </a>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($slides->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
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
                                    <img src="{{ $slide->image_url ?: asset('backend/assets/images/image.jpg') }}"
                                        alt="{{ $slide->title }}" width="80" height="45"
                                        class="rounded-md object-cover">
                                </td>
                                <td>
                                    <p class="font-semibold text-slate-700">{{ $slide->title }}</p>
                                    @if ($slide->subtitle)
                                        <p class="text-xs text-slate-500">{{ $slide->subtitle }}</p>
                                    @endif
                                </td>
                                <td class="text-center">{{ $slide->category ?? '—' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $slide->expires_at?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-center">
                                    @if ($slide->show_title)
                                        <span class="badge badge-success">Sim</span>
                                    @else
                                        <span class="badge badge-secondary">Não</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <x-forms.switch-toggle
                                        :checked="(bool) $slide->is_active"
                                        wire:click="toggleStatus({{ $slide->id }})" />
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a title="Editar Slide" href="{{ route('admin.slides.edit', $slide->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Slide"
                                            wire:click="setDeleteId({{ $slide->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $slides->links() }}
                </div>
            @else
                <div class="alert alert-info p-3">
                    Não foram encontrados registros!
                </div>
            @endif
        </div>
    </div>
</div>
