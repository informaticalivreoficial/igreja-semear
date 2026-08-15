<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-users"></i> Equipe</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Equipe</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="w-full sm:max-w-xs">
                <input type="text" wire:model.live.debounce.500ms="search" class="form-control" placeholder="Pesquisar">
            </div>
            <a wire:navigate href="{{ route('admin.users.create') }}" class="btn btn-default btn-sm"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @if ($users->count() > 0)
                    @foreach ($users as $user)
                        <div class="flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm {{ $user->status ? '' : 'bg-[#fffed8]' }}">
                            <div class="border-b border-slate-100 px-5 py-3 text-xs font-medium uppercase tracking-wide text-slate-500">
                                {{ $roleLabels[$user->roles->pluck('name')->first()] ?? 'Sem cargo' }}
                            </div>
                            <div class="flex gap-4 p-5">
                                <div class="min-w-0 flex-1">
                                    <h2 class="text-base font-bold text-slate-800"><b>{{ $user->name }}</b></h2>
                                    <p class="mt-2 text-xs text-slate-500">
                                        <b>Cadastrado em:</b><br>
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="mt-2 flex items-center gap-1.5 text-sm text-slate-500">
                                        <i class="fas fa-envelope"></i>
                                        <span class="truncate">{{ $user->email }}</span>
                                    </p>
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
                                            $cover = url(asset('theme/images/avatar3.png'));
                                        }
                                    }
                                @endphp
                                <div class="shrink-0">
                                    <img src="{{ $cover }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-forest-100">
                                </div>
                            </div>
                            <div class="mt-auto flex items-center gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-3">
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
                                        class="btn btn-xs bg-teal-600 text-white hover:bg-teal-700"><i class="fab fa-whatsapp"></i>
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
                                    class="btn btn-xs btn-danger text-white"
                                    title="Excluir Usuário"
                                    wire:click="setDeleteId({{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full">
                        <div class="alert alert-info">Não foram encontrados registros!</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer paginacao">{{ $users->links() }}</div>
    </div>
</div>
