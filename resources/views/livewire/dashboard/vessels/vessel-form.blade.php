<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-industry mr-2"></i> {{ $vessel->exists ? 'Editar' : 'Cadastrar' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vessels.index') }}">Embarcações</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $vessel->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{
        tab: @entangle('currentTab'),
            init() {
                if (!this.tab) this.tab = 'dados';
            }
        }" class="w-full bg-white">
        <!-- Abas -->
        <div class="flex space-x-2 border-b border-green-300">
            <button type="button"
                    class="px-4 py-4 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'dados' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'dados'">
                📝 Dados
            </button>
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'imagens' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'imagens'">
                📷 Imagens
            </button>                     
        </div>

        <!-- Conteúdo da aba Dados -->
        <div x-show="tab === 'dados'" x-transition>
            <div class="bg-white">
                <div class="card-body text-muted">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                            <x-forms.input
                                label="Embarcação"
                                name="name"
                            />
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                            <x-forms.select
                                name="company_id"
                                label="Operadora"
                            >
                                <option value="">Selecione uma operadora</option>

                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">
                                        {{ $company->alias_name }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <x-forms.input
                                label="Capacidade"
                                name="capacity"
                            />
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <x-forms.input
                                label="Ano"
                                name="year"
                            />                                        
                        </div> 
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <x-forms.input
                                label="Tamanho (m)"
                                name="size"
                            />
                        </div>  
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <x-forms.input
                                label="Banheiros"
                                name="bathroom"
                            />
                        </div>  
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <x-forms.select
                                name="type"
                                label="Tipo"
                            >
                                <option value="">Selecione</option>
                                <option value="Lancha">Lancha</option>
                                <option value="Iate">Iate</option>
                                <option value="Catamarã">Catamarã</option>
                                <option value="Escuna">Escuna</option>
                                <option value="Veleiro">Veleiro</option>
                                <option value="Jet Ski">Jet Ski</option>
                            </x-forms.select>
                        </div>                     
                    </div> 
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            {{-- CARD: COMODIDADES --}}
                            <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

                                <div
                                    class="flex items-center gap-3 px-6 py-4"
                                    style="border-bottom: 1px solid #f0ece4;"
                                >

                                    <div
                                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                        style="background-color: rgba(22,163,183,0.1);"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            style="color: #16a3b7;"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M9 12l2 2 4-4"/>
                                            <path d="M21 12c0 1.66-.67 3.16-1.76 4.24A5.98 5.98 0 0115 18H9a6 6 0 110-12h6a6 6 0 016 6z"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="text-sm font-bold" style="color: #051e34;">
                                            Comodidades
                                        </h2>

                                        <p class="text-xs" style="color: #87c2c0;">
                                            Recursos disponíveis na embarcação.
                                        </p>
                                    </div>

                                </div>

                                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                                    {{-- CHURRASQUEIRA --}}
                                    <label
                                        class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                                        style="border-color: #e8e4d8;"
                                    >
                                        <input
                                            type="checkbox"
                                            wire:model="barbecue"
                                            class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                                        >

                                        <span class="text-sm font-medium" style="color: #051e34;">
                                            🍖 Churrasqueira
                                        </span>
                                    </label>

                                    {{-- SUITE --}}
                                    <label
                                        class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                                        style="border-color: #e8e4d8;"
                                    >
                                        <input
                                            type="checkbox"
                                            wire:model="suite"
                                            class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                                        >

                                        <span class="text-sm font-medium" style="color: #051e34;">
                                            🛏 Suíte
                                        </span>
                                    </label>

                                    {{-- SOM --}}
                                    <label
                                        class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                                        style="border-color: #e8e4d8;"
                                    >
                                        <input
                                            type="checkbox"
                                            wire:model="sound_system"
                                            class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                                        >

                                        <span class="text-sm font-medium" style="color: #051e34;">
                                            🎵 Som
                                        </span>
                                    </label>

                                    {{-- COZINHA --}}
                                    <label
                                        class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                                        style="border-color: #e8e4d8;"
                                    >
                                        <input
                                            type="checkbox"
                                            wire:model="kitchen"
                                            class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                                        >

                                        <span class="text-sm font-medium" style="color: #051e34;">
                                            🍳 Cozinha
                                        </span>
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>                    

                    <div class="row">
                        <div class="col-12 mb-1"> 
                            <div class="form-group">
                                <label class="labelforms"><b>Informações Adicionais:</b></label>
                                <textarea class="form-control" rows="5" wire:model="information">{{ $information ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Conteúdo da aba Imagens -->
        <div x-show="tab === 'imagens'" x-transition class="relative">
            <div
                wire:loading
                wire:target="images"
                class="absolute inset-0 bg-white/80 flex items-center justify-center z-[10000]"
            >
                <div class="flex flex-col items-center gap-2">
                    <svg class="animate-spin h-8 w-8 text-blue-600"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>

                    <span class="text-sm text-gray-700 font-medium">
                        Carregando imagens...
                    </span>
                </div>
            </div>

            <div class="bg-white p-4">                

                <label class="block font-semibold mb-2 mt-2 text-muted">📁 Upload de Imagens:</label>
                <input type="file" wire:model="images" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple/>

                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Informação sobre ordenação -->
                @if(count($vessel->images ?? []) > 1)
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded">
                        <p class="text-sm text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <strong>Dica:</strong> Arraste e solte as imagens para reordená-las. A ordem será salva automaticamente.
                        </p>
                    </div>
                @endif

                
                <div x-data="imageGallery()">
                    <!-- Galeria de Imagens com Drag & Drop -->
                    <div class="flex flex-wrap gap-4 mt-4" id="sortable-gallery">
                        {{-- Imagens já salvas (vindas do banco) --}}
                        @foreach ($vessel->images ?? [] as $savedImage)
                            <div 
                                class="relative image-item cursor-move"
                                data-id="{{ $savedImage->id }}"
                                draggable="true"
                                @dragstart="dragStart($event)"
                                @dragover.prevent="dragOver($event)"
                                @drop="drop($event)"
                                @dragend="dragEnd($event)"
                            >
                                <img src="{{ Storage::url($savedImage->path) }}"
                                    class="w-32 h-32 object-cover rounded border cursor-pointer transition-transform hover:scale-105
                                            {{ $savedImage->cover ? 'ring-4 ring-green-500' : '' }}"
                                    @click="showModal = true; imageUrl = '{{ Storage::url($savedImage->path) }}'">

                                {{-- Indicador de drag --}}
                                <div class="absolute top-1 left-1 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </div>

                                {{-- Número da ordem --}}
                                <div class="absolute top-1 left-10 bg-blue-600 text-white text-xs px-2 py-1 rounded font-bold">
                                    {{ $loop->index + 1 }}
                                </div>

                                {{-- Botão de excluir --}}
                                <button type="button"
                                        wire:click="removeSavedImage({{ $savedImage->id }})"
                                        class="absolute top-1 right-1 w-6 h-6 flex items-center justify-center bg-red-500 text-white rounded-full text-xs hover:bg-red-600">
                                    ✕
                                </button>

                                {{-- Botão de definir/remover capa --}}
                                <button type="button"
                                        wire:click="toggleCover({{ $savedImage->id }})"
                                        class="absolute bottom-1 left-1 bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded hover:bg-black">
                                    {{ $savedImage->cover ? 'Remover capa' : 'Definir capa' }}
                                </button>                                                                   
                            </div>
                        @endforeach

                        {{-- Imagens recém-uploadadas via Livewire --}}
                        @foreach ($images as $index => $image)
                            <div class="relative">
                                <img src="{!! $image->temporaryUrl() !!}" class="w-32 h-32 object-cover rounded border cursor-pointer opacity-70"
                                    @click="showModal = true; imageUrl = '{!! $image->temporaryUrl() !!}'">
                                
                                {{-- Badge de nova imagem --}}
                                <div class="absolute top-1 left-1 bg-yellow-500 text-white text-xs px-2 py-1 rounded font-bold">
                                    NOVA
                                </div>
                                
                                <button type="button"
                                        wire:click="removeTempImage({{ $index }})"
                                        class="absolute top-1 right-1 w-6 h-6 flex items-center justify-center bg-red-500 text-white rounded-full text-xs hover:bg-red-600">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal de imagem -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]"
                        x-transition
                        @click.self="showModal = false">
                        <div class="relative">
                            <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                            <button type="button" @click="showModal = false"
                                    class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-3 py-1 hover:bg-opacity-75">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row text-right p-4 bg-white">
            <div class="col-12 mb-4">
                <button 
                    wire:loading.attr="disabled"
                    wire:target="images"
                    type="button" 
                    wire:click="save('draft')" class="btn btn-info"><i class="nav-icon fas fa-check mr-2"></i>{{ $vessel->exists ? 'Atualizar Rascunho' : 'Salvar Rascunho' }}</button>
                <button 
                    wire:loading.attr="disabled"
                    wire:target="images"
                    type="button" 
                    wire:click="save('published')" 
                class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i>{{ $vessel->exists ? 'Atualizar e Publicar' : 'Salvar e Publicar' }}</button>
            </div>
        </div>


</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-first-error', () => {
                setTimeout(() => {
                    const error = document.querySelector('.erro-feedback');
                    if (!error) return;
                    const y = error.getBoundingClientRect().top + window.pageYOffset - 120;
                    window.scrollTo({
                        top: y,
                        behavior: 'smooth'
                    });
                }, 100);
            });
        });

        function tagInputComponent(tagsBinding) {
            return {
                tags: tagsBinding,
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
            };
        }

        function imageGallery() {
            return {
                showModal: false,
                imageUrl: null,
                draggedElement: null,
                
                dragStart(e) {
                    this.draggedElement = e.target.closest('.image-item');
                    this.draggedElement.classList.add('opacity-50', 'scale-95');
                    e.dataTransfer.effectAllowed = 'move';
                },
                
                dragOver(e) {
                    e.preventDefault();
                    const container = e.currentTarget.parentElement;
                    const afterElement = this.getDragAfterElement(container, e.clientX, e.clientY);
                    const currentElement = e.currentTarget.closest('.image-item');
                    
                    if (afterElement == null) {
                        container.appendChild(this.draggedElement);
                    } else {
                        container.insertBefore(this.draggedElement, afterElement);
                    }
                },
                
                drop(e) {
                    e.preventDefault();
                    this.updateOrder();
                },
                
                dragEnd(e) {
                    this.draggedElement.classList.remove('opacity-50', 'scale-95');
                    this.draggedElement = null;
                },
                
                getDragAfterElement(container, x, y) {
                    const draggableElements = [...container.querySelectorAll('.image-item:not(.opacity-50)')];
                    
                    return draggableElements.reduce((closest, child) => {
                        const box = child.getBoundingClientRect();
                        const offsetX = x - box.left - box.width / 2;
                        const offsetY = y - box.top - box.height / 2;
                        const offset = Math.sqrt(offsetX * offsetX + offsetY * offsetY);
                        
                        if (offset < closest.offset && offsetX < 0) {
                            return { offset: offset, element: child };
                        } else {
                            return closest;
                        }
                    }, { offset: Number.POSITIVE_INFINITY }).element;
                },
                
                updateOrder() {
                    const gallery = document.getElementById('sortable-gallery');
                    const imageItems = gallery.querySelectorAll('.image-item');
                    const order = [];
                    
                    imageItems.forEach((item, index) => {
                        const id = item.getAttribute('data-id');
                        order.push({ id: parseInt(id), position: index + 1 });
                    });
                    
                    // Envia a nova ordem para o Livewire
                    @this.call('updateImageOrder', order);
                    
                    // Feedback visual
                    this.showSuccessMessage();
                },
                
                showSuccessMessage() {
                    const message = document.createElement('div');
                    message.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity';
                    message.innerHTML = '✓ Ordem das imagens atualizada!';
                    document.body.appendChild(message);
                    
                    setTimeout(() => {
                        message.style.opacity = '0';
                        setTimeout(() => message.remove(), 300);
                    }, 2000);
                }
            }
        }
</script>
@endpush


@push('styles')
    <style>
        .image-item {
            transition: transform 0.2s, opacity 0.2s;
        }

        .image-item:hover {
            transform: translateY(-2px);
        }

        .image-item.opacity-50 {
            opacity: 0.5;
        }

        .image-item.scale-95 {
            transform: scale(0.95);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush