<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-user-friends"></i> Membros</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Membros</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <input type="text" wire:model.live.debounce.500ms="search" class="form-control form-control-sm w-52" placeholder="Pesquisar">
                <a href="{{ route('admin.users.create') }}" wire:navigate class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Cadastrar Novo</a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th wire:click="sortBy('name')" class="cursor-pointer">Nome <i class="fas fa-caret-down fa-fw ml-1"></i></th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="{{ $user->status ? '' : 'bg-amber-50/70' }}">
                                @php
                                    if (!empty($user->avatar) && \Illuminate\Support\Facades\Storage::exists($user->avatar)) {
                                        $cover = \Illuminate\Support\Facades\Storage::url($user->avatar);
                                    } else {
                                        if ($user->gender == 'masculino') {
                                            $cover = url(asset('backend/assets/images/avatar5.png'));
                                        } elseif ($user->gender == 'feminino') {
                                            $cover = url(asset('backend/assets/images/avatar3.png'));
                                        } else {
                                            $cover = url(asset('backend/assets/images/avatar3.png'));
                                        }
                                    }
                                @endphp
                                <td class="text-center">
                                    <img alt="{{ $user->name }}" class="table-avatar" src="{{ url($cover) }}">
                                </td>
                                <td class="font-medium text-slate-700">{{ $user->name }}</td>
                                <td class="whitespace-nowrap">{{ $user->cpf }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <x-forms.switch-toggle
                                        wire:key="safe-switch-{{ $user->id }}"
                                        wire:click="toggleStatus({{ $user->id }})"
                                        :checked="$user->status"
                                        size="sm"
                                        color="green"
                                    />
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if ($user->whatsapp)
                                            <a target="_blank"
                                                href="{{ \App\Helpers\WhatsApp::getNumZap($user->whatsapp) }}"
                                                class="btn btn-xs btn-success"><i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.users.view', $user->id) }}" wire:navigate
                                            title="Visualizar"
                                            class="btn btn-xs btn-info"><i class="fas fa-search"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" wire:navigate
                                            class="btn btn-xs btn-default"
                                            title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-xs btn-danger"
                                            title="Excluir Membro"
                                            wire:click="setDeleteId({{ $user->id }})">
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
                    {{ $users->links() }}
                </div>
            @else
                <div class="alert alert-info p-3">
                    Não foram encontrados registros!
                </div>
            @endif
        </div>
    </div>
</div>
