@extends("web.{$configuracoes->template}.master.master")

@section('content')
    {{-- HERO --}}
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <a href="{{ $post->type === 'noticia' ? route('web.noticias') : route('web.blog.artigos') }}">
                    {{ $post->type === 'noticia' ? 'Notícias' : 'Blog' }}
                </a>
                @if($post->categoriaObject)
                    <span class="sep">/</span>
                    <a href="{{ route($post->type === 'noticia' ? 'web.noticia.categoria' : 'web.blog.categoria', ['slug' => $post->categoriaObject->slug]) }}">
                        {{ $post->categoriaObject->title }}
                    </a>
                @endif
            </nav>
            <span class="badge-cat !bg-white/10 !text-amber-300 mt-4">
                {{ $post->type === 'noticia' ? 'Notícia' : 'Artigo' }}
            </span>
            <h1 class="font-display mt-3 max-w-3xl text-3xl font-bold leading-tight text-white sm:text-4xl">{{ $post->title }}</h1>
            <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-sky-100/90">
                @if($post->userObject?->name)
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $post->userObject->name }}
                    </span>
                @endif
                @if($post->publish_at)
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $post->publish_at->format('d \d\e F \d\e Y') }}
                    </span>
                @endif
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    {{ $post->views }} visualizações
                </span>
            </div>
        </div>
    </section>

    {{-- CONTEÚDO --}}
    <section class="bg-white py-16">
        <div class="container-site grid gap-10 lg:grid-cols-[1fr_320px]">
            <article>
                @if($post->cover())
                    <img src="{{ $post->cover() }}" alt="{{ $post->title }}" class="w-full rounded-2xl object-cover shadow-sm">
                @endif

                <div class="prose-site mt-10 text-slate-700">
                    {!! $post->content !!}
                </div>

                @if($post->tags)
                    @php($tags = array_filter(array_map('trim', explode(',', $post->tags))))
                    <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-6">
                        <span class="text-sm font-bold text-slate-900">Tags:</span>
                        @foreach($tags as $tag)
                            <a href="{{ route('web.blog.searchBlog', ['search' => $tag]) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 transition hover:bg-sky-600/10 hover:text-sky-700">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </article>

            @include('web.default.partials.blog-sidebar', [
                'categorias' => $categorias ?? collect(),
                'recentes' => $recentes ?? collect(),
                'active' => $post->categoriaObject,
            ])
        </div>
    </section>

    {{-- RELACIONADOS --}}
    @if(isset($relacionados) && $relacionados->count())
        <section class="bg-slate-50 py-16">
            <div class="container-site">
                <h2 class="section-title">Você também pode gostar</h2>
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach($relacionados as $postRelacionado)
                        @include('web.default.partials.post-card', ['post' => $postRelacionado])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
