<div wire:poll.30s="refreshNotifications">
    <div class="content-header">
        <h1><i class="fas fa-bell"></i> Notificações</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Notificações</span>
        </nav>
    </div>

    <div class="card">
        <div class="card-header flex items-center justify-end">
            @if (auth()->user()->unreadNotifications->count() > 0)
                <button
                    wire:click="markAllAsRead"
                    class="btn btn-sm btn-outline-success"
                    title="Marcar todas como lidas"
                >
                    <i class="fas fa-check-double"></i>
                </button>
            @endif
        </div>

        <div class="card-body p-0">
            @forelse ($notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'default';

                    $icon = match ($type) {
                        'invoice_paid'         => 'fas fa-money-bill-wave',
                        'withdrawal_requested' => 'fas fa-hand-holding-usd',
                        'new_company'          => 'fas fa-building',
                        'reservation_created'  => 'fas fa-calendar-check',
                        'support_ticket'       => 'fas fa-life-ring',
                        'subscription'         => 'fas fa-credit-card',
                        'ArticleCreated'       => 'fas fa-file-alt',
                        'new_member'           => 'fas fa-user-plus',
                        'new_prayer_request'   => 'fas fa-praying-hands',
                        'new_atendimento'      => 'fas fa-envelope',
                        'new_event_registration' => 'fas fa-calendar-check',
                        default                => 'fas fa-bell',
                    };

                    $color = match ($notification->data['color'] ?? '') {
                        'success' => 'success',
                        'danger'  => 'danger',
                        'warning' => 'warning',
                        'info'    => 'info',
                        default   => 'secondary',
                    };
                @endphp

                <div class="flex items-start gap-3 border-b border-slate-100 p-4 {{ is_null($notification->read_at) ? 'bg-slate-50' : 'bg-white' }}">
                    <span class="badge badge-{{ $color }} p-3">
                        <i class="{{ $icon }}"></i>
                    </span>

                    <div class="min-w-0 flex-1">
                        <h6 class="mb-1 font-bold text-slate-800">
                            {{ $notification->data['title'] ?? 'Nova notificação' }}
                        </h6>
                        <p class="mb-1 text-sm text-slate-500">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        @if (!empty($notification->data['description']))
                            <small class="block text-slate-500">{{ $notification->data['description'] }}</small>
                        @endif
                        <small class="text-slate-400">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="flex shrink-0 flex-col gap-2">
                        @if (!empty($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                        @if (is_null($notification->read_at))
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <div class="mb-3">
                        <i class="far fa-bell-slash fa-4x text-slate-300"></i>
                    </div>
                    <h5 class="text-slate-400">Nenhuma notificação encontrada</h5>
                    <p class="mb-0 text-slate-400">Quando houver novas notificações elas aparecerão aqui.</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="card-footer paginacao">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
