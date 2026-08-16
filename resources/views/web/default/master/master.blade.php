<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="author" content="{{ env('DESENVOLVEDOR') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! $head ?? '' !!}

        <title>@yield('title', optional($configuracoes)->app_name ?? 'Semear')</title>

        @if($configuracoes)
            <link rel="shortcut icon" href="{{ $configuracoes->getfaveicon() }}" type="image/x-icon">
            <link rel="apple-touch-icon" href="{{ $configuracoes->getfaveicon() }}">
            <meta name="url" content="{{ $configuracoes->domain }}">
            <meta name="keywords" content="{{ $configuracoes->metatags }}">
        @endif

        @vite(['resources/css/front.css', 'resources/js/front.js'])

        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

        @livewireStyles

        @yield('css')
        @stack('css')
    </head>

    <body class="flex min-h-screen flex-col">
        {{-- TOPBAR --}}
        @if($configuracoes)
            <div class="bg-brand-900 text-brand-100">
                <div class="container-site flex items-center justify-between gap-4 py-2 text-[11px]">
                    <div class="flex items-center gap-5">
                        @if($configuracoes->email)
                            <a href="mailto:{{ $configuracoes->email }}" class="flex items-center gap-1.5 transition hover:text-white">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $configuracoes->email }}
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        @foreach([
                            'facebook' => 'web.facebook',
                            'instagram' => 'web.instagram',
                            'youtube' => 'web.youtube',
                        ] as $field => $label)
                            @if($configuracoes->{$field})
                                <a href="{{ $configuracoes->{$field} }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }}" class="transition hover:text-white">
                                    @if($field === 'facebook')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    @elseif($field === 'instagram')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    @elseif($field === 'youtube')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- HEADER --}}
        <header
            x-data="{ mobileOpen: false }"
            class="sticky top-0 z-40 border-b border-brand-100 bg-white/95 backdrop-blur"
        >
            <div class="container-site flex h-16 items-center justify-between gap-6">
                <a href="{{ route('web.home') }}" class="flex shrink-0 items-center gap-3">
                    @if($configuracoes && $configuracoes->logo)
                        <img src="{{ $configuracoes->getlogo() }}" alt="{{ $configuracoes->app_name }}" class="h-10 w-auto">
                    @else
                        <span class="font-display text-xl font-bold text-brand-800">
                            {{ optional($configuracoes)->app_name ?: 'Semear' }}
                        </span>
                    @endif
                </a>

                <nav class="hidden items-center gap-1 lg:flex" x-data="{ menu: null }">
                    @php
                        $paginasNav = collect($viewPaginas ?? [])->keyBy('slug');
                        $slugAtivo = request()->routeIs('web.pagina') ? request()->route('slug') : null;
                        $igrejaAtiva = request()->routeIs('web.ministerios', 'web.pregacoes') || in_array($slugAtivo, ['cultos-e-horarios', 'galeria-de-fotos']);
                        $blogAtivo = request()->routeIs('web.blog.*', 'web.noticia*');
                        $maisAtiva = request()->routeIs('web.atendimento', 'web.pedido-oracao', 'web.doacoes', 'web.pregacoes') || in_array($slugAtivo, ['localizacao', 'doacoes']);
                    @endphp

                    <a href="{{ route('web.home') }}"
                        class="rounded-lg px-3.5 py-2 text-[13px] font-semibold transition {{ request()->routeIs('web.home') ? 'bg-brand-600/10 text-brand-700' : 'text-brand-700 hover:bg-brand-50 hover:text-brand-900' }}">
                        Início
                    </a>

                    <a href="{{ route('web.pagina', ['slug' => 'sobre-a-igreja']) }}"
                        class="rounded-lg px-3.5 py-2 text-[13px] font-semibold transition {{ $slugAtivo === 'sobre-a-igreja' ? 'bg-brand-600/10 text-brand-700' : 'text-brand-700 hover:bg-brand-50 hover:text-brand-900' }}">
                        {{ $paginasNav['sobre-a-igreja']->title ?? 'Sobre' }}
                    </a>

                    {{-- A IGREJA --}}
                    {{-- A IGREJA --}}
                    <div class="relative" @mouseenter="menu = 'igreja'" @mouseleave="menu = null">
                        <button class="flex items-center gap-1 rounded-lg px-3.5 py-2 text-[13px] font-semibold transition {{ $igrejaAtiva ? 'bg-brand-600/10 text-brand-700' : 'text-brand-700 hover:bg-brand-50 hover:text-brand-900' }}">
                            A Igreja
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="menu === 'igreja'" x-cloak x-transition class="absolute left-0 top-full z-40 pt-2">
                            <div class="w-60 rounded-2xl border border-brand-100 bg-white p-2 shadow-xl">
                                <a href="{{ route('web.ministerios') }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Ministérios</a>
                                <a href="{{ route('web.pagina', ['slug' => 'cultos-e-horarios']) }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Cultos e horários</a>
                            </div>
                        </div>
                    </div>

                    {{-- CULTOS ONLINE --}}
                    <a href="{{ route('web.cultos') }}"
                        class="rounded-lg px-3.5 py-2 text-[13px] font-semibold transition {{ request()->routeIs('web.cultos', 'web.transmissao') ? 'bg-brand-600/10 text-brand-700' : 'text-brand-700 hover:bg-brand-50 hover:text-brand-900' }}">
                        Cultos Online
                    </a>

                    {{-- MAIS --}}
                    <div class="relative" @mouseenter="menu = 'mais'" @mouseleave="menu = null">
                        <button class="flex items-center gap-1 rounded-lg px-3.5 py-2 text-[13px] font-semibold transition {{ $maisAtiva ? 'bg-brand-600/10 text-brand-700' : 'text-brand-700 hover:bg-brand-50 hover:text-brand-900' }}">
                            Mais
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="menu === 'mais'" x-cloak x-transition class="absolute left-0 top-full z-40 pt-2">
                            <div class="w-60 rounded-2xl border border-brand-100 bg-white p-2 shadow-xl">
                                <a href="{{ route('web.atendimento') }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Contato</a>
                                <a href="{{ route('web.pagina', ['slug' => 'localizacao']) }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Localização</a>
                                <a href="{{ route('web.pedido-oracao') }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Pedido de oração</a>
                                <a href="{{ route('web.doacoes') }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Doações</a>
                                <a href="{{ route('web.pregacoes') }}" class="block rounded-lg px-3 py-2 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50 hover:text-brand-900">Pregações</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="flex items-center gap-3">
                    <div class="hidden w-64 xl:block">
                        <livewire:web.site-search />
                    </div>

                    <a href="{{ route('web.doacoes') }}" class="btn-secondary btn-sm hidden md:inline-flex">
                        Doações
                    </a>

                    <a href="{{ route('web.atendimento') }}" class="btn-primary btn-sm hidden md:inline-flex">
                        Atendimento
                    </a>

                    @auth
                        @if(auth()->user()->member)
                            <a href="{{ route('member.dashboard') }}" class="hidden items-center gap-2 rounded-lg border border-brand-200 px-4 py-2 text-[13px] font-semibold text-brand-700 transition hover:border-brand-300 hover:text-brand-700 md:inline-flex">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Minha conta
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="hidden items-center gap-2 rounded-lg border border-brand-200 px-4 py-2 text-[13px] font-semibold text-brand-700 transition hover:border-brand-300 hover:text-brand-700 md:inline-flex">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 7v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Entrar
                        </a>
                    @endauth

                    <button
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-brand-200 text-brand-700 transition hover:bg-brand-50 lg:hidden"
                        @click="mobileOpen = true"
                        aria-label="Abrir menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                </div>
            </div>

            {{-- DRAWER MOBILE --}}
            <template x-teleport="body">
                <div x-show="mobileOpen" x-cloak x-transition.opacity class="fixed inset-0 z-50 bg-brand-900/50" @click="mobileOpen = false"></div>
                <div x-show="mobileOpen" x-cloak x-transition class="fixed inset-y-0 right-0 z-50 flex w-80 max-w-[85vw] flex-col overflow-y-auto bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-brand-100 px-5 py-4">
                        <span class="font-display text-lg font-bold text-brand-800">{{ optional($configuracoes)->app_name ?: 'Semear' }}</span>
                        <button class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-brand-500 hover:bg-brand-50" @click="mobileOpen = false" aria-label="Fechar menu">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="px-5 py-4">
                        <livewire:web.site-search />
                    </div>

                    <nav class="flex flex-col px-3 py-2" x-data="{ sub: null }">
                        <a href="{{ route('web.home') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">Início</a>
                        <a href="{{ route('web.pagina', ['slug' => 'sobre-a-igreja']) }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">{{ $paginasNav['sobre-a-igreja']->title ?? 'Sobre' }}</a>

                        <button @click="sub = sub === 'igreja' ? null : 'igreja'" class="flex items-center justify-between rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">
                            A Igreja
                            <svg class="h-4 w-4 transition" :class="sub === 'igreja' ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="sub === 'igreja'" x-cloak class="flex flex-col border-l-2 border-brand-100 pl-3">
                            <a href="{{ route('web.ministerios') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Ministérios</a>
                            <a href="{{ route('web.pagina', ['slug' => 'cultos-e-horarios']) }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Cultos e horários</a>
                            <a href="{{ route('web.pregacoes') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Pregações</a>
                            <a href="{{ route('web.pagina', ['slug' => 'galeria-de-fotos']) }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Galeria de fotos</a>
                        </div>

                        <button @click="sub = sub === 'blog' ? null : 'blog'" class="flex items-center justify-between rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">
                            Blog
                            <svg class="h-4 w-4 transition" :class="sub === 'blog' ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="sub === 'blog'" x-cloak class="flex flex-col border-l-2 border-brand-100 pl-3">
                            <a href="{{ route('web.blog.artigos') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Artigos e devocionais</a>
                            <a href="{{ route('web.noticias') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Notícias</a>
                        </div>

                        <a href="{{ route('web.eventos') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">Eventos</a>

                        <a href="{{ route('web.cultos') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">Cultos Online</a>

                        <button @click="sub = sub === 'mais' ? null : 'mais'" class="flex items-center justify-between rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">
                            Mais
                            <svg class="h-4 w-4 transition" :class="sub === 'mais' ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="sub === 'mais'" x-cloak class="flex flex-col border-l-2 border-brand-100 pl-3">
                            <a href="{{ route('web.atendimento') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Contato</a>
                            <a href="{{ route('web.pagina', ['slug' => 'localizacao']) }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Localização</a>
                            <a href="{{ route('web.pedido-oracao') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Pedido de oração</a>
                            <a href="{{ route('web.doacoes') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2 text-[13px] font-medium text-brand-600 transition hover:bg-brand-50">Doações</a>
                        </div>

                        <a href="{{ route('web.politica') }}" @click="mobileOpen = false" class="rounded-lg px-3 py-2.5 text-[13px] font-semibold text-brand-700 transition hover:bg-brand-50">Política de Privacidade</a>
                    </nav>
                </div>
            </template>
        </header>

        {{-- CONTEÚDO --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-brand-900 text-brand-100">
            <div class="container-site grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <a href="{{ route('web.home') }}" class="flex shrink-0 items-center gap-3">
                        @if($configuracoes && $configuracoes->watermark)
                            <img src="{{ $configuracoes->getwatermark() }}" alt="{{ $configuracoes->app_name }}" class="h-12 w-auto">
                        @else
                            <span class="font-display text-xl font-bold text-brand-100">
                                {{ optional($configuracoes)->app_name ?: 'Semear' }}
                            </span>
                        @endif
                    </a>
                    <p class="mt-4 text-sm leading-6 text-brand-300/80">
                        {{ optional($configuracoes)->information ?: 'Comunidade Cristã Semear.' }}
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white">Navegação</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('web.home') }}" class="transition hover:text-white">Início</a></li>
                        <li><a href="{{ route('web.pagina', ['slug' => 'sobre-a-igreja']) }}" class="transition hover:text-white">Sobre a igreja</a></li>
                        <li><a href="{{ route('web.blog.artigos') }}" class="transition hover:text-white">Blog</a></li>
                        <li><a href="{{ route('web.noticias') }}" class="transition hover:text-white">Notícias</a></li>
                        <li><a href="{{ route('web.eventos') }}" class="transition hover:text-white">Eventos</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white">A Igreja</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('web.ministerios') }}" class="transition hover:text-white">Ministérios</a></li>
                        <li><a href="{{ route('web.pagina', ['slug' => 'cultos-e-horarios']) }}" class="transition hover:text-white">Cultos e horários</a></li>
                        <li><a href="{{ route('web.cultos') }}" class="transition hover:text-white">Cultos Online</a></li>
                    </ul>
                </div>

                @if($configuracoes)
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-white">Contato</h4>
                        <ul class="mt-4 space-y-3 text-sm text-brand-300/80">
                            @if($configuracoes->street || $configuracoes->city)
                                <li class="flex gap-2">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ trim(implode(', ', array_filter([$configuracoes->street, $configuracoes->number, $configuracoes->neighborhood, $configuracoes->city, $configuracoes->state]))) }}</span>
                                </li>
                            @endif
                            @if($configuracoes->phone || $configuracoes->cell_phone)
                                <li class="flex gap-2">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $configuracoes->cell_phone ?: $configuracoes->phone }}</span>
                                </li>
                            @endif
                            @if($configuracoes->email)
                                <li class="flex gap-2">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span>{{ $configuracoes->email }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>

            <div class="border-t border-brand-100">
                <div class="container-site flex flex-col items-center justify-between gap-3 py-5 text-xs text-brand-300/70 sm:flex-row">
                    <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2">
                        <a href="{{ route('web.doacoes') }}" class="transition hover:text-white">Doações</a>
                        <a href="{{ route('web.pedido-oracao') }}" class="transition hover:text-white">Pedido de oração</a>
                        <a href="{{ route('web.pagina', ['slug' => 'localizacao']) }}" class="transition hover:text-white">Localização</a>
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-cookie-modal'))" class="cursor-pointer transition hover:text-white">Configurar cookies</button>
                        <a href="{{ route('web.politica') }}" class="transition hover:text-white">Política de Privacidade</a>
                    </div>
                    <span>&copy; {{ date('Y') }} {{ optional($configuracoes)->app_name ?: 'Semear' }}. Todos os direitos reservados.</span>
                </div>
            </div>
        </footer>

        {{-- COOKIE CONSENT --}}
        <div x-data="cookieConsent" x-cloak>
            <div x-show="!accepted" class="fixed inset-x-0 bottom-0 z-50 p-4">
                <div class="mx-auto max-w-3xl rounded-2xl border border-brand-100 bg-brand-900 p-5 shadow-lg">
                    <p class="text-sm text-brand-600">
                        {{ optional($configuracoes)->cookies_preference ?: 'Este site utiliza cookies para melhorar a sua experiência de navegação.' }}
                        <a href="{{ route('web.politica') }}" class="font-semibold text-brand-600 hover:text-brand-700">Saiba mais</a>.
                    </p>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <label class="flex items-center gap-2 text-xs text-brand-500">
                            <input type="checkbox" x-model="stats" class="h-4 w-4 rounded border-brand-300 text-brand-400 focus:ring-brand-500">
                            Cookies de estatística
                        </label>
                        <label class="flex items-center gap-2 text-xs text-brand-500">
                            <input type="checkbox" x-model="marketing" class="h-4 w-4 rounded border-brand-300 text-brand-400 focus:ring-brand-500">
                            Cookies de marketing
                        </label>
                        <div class="flex items-center gap-2">
                            <button @click="acceptAll" class="btn-primary btn-sm">Aceitar todos</button>
                            <button @click="save" class="btn-secondary btn-sm">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COOKIE SETTINGS MODAL --}}
            <div x-show="open" x-cloak x-transition.opacity
                class="fixed inset-0 z-[70] flex items-center justify-center bg-brand-900/60 p-4"
                @click.self="closeModal()">
                <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
                    <div class="flex items-center justify-between border-b border-brand-100 px-6 py-4">
                        <h3 class="font-display text-lg font-bold text-brand-900">Preferências de cookies</h3>
                        <button type="button" @click="closeModal()" class="text-slate-400 transition hover:text-slate-600" aria-label="Fechar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-sm leading-6 text-slate-600">
                            Gerencie suas preferências de cookies. Os cookies necessários são essenciais para o funcionamento do site e permanecem sempre ativos.
                        </p>
                        <div class="mt-5 space-y-3">
                            <div class="flex items-center justify-between rounded-xl border border-brand-100 bg-brand-50/50 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-brand-900">Cookies necessários</p>
                                    <p class="text-xs text-slate-500">Essenciais para o funcionamento do site.</p>
                                </div>
                                <span class="badge-cat">Sempre ativos</span>
                            </div>
                            <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-brand-100 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-brand-900">Cookies de estatística</p>
                                    <p class="text-xs text-slate-500">Nos ajudam a entender como o site é utilizado.</p>
                                </div>
                                <input type="checkbox" x-model="stats" class="h-5 w-5 shrink-0 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                            </label>
                            <label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-brand-100 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-brand-900">Cookies de marketing</p>
                                    <p class="text-xs text-slate-500">Usados para exibir conteúdo e anúncios relevantes.</p>
                                </div>
                                <input type="checkbox" x-model="marketing" class="h-5 w-5 shrink-0 rounded border-brand-300 text-brand-600 focus:ring-brand-500">
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-2 border-t border-brand-100 px-6 py-4 sm:flex-row sm:justify-end">
                        <button @click="save" class="btn-secondary">Salvar preferências</button>
                        <button @click="acceptAll" class="btn-primary">Aceitar todos</button>
                    </div>
                </div>
            </div>
        </div>

        @livewireScripts

        @if (session('toast'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const toast = @js(session('toast'));

                    if (window.showToast) {
                        window.showToast(toast.type, toast.message);
                    }
                });
            </script>
        @endif

        @yield('js')
        @stack('js')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLNNT4LW4"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-PWLNNT4LW4');
        </script>
    </body>
</html>
