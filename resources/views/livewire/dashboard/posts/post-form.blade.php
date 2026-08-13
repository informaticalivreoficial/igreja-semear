<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-pencil-alt"></i> {{ $post->exists ? 'Editar Post' : 'Cadastrar Post' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></span>
            <span class="breadcrumb-item active">{{ $post->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <div x-data="{
        tab: @entangle('currentTab'),
        init() {
            if (!this.tab) this.tab = 'dados';
        }
    }" class="w-full">
        {{-- Abas --}}
        <div class="flex space-x-1 border-b border-slate-200">
            <button type="button"
                    class="rounded-t-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="tab === 'dados' ? 'border-x border-t border-slate-200 bg-white text-forest-700 shadow-sm' : 'text-slate-500 hover:text-forest-600'"
                    @click="tab = 'dados'">
                <i class="fas fa-file-alt mr-1.5"></i> Dados
            </button>
            <button type="button"
                    class="rounded-t-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="tab === 'imagens' ? 'border-x border-t border-slate-200 bg-white text-forest-700 shadow-sm' : 'text-slate-500 hover:text-forest-600'"
                    @click="tab = 'imagens'">
                <i class="fas fa-images mr-1.5"></i> Imagens
            </button>
            <button type="button"
                    class="rounded-t-lg px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="tab === 'seo' ? 'border-x border-t border-slate-200 bg-white text-forest-700 shadow-sm' : 'text-slate-500 hover:text-forest-600'"
                    @click="tab = 'seo'">
                <i class="fas fa-search mr-1.5"></i> Seo
            </button>
        </div>

        <form wire:submit.prevent="save" autocomplete="off" class="card rounded-tl-none">
            {{-- Aba Dados --}}
            <div x-show="tab === 'dados'" x-transition class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group lg:col-span-2">
                        <label class="labelforms"><b>*Título</b></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title">
                        @error('title')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>*Autor</b></label>
                        <select class="form-control @error('autor') is-invalid @enderror" wire:model="autor">
                            <option value="">-- Selecione um autor --</option>
                            @forelse ($autores as $autorItem)
                                <option value="{{ $autorItem->id }}">{{ $autorItem->name }}</option>
                            @empty
                                <option value="{{ auth()->id() }}" selected>
                                    {{ auth()->user()->name }}
                                </option>
                            @endforelse
                        </select>
                        @error('autor')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>*Tipo</b></label>
                        <select id="type" wire:model.live="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">-- Selecione --</option>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category" class="labelforms"><b>*Categoria</b></label>
                        <select
                            id="category"
                            wire:model="category"
                            @disabled(!$type)
                            class="form-control @error('category') is-invalid @enderror">
                            <option value="">{{ $type ? 'Selecione uma Categoria' : 'Selecione o tipo primeiro' }}</option>
                            @if($type && isset($categories))
                                @foreach($categories as $cat)
                                    <option value="" disabled class="font-semibold">{{ $cat->title }}</option>
                                    @if($cat->children->isNotEmpty())
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;└─ {{ $child->title }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @error('category')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="comments" class="labelforms"><b>Permitir Comentários?</b></label>
                        <select id="comments" wire:model="comments" class="form-control">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Data da Publicação</b></label>
                        <div class="relative">
                            <i class="far fa-calendar-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" class="form-control pl-9" wire:model="publish_at" id="datepicker"
                                x-data="{ value: @entangle('publish_at').defer }" x-init="initFlatpickr()" x-ref="datepicker" />
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    @error('content')
                        <span class="erro-feedback mb-2 block">{{ $message }}</span>
                    @enderror
                    <label class="labelforms"><b>Conteúdo</b></label>
                    <x-editor-quill
                        :value="$this->content"
                        model="content"
                    />
                </div>
            </div>

            {{-- Aba Imagens --}}
            <div x-show="tab === 'imagens'" x-transition class="card-body">
                <div class="form-group md:w-1/2">
                    <label class="labelforms"><b>Legenda da Imagem de Capa</b></label>
                    <input type="text" class="form-control" wire:model="thumb_caption">
                </div>

                <hr class="my-5 border-slate-200">

                <label class="mb-2 mt-2 block font-semibold text-slate-500">📁 Upload de Imagens:</label>
                <input type="file" wire:model="images" class="block w-full text-sm text-slate-500
                    file:mr-4 file:rounded-full file:border-0 file:bg-forest-50 file:px-4 file:py-2
                    file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100" multiple/>

                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div x-data="{ showModal: false, imageUrl: null }">
                    <div class="mt-4 flex flex-wrap gap-4">
                        @foreach ($post->images ?? [] as $savedImage)
                            <div class="relative">
                                <img src="{{ Storage::url($savedImage->path) }}"
                                    class="h-32 w-32 cursor-pointer rounded-lg border object-cover
                                            {{ $savedImage->cover ? 'ring-4 ring-forest-500' : '' }}"
                                    @click="showModal = true; imageUrl = '{{ Storage::url($savedImage->path) }}'">

                                <button type="button"
                                        wire:click="removeSavedImage({{ $savedImage->id }})"
                                        class="absolute top-1 right-1 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white hover:bg-red-600">
                                    ✕
                                </button>

                                <button type="button"
                                        wire:click="toggleCover({{ $savedImage->id }})"
                                        class="absolute bottom-1 left-1 rounded bg-black/60 px-2 py-1 text-xs text-white hover:bg-black">
                                    {{ $savedImage->cover ? 'Remover capa' : 'Definir capa' }}
                                </button>
                            </div>
                        @endforeach

                        @foreach ($images as $index => $image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" class="h-32 w-32 cursor-pointer rounded-lg border object-cover"
                                    @click="showModal = true; imageUrl = '{{ $image->temporaryUrl() }}'">
                                <button type="button"
                                        wire:click="removeTempImage({{ $index }})"
                                        class="absolute top-1 right-1 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white hover:bg-red-600">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/75"
                        x-transition>
                        <div class="relative">
                            <img :src="imageUrl" class="mx-auto max-h-[70vh] max-w-[70vw] rounded-lg object-contain shadow-xl">
                            <button type="button" @click="showModal = false"
                                    class="absolute top-2 right-2 rounded-full bg-black/50 px-2 py-1 text-xl text-white">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aba Seo --}}
            <div x-show="tab === 'seo'" x-transition class="card-body">
                <div class="grid grid-cols-1 gap-x-6">
                    <div class="form-group">
                        <label class="labelforms"><b>Headline</b></label>
                        <input type="text" class="form-control" wire:model="excerpt">
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Meta Descrição</b></label>
                        <textarea class="form-control" rows="5" wire:model="metaDescription"></textarea>
                        @error('metaDescription')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>MetaTags</b></label>
                        <div
                            x-data="{
                                tags: @entangle('tags'),
                                input: '',
                                addTag() {
                                    const trimmed = this.input.trim();
                                    if (trimmed && !this.tags.includes(trimmed)) {
                                        this.tags.push(trimmed);
                                    }
                                    this.input = '';
                                },
                                removeTag(index) {
                                    this.tags.splice(index, 1);
                                }
                            }"
                            class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm"
                        >
                            <div class="mb-2 flex flex-wrap gap-2">
                                <template x-for="(tag, index) in tags" :key="index">
                                    <span class="flex items-center rounded-full bg-forest-600 px-3 py-1 text-sm text-white">
                                        <span x-text="tag"></span>
                                        <button type="button" @click="removeTag(index)" class="ml-2 hover:text-gold-300">&times;</button>
                                    </span>
                                </template>
                            </div>
                            <input
                                type="text"
                                x-model="input"
                                @keydown.enter.prevent="addTag"
                                placeholder="Digite uma tag e pressione Enter"
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ações --}}
            <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 bg-slate-50/70 px-5 py-4 rounded-b-2xl">
                <button type="button" wire:click="save('draft')" class="btn btn-default">
                    <i class="fas fa-save mr-1.5"></i>{{ $post->exists ? 'Atualizar Rascunho' : 'Salvar Rascunho' }}
                </button>
                <button type="button" wire:click="save('published')" class="btn btn-primary">
                    <i class="fas fa-check mr-1.5"></i>{{ $post->exists ? 'Atualizar e Publicar' : 'Salvar e Publicar' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let fp = null;

    function initFlatpickr() {
        const input = document.getElementById('datepicker');
        if (!input) return;

        if (fp) {
            fp.destroy();
        }

        fp = flatpickr(input, {
            dateFormat: "d/m/Y",
            allowInput: true,
            maxDate: "today",
            defaultDate: input.value
                ? input.value.split('-').reverse().join('/')
                : null,
            onChange: function (selectedDates, dateStr, instance) {
                input.value = instance.formatDate(selectedDates[0], 'd/m/Y');
                input.dispatchEvent(new Event('input'));
            }
        });
    }

    document.addEventListener("livewire:navigated", initFlatpickr);
</script>
