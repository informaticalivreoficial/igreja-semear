@extends("web.{$configuracoes->template}.master.master")

@section('content')
    {{-- HERO SLIDER --}}
    @if(isset($slides) && $slides->count())
        <section
            x-data="{ active: 0, total: {{ $slides->count() }}, timer: null, start() { this.timer = setInterval(() => { this.active = (this.active + 1) % this.total }, 6000) }, stop() { clearInterval(this.timer) } }"
            x-init="start()"
            class="relative h-[480px] overflow-hidden bg-sky-900 sm:h-[560px]"
            @mouseenter="stop()"
            @mouseleave="start()"
        >
            @foreach($slides as $i => $slide)
                <div
                    x-show="active === {{ $i }}"
                    x-transition.opacity.duration.700ms
                    class="absolute inset-0"
                >
                    @if($slide->imagem)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($slide->imagem) }}"
                            alt="{{ $slide->titulo }}"
                            class="h-full w-full object-cover opacity-50"
                        >
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-sky-900 via-sky-800 to-sky-700"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-sky-950/90 via-sky-900/40 to-transparent"></div>
                </div>
            @endforeach

            <div class="container-site relative flex h-full items-center">
                <div class="max-w-2xl text-white">
                    @foreach($slides as $i => $slide)
                        <div x-show="active === {{ $i }}" x-transition:enter.delay.200ms>
                            <span class="badge-cat !bg-white/10 !text-amber-300">Bem-vindo à {{ optional($configuracoes)->app_name ?: 'Comunidade Cristã Semear' }}</span>
                            <h1 class="font-display mt-4 text-4xl font-bold leading-tight sm:text-5xl">{{ $slide->titulo }}</h1>
                            @if($slide->subtitulo)
                                <p class="mt-4 text-lg text-sky-100/90">{{ $slide->subtitulo }}</p>
                            @endif
                            @if($slide->botaolabel && $slide->link)
                                <a href="{{ $slide->link }}" target="{{ $slide->target ?: '_self' }}" class="btn-secondary mt-6">
                                    {{ $slide->botaolabel }}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if($slides->count() > 1)
                <div class="container-site absolute bottom-6 left-1/2 flex -translate-x-1/2 items-center gap-2">
                    @foreach($slides as $i => $slide)
                        <button
                            @click="active = {{ $i }}"
                            class="h-2.5 rounded-full transition-all {{-- active via class toggling --}}"
                            :class="active === {{ $i }} ? 'w-8 bg-amber-400' : 'w-2.5 bg-white/50 hover:bg-white'"
                            aria-label="Slide {{ $i + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    {{-- BOAS-VINDAS --}}
    <section class="bg-white py-20">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2">
            <div>
                <span class="badge-cat">Nossa Comunidade</span>
                <h2 class="section-title mt-4">Um lugar para crescer, servir e adorar</h2>
                <p class="mt-5 leading-7 text-slate-600">
                    {{ optional($configuracoes)->information ?: 'A Comunidade Cristã Semear é um lugar de acolhimento, fé e comunhão. Venha fazer parte da nossa família!' }}
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('web.blog.artigos') }}" class="btn-primary">Conheça o Blog</a>
                    <a href="{{ route('web.atendimento') }}" class="btn-secondary">Fale Conosco</a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                    <svg class="h-8 w-8 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.716-3.89-9.428-6.623C.336 11.61-.342 7.512 2.172 4.997a5.247 5.247 0 017.42 0L12 7.404l2.407-2.407a5.247 5.247 0 017.42 0c2.515 2.515 1.836 6.613-.399 9.38C18.716 17.11 12 21 12 21z"/></svg>
                    <h3 class="mt-4 font-display text-lg font-bold text-slate-900">Família</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Comunhão e acolhimento para todas as idades.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                    <svg class="h-8 w-8 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <h3 class="mt-4 font-display text-lg font-bold text-slate-900">Adoração</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Cultos de celebração e comunhão com Deus.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                    <svg class="h-8 w-8 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <h3 class="mt-4 font-display text-lg font-bold text-slate-900">Palavra</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Ensino bíblico sólido e devocionais diários.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                    <svg class="h-8 w-8 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <h3 class="mt-4 font-display text-lg font-bold text-slate-900">Serviço</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Ministérios e projetos que transformam vidas.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ÚLTIMOS ARTIGOS --}}
    @if(isset($artigos) && $artigos->count())
        <section class="bg-slate-50 py-20">
            <div class="container-site">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="badge-cat">Do nosso Blog</span>
                        <h2 class="section-title mt-4">Últimos artigos</h2>
                    </div>
                    <a href="{{ route('web.blog.artigos') }}" class="btn-primary">Ver todos &rarr;</a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach($artigos as $post)
                        <a href="{{ route('web.blog.artigo', ['slug' => $post->slug]) }}" class="card-post group">
                            <div class="aspect-[16/9] overflow-hidden">
                                <img src="{{ $post->cover() }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex items-center gap-2">
                                    @if($post->categoriaObject)
                                        <span class="badge-cat">{{ $post->categoriaObject->title }}</span>
                                    @endif
                                    @if($post->publish_at)
                                        <span class="text-xs text-slate-400">{{ $post->publish_at->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="font-display mt-3 text-lg font-bold leading-snug text-slate-900 transition group-hover:text-sky-700">{{ $post->title }}</h3>
                                @if($post->excerpt)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- NOTÍCIAS --}}
    @if(isset($noticias) && $noticias->count())
        <section class="bg-white py-20">
            <div class="container-site">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="badge-cat-amber">Fique por dentro</span>
                        <h2 class="section-title mt-4">Notícias</h2>
                    </div>
                    <a href="{{ route('web.noticias') }}" class="btn-secondary">Todas as notícias &rarr;</a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach($noticias as $post)
                        <a href="{{ route('web.noticia', ['slug' => $post->slug]) }}" class="card-post group">
                            <div class="aspect-[16/9] overflow-hidden">
                                <img src="{{ $post->cover() }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex items-center gap-2">
                                    @if($post->categoriaObject)
                                        <span class="badge-cat-amber">{{ $post->categoriaObject->title }}</span>
                                    @endif
                                    @if($post->publish_at)
                                        <span class="text-xs text-slate-400">{{ $post->publish_at->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="font-display mt-3 text-lg font-bold leading-snug text-slate-900 transition group-hover:text-sky-700">{{ $post->title }}</h3>
                                @if($post->excerpt)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- EVENTOS --}}
    @if(isset($eventos) && $eventos->count())
        <section class="page-hero py-20">
            <div class="container-site">
                <span class="badge-cat !bg-white/10 !text-amber-300">Agenda</span>
                <h2 class="font-display mt-4 text-3xl font-bold text-white sm:text-4xl">Próximos eventos</h2>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach($eventos as $evento)
                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                            <div class="flex items-center gap-4">
                                <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-amber-400 text-slate-900">
                                    <span class="text-lg font-extrabold leading-none">{{ $evento->start_at?->format('d') }}</span>
                                    <span class="text-xs font-bold uppercase">{{ $evento->start_at?->format('M') }}</span>
                                </div>
                                <div>
                                    <h3 class="font-display text-lg font-bold text-white">{{ $evento->title }}</h3>
                                    @if($evento->location)
                                        <p class="mt-1 flex items-center gap-1 text-xs text-sky-100/80">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $evento->location }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-white py-20">
        <div class="container-site text-center">
            <h2 class="section-title mx-auto max-w-2xl">Quer saber mais sobre a nossa comunidade?</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-600">Estamos à disposição para atender você. Fale conosco ou visite o nosso atendimento.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('web.atendimento') }}" class="btn-primary">Entrar em contato</a>
                <a href="{{ route('web.create.member') }}" class="btn-secondary">Quero ser membro</a>
            </div>
        </div>
    </section>
@endsection
