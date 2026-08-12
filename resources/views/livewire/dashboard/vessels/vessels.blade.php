<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Embarcações</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Embarcações</li>
                    </ol>
                </div>
            </div>
        </div>    
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="{{route('admin.vessels.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>

        <div class="card-body"> 
            @if ($vessels->count())
                <div class="row d-flex align-items-stretch" x-data="{ showModal: false, imageUrl: '' }">
                    @foreach($vessels as $vessel)  
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                            <div class="card card-widget widget-user" style="{{ ($vessel->active == true ? '' : 'background: #fffed8 !important;')  }}">
                                <div class="cursor-pointer" @click="showModal = true; imageUrl = '{{ url($vessel->nocover()) }}'">
                                    <div class="rounded-t h-[175px] p-4 text-center text-white" 
                                        style="background: url('{{url($vessel->cover())}}') center center;background-size: cover;">
                                        <h3 class="widget-user-username text-right">{{$vessel->name}}</h3>
                                        <h5 class="widget-user-desc text-right">Tipo: {{$vessel->type}}</h5>
                                    </div>       
                                </div>        
                                <div class="py-3 px-3">
                                    <div class="row">
                                        <div class="col-12 text-center mb-2">
                                            Empresa: {{ $vessel->company->alias_name }}
                                        </div>
                                        <div class="col-12 text-center mb-2">                                            
                                            <div x-data="{ open: false }" class="flex items-center gap-2">
                                                <x-forms.switch-toggle
                                                    wire:key="safe-switch-{{ $vessel->id }}"
                                                    wire:click="toggleStatus({{ $vessel->id }})"
                                                    :checked="$vessel->active"
                                                    size="sm"
                                                    color="green"
                                                />                             

                                                
                                                @if ($vessel->slug)
                                                    <a target="_blank" title="Visualizar Embarcação" class="btn btn-xs btn-info text-white" href="{{ route('web.vessel', ['slug' => $vessel->slug]) }}" title="{{$vessel->name}}"><i class="fas fa-search"></i></a>
                                                @endif                            
                                                <a title="Editar Embarcação" href="{{ route('admin.vessels.edit', ['id' => $vessel->id]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                                <button type="button" 
                                                    class="btn btn-xs bg-danger text-white" 
                                                    title="Excluir Embarcação"
                                                    wire:click="setDeleteId({{ $vessel->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>                                            
                                        </div>

                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{$vessel->size}}</h5>
                                                <span>Tamanho</span>
                                            </div>                    
                                        </div>
                                        
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header">{{--  --}}</h5>
                                                <span>Views</span>
                                            </div>                    
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">{{$vessel->images()->count()}}</h5>
                                                <span>Imagens</span>
                                            </div>                    
                                        </div>
                                    
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    @endforeach  
                    
                    <!-- Modal de imagem -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]"
                        x-transition>
                        <div class="relative">
                            <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                            <button type="button" @click="showModal = false"
                                    class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-2 py-1">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>

                @if($vessels->hasMorePages())
                    <div class="text-center mt-4">
                        <!-- Botão só aparece quando NÃO está carregando -->
                        <button 
                            wire:click="loadMore" 
                            wire:loading.remove
                            wire:target="loadMore"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Carregar mais
                        </button>

                        <!-- Spinner enquanto carrega -->
                        <div wire:loading wire:target="loadMore" class="flex justify-center items-center mt-2">
                            <svg class="animate-spin h-6 w-6 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Carregando...
                        </div>
                    </div>
                @endif
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