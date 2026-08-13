<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-bullhorn"></i> Avisos</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Avisos</span>
        </nav>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <input type="text"
                    wire:model.live.debounce.500ms="search"
                    class="form-control form-control-sm w-64"
                    placeholder="Pesquisar aviso">

                <a wire:navigate href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Aviso
                </a>
            </div>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($announcements->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="text-center">Publicação</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($announcements as $announcement)
                            <tr>
                                <td>
                                    <span class="font-semibold">{{ $announcement->title }}</span>
                                    @if($announcement->creator)
                                        <br><span class="text-xs text-slate-400">por {{ $announcement->creator->name }}</span>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap">{{ $announcement->publish_at?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-center">
                                    @if($announcement->status)
                                        <span class="badge badge-success">Ativo</span>
                                    @else
                                        <span class="badge badge-secondary">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a title="Editar" href="{{ route('admin.announcements.edit', $announcement->id) }}" wire:navigate class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button wire:click="setDeleteId({{ $announcement->id }})" class="btn btn-xs btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $announcements->links() }}
            @else
                <div class="alert alert-info p-3">Nenhum aviso cadastrado.</div>
            @endif
        </div>
    </div>
</div>
