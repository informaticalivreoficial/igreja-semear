<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-tags"></i> Categorias</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Categorias</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <input type="text" wire:model.live="search" class="form-control form-control-sm min-w-40 flex-1" placeholder="Pesquisar">

            <button type="button"
                @click="$dispatch('open-category-modal', { editId: null, categoryId: null })"
                class="btn btn-sm btn-primary shrink-0">
                <i class="fas fa-plus"></i> Cadastrar Novo
            </button>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if($categories->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="text-center">Exibir?</th>
                                <th class="text-center">Criado em</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="{{ $category->status ? '' : 'bg-amber-50/70' }}">
                                    <td class="font-semibold text-slate-700"><i class="fas fa-angle-right mr-2 text-forest-600"></i> {{ $category->title }}</td>
                                    <td class="text-center">{{ $category->status ? 'Sim' : 'Não' }}</td>
                                    <td class="text-center whitespace-nowrap">{{ date('d/m/Y', strtotime($category->created_at)) }}</td>
                                    <td class="text-center">{{ $category->type }}</td>
                                    <td>
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            <x-forms.switch-toggle
                                                wire:key="safe-switch-{{ $category->id }}"
                                                wire:click="toggleStatus({{ $category->id }})"
                                                :checked="$category->status"
                                                size="sm"
                                                color="green"
                                            />
                                            <button
                                                type="button"
                                                data-id="{{ $category->id }}"
                                                x-on:click="$dispatch('open-category-modal', { editId: parseInt($el.dataset.id) })"
                                                class="btn btn-xs btn-default"
                                                title="Editar">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button
                                                type="button"
                                                data-parent-id="{{ $category->id }}"
                                                x-on:click="$dispatch('open-category-modal', { categoryId: parseInt($el.dataset.parentId) })"
                                                class="btn btn-xs btn-success">
                                                <i class="fas fa-plus"></i> Subcategoria
                                            </button>
                                            <button type="button"
                                                class="btn btn-xs btn-danger"
                                                title="Excluir Categoria"
                                                wire:click="setDeleteId({{ $category->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @if ($category->children->count())
                                    @foreach($category->children as $subcategory)
                                    <tr class="{{ $subcategory->status ? 'bg-forest-50/40' : 'bg-amber-50/70' }}">
                                        <td class="pl-10"><i class="fas fa-angle-double-right mr-2 text-forest-500"></i> {{ $subcategory->title }}</td>
                                        <td class="text-center">{{ $subcategory->status ? 'Sim' : 'Não' }}</td>
                                        <td class="text-center whitespace-nowrap">{{ date('d/m/Y', strtotime($subcategory->created_at)) }}</td>
                                        <td class="text-center">—</td>
                                        <td>
                                            <div class="flex flex-wrap items-center justify-center gap-2">
                                                <x-forms.switch-toggle
                                                    wire:key="safe-switch-{{ $subcategory->id }}"
                                                    wire:click="toggleStatus({{ $subcategory->id }})"
                                                    :checked="$subcategory->status"
                                                    size="sm"
                                                    color="green"
                                                />
                                                <button
                                                    type="button"
                                                    data-edit-id="{{ $subcategory->id }}"
                                                    x-on:click="$dispatch('open-category-modal', { editId: parseInt($el.dataset.editId) })"
                                                    class="btn btn-xs btn-default"
                                                    title="Editar">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-xs btn-danger"
                                                    title="Excluir Subcategoria"
                                                    wire:click="setDeleteId({{ $subcategory->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="alert alert-info mb-0">
                    Nenhum registro encontrado!
                </div>
            @endif

            {{-- Modal de categoria --}}
            <div
                x-data="{ open: false }"
                x-on:open-category-modal.window="
                    open = true;
                    Livewire.dispatch('loadCategory', { payload: $event.detail })
                "
                x-on:category-saved.window="open = false"
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none"
                class="fixed inset-0 z-[70] flex items-center justify-center bg-forest-900/60 p-4 backdrop-blur-sm"
            >
                <div class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white shadow-2xl">
                    <livewire:dashboard.posts.cat-post-form />
                    <div class="flex justify-end gap-2 border-t border-slate-100 px-6 py-4">
                        <button
                            @click="
                                open = false;
                                Livewire.dispatch('resetForm')
                            "
                            class="btn btn-default btn-sm">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
