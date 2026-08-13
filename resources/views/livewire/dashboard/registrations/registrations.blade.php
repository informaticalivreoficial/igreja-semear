<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-calendar-check"></i> Inscrições em eventos</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Inscrições</span>
        </nav>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <select wire:model.live="statusFilter" class="form-control form-control-sm w-44">
                <option value="">Todos os status</option>
                <option value="pendente">Pendente</option>
                <option value="confirmada">Confirmada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($registrations->count())
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Membro</th>
                                <th class="text-center">Data inscrição</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrations as $registration)
                            <tr>
                                <td>
                                    <span class="font-semibold">{{ $registration->event?->title ?? '—' }}</span>
                                    @if($registration->event?->start_at)
                                        <br><span class="text-xs text-slate-400">{{ $registration->event->start_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                </td>
                                <td>{{ $registration->member?->name ?? '—' }}</td>
                                <td class="text-center whitespace-nowrap">{{ $registration->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $badge = match ($registration->status) {
                                            'confirmada' => 'badge-success',
                                            'cancelada' => 'badge-danger',
                                            default => 'badge-warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($registration->status) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($registration->status !== 'confirmada')
                                            <button wire:click="setStatus({{ $registration->id }}, 'confirmada')" class="btn btn-xs btn-success" title="Confirmar"><i class="fas fa-check"></i></button>
                                        @endif
                                        @if($registration->status !== 'cancelada')
                                            <button wire:click="setStatus({{ $registration->id }}, 'cancelada')" class="btn btn-xs btn-warning" title="Cancelar"><i class="fas fa-times"></i></button>
                                        @endif
                                        <button wire:click="setDeleteId({{ $registration->id }})" class="btn btn-xs btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $registrations->links() }}
            @else
                <div class="alert alert-info p-3">Nenhuma inscrição encontrada.</div>
            @endif
        </div>
    </div>
</div>
