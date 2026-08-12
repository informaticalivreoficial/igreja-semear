<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Notificações</h1>
            <p class="text-sm text-slate-500 mt-1">
                @if($unreadCount > 0)
                    Você tem {{ $unreadCount }} {{ $unreadCount === 1 ? 'notificação não lida' : 'notificações não lidas' }}
                @else
                    Tudo em dia por aqui
                @endif
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button
                wire:click="setFilter('all')"
                class="h-11 px-4 inline-flex items-center rounded-2xl text-sm font-bold transition {{ $filter === 'all'
                    ? 'bg-slate-900 text-white'
                    : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'
                }}"
            >
                Todas
            </button>

            <button
                wire:click="setFilter('unread')"
                class="h-11 px-4 inline-flex items-center rounded-2xl text-sm font-bold transition {{ $filter === 'unread'
                    ? 'bg-slate-900 text-white'
                    : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50'
                }}"
            >
                Não lidas
            </button>

            @if($unreadCount > 0)
                <button
                    wire:click="markAllAsRead"
                    class="h-11 px-5 inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 text-white text-sm font-bold shadow-sm hover:bg-emerald-400 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Marcar todas como lidas
                </button>
            @endif
        </div>

    </div>

    {{-- EMPTY --}}
    @if ($notifications->isEmpty())

        <div class="bg-white border border-dashed border-slate-300 rounded-3xl py-20 px-6 flex flex-col items-center justify-center text-center">

            <div class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center mb-5 text-2xl">
                🔔
            </div>

            <h3 class="text-lg font-bold text-slate-900 mb-2">
                {{ $filter === 'unread' ? 'Nenhuma notificação não lida' : 'Nenhuma notificação por aqui' }}
            </h3>

            <p class="text-sm text-slate-500">
                Assim que algo acontecer na sua operação, você verá por aqui.
            </p>

        </div>

    @else

        {{-- LIST --}}
        <div class="flex flex-col gap-3">

            @foreach ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $badge = match ($data['color'] ?? null) {
                        'blue' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-700', 'border' => 'border-cyan-200', 'dot' => 'bg-cyan-500'],
                        'green' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                        'amber' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'dot' => 'bg-yellow-500'],
                        default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'],
                    };
                    $emoji = match ($data['icon'] ?? null) {
                        'calendar-plus' => '📅',
                        'check-circle' => '✅',
                        'x-circle' => '❌',
                        'wallet' => '💰',
                        default => '🔔',
                    };
                @endphp

                
                <a    href="{{ $data['url'] ?? '#' }}"
                    wire:click="markAsRead('{{ $notification->id }}')"
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition p-5 flex items-start gap-4 {{ $notification->read_at ? '' : 'ring-2 ring-cyan-100' }}"
                >

                    <div class="w-12 h-12 rounded-2xl {{ $badge['bg'] }} flex items-center justify-center text-xl shrink-0">
                        {{ $emoji }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-3 mb-1">
                            <h3 class="text-sm font-bold text-slate-900 leading-tight">
                                {{ $data['title'] ?? 'Notificação' }}
                            </h3>

                            @if (!$notification->read_at)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold {{ $badge['bg'] }} {{ $badge['text'] }} border {{ $badge['border'] }} shrink-0">
                                    <span class="w-2 h-2 rounded-full {{ $badge['dot'] }}"></span>
                                    Nova
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-slate-500">
                            {{ $data['message'] ?? '' }}
                        </p>

                        <p class="text-xs text-slate-400 mt-2">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>

                    </div>

                </a>

            @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>

    @endif

</div>