<div>
    @section('title', $title) 
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hiking mr-2"></i> Passeios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">                    
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Passeios</li>
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
                            <form class="input-group input-group-sm" action="" method="post">
                                <input type="text" wire:model.live="search" class="form-control float-right" placeholder="Pesquisar">               
                                
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="{{route('admin.companies.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>        
       
        <div class="card-body">
            @if(!empty($tours) && $tours->count() > 0)
                <div class="overflow-x-auto" x-data="{ showModal: false, imageUrl: '' }">
                    <table class="table table-bordered table-striped projects">
                        <thead>
                            <tr>
                                <th>Capa</th>
                                <th wire:click="sortBy('title')">Passeio <i class="expandable-table-caret fas fa-caret-down fa-fw"></i></th>
                                <th class="text-center">Operadora</th>
                                <th class="text-center">Embarcação</th>
                                <th class="text-center">Views</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tours as $tour)                    
                            <tr style="{{ ($tour->active == true ? '' : 'background: #fffed8 !important;')  }}">                            
                                <td>
                                    <img 
                                        src="{{ $tour->cover() }}" 
                                        alt="{{ $tour->title }}"
                                        class="w-12 mx-auto cursor-pointer rounded-lg hover:scale-105 transition-transform"
                                        @click="showModal = true; imageUrl = '{{ addslashes($tour->cover()) }}'"
                                    />
                                </td>
                                <td>{{$tour->title}}</td>
                                <td class="text-center">{{$tour->company->alias_name}}</td>
                                <td>{{$tour->vessel->name}}</td>
                                <td class="text-center">{{$tour->views ?? 0}}</td>
                                <td>  
                                    <div class="flex items-center justify-center gap-1">                              
                                        <x-forms.switch-toggle
                                            wire:key="safe-switch-{{ $tour->id }}"
                                            wire:click="toggleStatus({{ $tour->id }})"
                                            :checked="$tour->active"
                                            size="sm"
                                            color="green"
                                        />   
                                        <a 
                                            target="_blank" 
                                            href="{{route('web.site.tour', ['slug' => $tour->company->slug, 'uuid' => $tour->uuid])}}" 
                                            class="btn btn-xs bg-info" 
                                            title="Visualizar">
                                            <i class="fas fa-search"></i>
                                        </a>                                    
                                          
                                        </button>                                  
                                        <a href="{{route('admin.tours.edit',['tour' => $tour->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        @if (auth()->user()->isSuperAdmin())
                                            <button type="button" 
                                                    class="btn btn-xs bg-danger"
                                                    wire:click="setDeleteId({{ $tour->id }})"
                                                    title="Excluir"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                
                    </table>
                    <!-- Modal de imagem -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]"
                        x-transition>
                        <div class="relative">
                            <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                            <button type="button" @click="showModal = false"
                                    class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-2 py-1 hover:bg-opacity-75 transition">
                                ✕
                            </button>
                        </div>
                    </div>
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
        <div class="card-footer clearfix">  
            {{ $tours->links() }}  
        </div>
    </div>
</div>
