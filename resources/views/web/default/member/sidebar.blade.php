@php
    $links = [
        'dashboard' => [route('member.dashboard'), 'Visão geral', 'M3 10.5 12 3l9 7.5M5 10.5V21h14v-10.5'],
        'perfil' => [route('member.perfil'), 'Meu perfil', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        'agenda' => [route('member.agenda'), 'Agenda', 'M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        'inscricoes' => [route('member.inscricoes'), 'Minhas inscrições', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
        'historico' => [route('member.historico'), 'Histórico', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        'oracoes' => [route('member.oracoes'), 'Pedidos de oração', 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'],
        'avisos' => [route('member.avisos'), 'Avisos', 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
    ];
@endphp

<aside x-data="{ open: false }" class="shrink-0 lg:w-64">
    <div class="flex items-center gap-3 rounded-2xl border border-brand-100 bg-white p-4 shadow-sm">
        @if($member->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->avatar))
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->avatar) }}" alt="{{ $member->name }}" class="h-12 w-12 rounded-full object-cover ring-2 ring-brand-200">
        @else
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-lg font-bold text-white">
                {{ strtoupper(substr($member->name, 0, 1)) }}
            </div>
        @endif
        <div class="min-w-0 flex-1">
            <p class="truncate font-display font-bold text-brand-900">{{ $member->name }}</p>
            <p class="text-xs text-slate-500">{{ $member->family?->name ?? 'Sem família' }} · {{ $member->family_role_label }}</p>
        </div>

        <button type="button" @click="open = !open" aria-label="Abrir menu" aria-expanded="open"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-brand-700 transition hover:bg-brand-50 lg:hidden">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div :class="open ? 'block menu-drop-anim' : 'hidden lg:block'">
        <nav class="mt-5 space-y-1">
            @foreach($links as $key => [$url, $label, $icon])
                <a href="{{ $url }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ $active === $key ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-5">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Sair
            </button>
        </form>
    </div>
</aside>
