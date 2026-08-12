<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-industry mr-2"></i> {{ $company->exists ? 'Editar' : 'Cadastrar' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.companies.index') }}">Empresas</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $company->exists ? 'Editar' : 'Cadastrar' }}</li>
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
            <button type="button"
                    class="px-4 py-2 text-sm font-medium rounded-t-lg focus:outline-none transition-all duration-200"
                    :class="tab === 'seo' ? 'bg-white border-l border-t border-r text-blue-600' : 'text-gray-500 hover:text-blue-500'"
                    @click="tab = 'seo'">
                🔍 Seo
            </button>         
        </div>

        <!-- Conteúdo da aba Dados -->
        <div x-show="tab === 'dados'" x-transition>
            <div class="bg-white">
                <div class="card-body text-muted">
                    <div class="row">                        
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3"> 
                            <div class="form-group">
                                <label class="labelforms text-muted">
                                    <b>Marcar como Verificada?</b>
                                </label>
                                <div class="form-check">
                                    <input id="highlightsim" class="form-check-input" type="radio" value="1" wire:model="highlight">
                                    <label for="highlightsim" class="form-check-label mr-5">Sim</label>
                                    <input id="highlightnao" class="form-check-input" type="radio" value="0" wire:model="highlight">
                                    <label for="highlightnao" class="form-check-label">Não</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-2 col-lg-2">
                            <x-forms.input
                                label="Comissão:"
                                name="commission_rate"
                                type="number"
                                step="0.01"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <x-forms.input
                                label="Responsável:"
                                name="responsable_name"
                            />
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <x-forms.input
                                label="Email do Responsável:"
                                name="responsable_email"
                            />
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>CPF</b></label>
                                <input type="text" class="form-control" placeholder="000.000.000-00" id="responsable_cpf" wire:model="responsable_cpf" x-mask="999.999.999-99" />                                
                            </div>                                        
                        </div>                        
                    </div>
                    <div class="row mb-3">  
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <x-forms.input
                                    label="*Nome Fantasia:"
                                    name="alias_name"
                                    placeholder="Nome da empresa"
                                />
                                @error('alias_name')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>Razão Social:</b></label>
                                <input class="form-control" id="social_name" wire:model="social_name" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>CNPJ:</b></label>
                                <input class="form-control" x-mask="99.999.999/9999-99" id="document_company" wire:model="document_company" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>Cadastur:</b></label>
                                <input class="form-control" x-mask="99.999.999/9999-99" id="cadastur" wire:model="cadastur" />
                            </div>
                        </div>                                      
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>Inscrição Estadual:</b></label>
                                <input class="form-control" id="document_company_secondary" wire:model="document_company_secondary" />
                            </div>
                        </div>                                      
                        <div class="col-12 col-sm-6 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label class="labelforms"><b>Ano de início:</b></label>
                                <input class="form-control" id="first_year" wire:model="first_year" />
                            </div>
                        </div>                                      
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>Telefone fixo:</b></label>
                                        <input type="text" class="form-control" placeholder="(00) 0000-0000"
                                            x-mask="(99) 9999-9999" wire:model="phone" id="phone">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Celular:</b></label>
                                        <input type="text" class="form-control @error('cell_phone') is-invalid @enderror" placeholder="(00) 00000-0000"
                                            x-mask="(99) 99999-9999" wire:model="cell_phone"
                                            id="cell_phone">   
                                        @error('cell_phone')
                                            <span class="error erro-feedback">{{ $message }}</span>
                                        @enderror                                 
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>WhatsApp:</b></label>
                                        <input type="text" class="form-control" placeholder="(00) 00000-0000"
                                            x-mask="(99) 99999-9999" wire:model="whatsapp"
                                            id="whatsapp">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>Email:</b></label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" 
                                            wire:model="email" id="email">
                                        @error('email')
                                            <span class="error erro-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>Email Adicional:</b></label>
                                        <input type="text" class="form-control" placeholder="Email Alternativo" 
                                            wire:model="additional_email" id="additional_email">
                                    </div>
                                </div>                            
                                <div class="col-12 col-md-6 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>Telegram:</b></label>
                                        <input type="text" class="form-control" placeholder="Telegram" 
                                            wire:model="telegram" id="telegram">
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-12 col-md-6 col-lg-2" x-ref="zipcode"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*CEP:</b></label>
                                        <input type="text" x-mask="99.999-999" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode" wire:model.lazy="zipcode">
                                        @error('zipcode')
                                            <span class="error erro-feedback">{{ $message }}</span>
                                        @enderror                                                    
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-4 col-lg-3"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Estado:</b></label>
                                        <input type="text" class="form-control" id="state" wire:model="state" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Cidade:</b></label>
                                        <input type="text" class="form-control" id="city" wire:model="city" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Rua:</b></label>
                                        <input type="text" class="form-control" id="street" wire:model="street" readonly>
                                    </div>
                                </div>                                            
                            </div>
                            <div class="row mb-2">
                                <div class="col-12 col-md-4 col-lg-3"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Bairro:</b></label>
                                        <input type="text" class="form-control" id="neighborhood" wire:model="neighborhood" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-2"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Número:</b></label>
                                        <input type="text" class="form-control" placeholder="Número do Endereço" id="number" wire:model="number">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3"> 
                                    <div class="form-group">
                                        <label class="labelforms"><b>Complemento:</b></label>
                                        <input type="text" class="form-control" id="complement" wire:model="complement"/>
                                    </div>
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
                <div class="row">                        
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">   
                        <div class="form-group text-muted">
                            <label class="labelforms"><b>Legenda da Imagem de Capa</b></label>
                            <input type="text" class="form-control"  wire:model="caption_img_cover">
                        </div>                                                    
                    </div>
                </div>

                <hr class="my-4 border-gray-300">

                <label class="block font-semibold mb-2 mt-2 text-muted">📁 Upload de Imagens:</label>
                <input type="file" wire:model="images" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple/>

                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Informação sobre ordenação -->
                @if(count($company->images ?? []) > 1)
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
                        @foreach ($company->images ?? [] as $savedImage)
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

        <!-- Conteúdo da aba SEO -->
        <div x-show="tab === 'seo'" x-transition>
            <div class="bg-white  text-muted">
                <div class="card-body text-muted">
                    <div class="row">
                        <div class="col-12 mb-1"> 
                            
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">                            
                            <div class="row">                                                       
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>URL:</b></label>
                                        <input type="text" class="form-control" placeholder="URL do site"
                                            id="url" wire:model="url">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>Facebook:</b></label>
                                        <input type="text" class="form-control" placeholder="Facebook"
                                            id="facebook" wire:model="facebook">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>Instagram:</b></label>
                                        <input type="text" class="form-control" placeholder="Instagram"
                                            id="instagram" wire:model="instagram">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>Linkedin:</b></label>
                                        <input type="text" class="form-control" placeholder="Linkedin"
                                            id="linkedin" wire:model="linkedin">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>Twitter(X):</b></label>
                                        <input type="text" class="form-control" placeholder="Twitter(X)"
                                            id="twitter" wire:model="twitter">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>TikTok:</b></label>
                                        <input type="text" class="form-control" placeholder="TikTok"
                                            id="tiktok" wire:model="tiktok">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 mb-4">   
                            <label class="labelforms"><b>Conteúdo</b></label>
                            <x-editor-quill 
                                :value="$this->content" 
                                model="content" 
                            />                                                                                     
                        </div>
                        <div class="col-12">   
                            <label class="labelforms"><b>Mapa do Google</b> <small class="text-info">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                            <textarea class="form-control" rows="5" wire:model="maps"></textarea>                                                      
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- LOGO --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Logomarca
                                    <span class="text-gray-400 font-normal text-xs">
                                        ({{ config('app.logomarca_width') }}x{{ config('app.logomarca_height') }})
                                    </span>
                                </label>

                                <div class="relative group w-full max-w-[260px]">
                                    <input 
                                        type="file"
                                        id="logo"
                                        wire:model="logo"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="hidden"
                                    >

                                    <label for="logo" class="cursor-pointer block">
                                        <div class="relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                            
                                            {{-- imagem --}}
                                            <img
                                                src="{{ $this->logoUrl }}"
                                                alt="{{ $alias_name }}"
                                                class="w-full h-[180px] object-contain p-3 transition group-hover:scale-105"
                                            >

                                            {{-- overlay --}}
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">
                                                    Alterar imagem
                                                </span>
                                            </div>

                                            {{-- loading --}}
                                            <div wire:loading wire:target="logo"
                                                class="absolute inset-0 bg-white/70 flex items-center justify-center">
                                                <span class="text-sm text-gray-600">Enviando...</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                @error('logo')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- META IMG --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    MetaImg
                                    <span class="text-gray-400 font-normal text-xs">
                                        ({{ config('app.metaimg_width') }}x{{ config('app.metaimg_height') }})
                                    </span>
                                </label>

                                <div class="relative group w-full max-w-[260px]">
                                    <input 
                                        type="file"
                                        id="metaimg"
                                        wire:model="metaimg"
                                        accept="image/png,image/jpeg,image/webp"
                                        class="hidden"
                                    >

                                    <label for="metaimg" class="cursor-pointer block">
                                        <div class="relative rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                            
                                            <img
                                                src="{{ $this->metaimgUrl }}"
                                                alt="{{ $alias_name }}"
                                                class="w-full h-[180px] object-contain p-3 transition group-hover:scale-105"
                                            >

                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">
                                                    Alterar imagem
                                                </span>
                                            </div>

                                            <div wire:loading wire:target="metaimg"
                                                class="absolute inset-0 bg-white/70 flex items-center justify-center">
                                                <span class="text-sm text-gray-600">Enviando...</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                @error('metaimg')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

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
                    wire:click="save('draft')" class="btn btn-info"><i class="nav-icon fas fa-check mr-2"></i>{{ $company->exists ? 'Atualizar Rascunho' : 'Salvar Rascunho' }}</button>
                <button 
                    wire:loading.attr="disabled"
                    wire:target="images"
                    type="button" 
                    wire:click="save('published')" 
                class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i>{{ $company->exists ? 'Atualizar e Publicar' : 'Salvar e Publicar' }}</button>
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
