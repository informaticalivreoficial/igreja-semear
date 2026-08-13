<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-users mr-2"></i> Equipe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Equipe</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-teal card-outline">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <input type="text" wire:model.live.debounce.500ms="search" class="form-control float-right" placeholder="Pesquisar">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a wire:navigate href="{{ route('admin.users.create') }}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex align-items-stretch">
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                            <div class="card bg-light" style="{{ $user->status ? '' : 'background: #fffed8 !important;' }}">
                                <div class="card-header text-muted border-bottom-0">
                                    {{ $roleLabels[$user->roles->pluck('name')->first()] ?? 'Sem cargo' }}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                            <p class="text-muted text-sm">
                                                <b>Cadastrado em: </b><br>
                                                {{ $user->created_at->format('d/m/Y') }}
                                            </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small">
                                                    <i class="fas fa-envelope mr-1"></i> {{ $user->email }}
                                                </li>
                                            </ul>
                                        </div>
                                        @php
                                            if (!empty($user->avatar) && \Illuminate\Support\Facades\Storage::exists($user->avatar)) {
                                                $cover = \Illuminate\Support\Facades\Storage::url($user->avatar);
                                            } else {
                                                if ($user->gender == 'masculino') {
                                                    $cover = url(asset('theme/images/avatar5.png'));
                                                } elseif ($user->gender == 'feminino') {
                                                    $cover = url(asset('theme/images/avatar3.png'));
                                                } else {
                                                    $cover = url(asset('theme/images/image.jpg'));
                                                }
                                            }
                                        @endphp
                                        <div class="col-5 text-center">
                                            <img src="{{ $cover }}" alt="{{ $user->name }}" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="flex items-center gap-2">
                                        <x-forms.switch-toggle
                                            wire:key="safe-switch-{{ $user->id }}"
                                            wire:click="toggleStatus({{ $user->id }})"
                                            :checked="$user->status"
                                            size="sm"
                                            color="green"
                                        />
                                        @if ($user->whatsapp)
                                            <a target="_blank"
                                                href="{{ \App\Helpers\WhatsApp::getNumZap($user->whatsapp) }}"
                                                class="btn btn-xs bg-teal"><i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.users.view', $user->id) }}"
                                            title="Visualizar"
                                            class="btn btn-xs btn-info"><i class="fas fa-search"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-xs btn-default"
                                            title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-xs bg-danger text-white"
                                            title="Excluir Usuário"
                                            wire:click="setDeleteId({{ $user->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer paginacao">{{ $users->links() }}</div>
    </div>
</div>
