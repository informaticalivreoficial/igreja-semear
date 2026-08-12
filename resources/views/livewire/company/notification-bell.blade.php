<div 
    x-data="{ open: @entangle('open'), lastCount: {{ $unreadCount }} }"
    x-effect="
        if ({{ $unreadCount }} > lastCount) {
            $refs.bellIcon.classList.add('animate-bounce');
            setTimeout(() => $refs.bellIcon.classList.remove('animate-bounce'), 1000);
        }
        lastCount = {{ $unreadCount }};
    "
    class="relative"
    wire:poll.15s.visible
>
    <button @click="open = !open" class="relative w-10 h-10 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors">
        <svg x-ref="bellIcon" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.outside="open = false" x-cloak
        class="absolute right-0 mt-2 w-80 bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden z-50">

        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <span class="font-bold text-sm text-slate-800">Notificações</span>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    Marcar todas como lidas
                </button>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto divide-y divide-slate-50">
            @forelse($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}"
                   wire:click="markAsRead('{{ $notification->id }}')"
                   class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors {{ $notification->read_at ? '' : 'bg-blue-50/40' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 bg-{{ $notification->data['color'] ?? 'slate' }}-50 text-{{ $notification->data['color'] ?? 'slate' }}-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $notification->data['title'] }}</p>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $notification->data['message'] }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <p class="text-sm text-slate-400 text-center py-8">Nenhuma notificação por aqui.</p>
            @endforelse
        </div>

        <a href="{{ route('company.notifications.index') }}" class="block text-center text-xs font-semibold text-blue-600 hover:text-blue-700 py-3 border-t border-slate-100">
            Ver todas
        </a>
    </div>
</div>