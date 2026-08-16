@extends("web.{$configuracoes->template}.master.master")

@section('content')
    {{-- HERO SLIDER --}}
    @if(isset($slides) && $slides->count())
        <section
            x-data="{ active: 0, total: {{ $slides->count() }}, timer: null, start() { this.timer = setInterval(() => { this.active = (this.active + 1) % this.total }, 6000) }, stop() { clearInterval(this.timer) } }"
            x-init="start()"
            class="relative h-[480px] overflow-hidden bg-brand-900 sm:h-[560px]"
            @mouseenter="stop()"
            @mouseleave="start()"
        >
            @foreach($slides as $i => $slide)
                <div
                    x-show="active === {{ $i }}"
                    x-transition.opacity.duration.700ms
                    class="absolute inset-0"
                >
                    @if($slide->image)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($slide->image) }}"
                            alt="{{ $slide->title }}"
                            class="h-full w-full object-cover opacity-50"
                        >
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-brand-800 via-brand-700 to-brand-600"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 via-brand-800/40 to-transparent"></div>
                </div>
            @endforeach

            <div class="container-site relative flex h-full items-center">
                <div class="max-w-2xl text-white">
                    @foreach($slides as $i => $slide)
                        <div x-show="active === {{ $i }}" x-transition:enter.delay.200ms>
                            <span class="badge-cat !bg-white/10 !text-accent-300">Bem-vindo à {{ optional($configuracoes)->app_name ?: 'Comunidade Cristã Semear' }}</span>
                            <h1 class="font-display mt-4 text-4xl font-bold leading-tight sm:text-5xl">{{ $slide->title }}</h1>
                            @if($slide->subtitle)
                                <p class="mt-4 text-lg text-brand-100/90">{{ $slide->subtitle }}</p>
                            @endif
                            @if($slide->button_label && $slide->link)
                                <a href="{{ $slide->link }}" target="{{ $slide->target ?: '_self' }}" class="btn-secondary mt-6">
                                    {{ $slide->button_label }}
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
                            :class="active === {{ $i }} ? 'w-8 bg-accent-400' : 'w-2.5 bg-white/50 hover:bg-white'"
                            aria-label="Slide {{ $i + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif    

    {{-- AO VIVO / ÚLTIMO CULTO --}}
    @if(isset($youtubeAoVivo) || isset($youtubeUltimoCulto))
        <section class="bg-brand-900 py-20">
            <div class="container-site">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <span class="badge-cat">Cultos Online</span>
                        <h2 class="font-display mt-4 text-3xl font-bold text-white">
                            @if(isset($youtubeAoVivo) && $youtubeAoVivo)
                                <span class="inline-flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-red-500"></span>
                                    Ao vivo agora
                                </span>
                            @else
                                Último culto
                            @endif
                        </h2>
                    </div>
                    <a href="{{ route('web.cultos') }}" class="btn-secondary">Ver todos os cultos &rarr;</a>
                </div>

                <div class="mt-10 grid items-center gap-10 lg:grid-cols-2">
                    <div class="relative aspect-video w-full overflow-hidden rounded-3xl bg-black shadow-2xl">
                        @if(isset($youtubeAoVivo) && $youtubeAoVivo)
                            <iframe class="absolute inset-0 h-full w-full"
                                src="{{ $youtubeAoVivo->embedUrl() }}?autoplay=1&rel=0"
                                title="{{ $youtubeAoVivo->title }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        @else
                            <a href="{{ route('web.cultos') }}" class="absolute inset-0 group">
                                <img src="{{ $youtubeUltimoCulto->thumbnail() }}" alt="{{ $youtubeUltimoCulto->title }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                <span class="absolute inset-0 flex items-center justify-center bg-black/30">
                                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-red-600 text-white shadow-lg">
                                        <i class="fas fa-play ml-1 text-2xl"></i>
                                    </span>
                                </span>
                            </a>
                        @endif
                    </div>

                    <div>
                        @php
                            $videoDestaque = $youtubeAoVivo ?? $youtubeUltimoCulto;
                        @endphp
                        @if(isset($videoDestaque))
                            @if(isset($youtubeAoVivo) && $youtubeAoVivo)
                                <span class="inline-flex items-center gap-2 rounded-full bg-red-600 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white">
                                    <span class="h-2 w-2 animate-pulse rounded-full bg-white"></span>
                                    Transmissão ao vivo
                                </span>
                            @endif
                            <h3 class="font-display mt-4 text-2xl font-bold leading-snug text-white">{{ $videoDestaque->title }}</h3>
                            @if($videoDestaque->publish_at)
                                <p class="mt-2 text-sm text-brand-200">{{ $videoDestaque->publish_at->translatedFormat('l, d \de F \de Y') }}</p>
                            @endif
                            @if($videoDestaque->description)
                                <p class="mt-4 text-sm leading-6 text-brand-200/90">{{ \Illuminate\Support\Str::limit($videoDestaque->description, 160) }}</p>
                            @endif
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a target="_blank" rel="noopener" href="{{ $videoDestaque->watchUrl() }}" class="btn-primary">
                                    <i class="fab fa-youtube mr-2"></i> Assistir no YouTube
                                </a>
                                <a href="{{ route('web.pregacoes') }}" class="btn-white">Pregações</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

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
