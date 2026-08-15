<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-search"></i> Posts</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Posts</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex flex-1 flex-wrap items-center gap-2">
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm min-w-40 flex-1"
                    placeholder="Pesquisar">

                <select wire:model.live="filterType" class="form-control form-control-sm w-28">
                    <option value="">Tipo</option>
                    <option value="artigo">Artigo</option>
                    <option value="noticia">Notícia</option>
                    <option value="pagina">Página</option>
                </select>

                <select wire:model.live="filterAutor" class="form-control form-control-sm w-40">
                    <option value="">Autor</option>
                    @foreach($autores as $autor)
                        <option value="{{ $autor->id }}">{{ $autor->name }}</option>
                    @endforeach
                </select>

                <button wire:click="clearFilters" class="btn btn-sm btn-light">
                    Limpar
                </button>

                <a wire:navigate href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary ml-auto">
                    <i class="fas fa-plus"></i> Cadastrar Novo
                </a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($posts->count())
                <div class="overflow-x-auto" x-data="{ showModal: false, imageUrl: '' }">
                    <table class="table table-hover">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-2">Capa</th>
                                <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('title')">
                                    Título <i class="fas fa-caret-down fa-fw ml-1"></i>
                                </th>
                                <th class="px-4 py-2 text-center">Categoria</th>
                                <th class="px-4 py-2 text-center">Views</th>
                                <th class="px-4 py-2 text-center">Imagens</th>
                                <th class="px-4 py-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr class="{{ $post->status ? '' : 'bg-amber-50/70' }}">
                                <td class="px-4 py-2 text-center">
                                    <img
                                        src="{{ $post->cover() }}"
                                        alt="{{ $post->title }}"
                                        class="w-16 cursor-pointer rounded-lg transition-transform hover:scale-105"
                                        @click="showModal = true; imageUrl = '{{ addslashes(url($post->nocover())) }}'">
                                </td>
                                <td class="px-4 py-2 font-medium text-slate-700">{{ $post->title }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{ $post->categoriaObject()->first()?->title ?? 'N/D' }}
                                </td>
                                <td class="px-4 py-2 text-center">{{ $post->views }}</td>
                                <td class="px-4 py-2 text-center">{{ $post->countimages() ? $post->countimages() : 0 }}</td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-forms.switch-toggle
                                            wire:key="safe-switch-{{ $post->id }}"
                                            wire:click="toggleStatus({{ $post->id }})"
                                            :checked="$post->status"
                                            size="sm"
                                            color="green"
                                        />
                                        <a target="_blank" href="{{ route('web.' . (
                                                                    $post->type == 'artigo' ? 'blog.artigo' : (
                                                                    $post->type == 'noticia' ? 'noticia' : 'pagina')), $post->slug) }}"
                                            class="btn btn-xs btn-info"
                                            title="Visualizar">
                                            <i class="fas fa-search"></i>
                                        </a>
                                        <a title="Editar Post" href="{{ route('admin.posts.edit', $post->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Post"
                                            wire:click="setDeleteId({{ $post->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/75"
                        x-transition>
                        <div class="relative">
                            <img :src="imageUrl" class="mx-auto max-h-[70vh] max-w-[70vw] rounded-lg object-contain shadow-xl">
                            <button type="button" @click="showModal = false"
                                    class="absolute -right-2 -top-2 flex h-8 w-8 items-center justify-center rounded-full bg-black/50 text-white transition hover:bg-black/75">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>

                @if($posts->hasMorePages())
                    <div class="text-center mt-4">
                        <button wire:click="loadMore" class="btn btn-primary">
                            <i class="fas fa-spinner mr-2"></i> Carregar mais
                        </button>
                    </div>
                @endif
            @else
                <div class="alert alert-info p-3">
                    Não foram encontrados registros!
                </div>
            @endif
        </div>
    </div>
</div>
