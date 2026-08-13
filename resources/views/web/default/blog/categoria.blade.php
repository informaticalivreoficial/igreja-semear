@extends("web.{$configuracoes->template}.master.master")

@section('content')
    {{-- HERO --}}
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                @if($categoria->type === 'noticia')
                    <a href="{{ route('web.noticias') }}">Notícias</a>
                @else
                    <a href="{{ route('web.blog.artigos') }}">Blog</a>
                @endif
                <span class="sep">/</span>
                <span>{{ $categoria->title }}</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">{{ $categoria->title }}</h1>
            @if($categoria->content)
                <p class="mt-3 max-w-2xl text-sky-100/90">{{ $categoria->content }}</p>
            @endif
        </div>
    </section>

    {{-- CONTEÚDO --}}
    <section class="bg-slate-50 py-16">
        <div class="container-site grid gap-10 lg:grid-cols-[1fr_320px]">
            <div>
                @if($posts->count())
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach($posts as $post)
                            @include('web.default.partials.post-card', ['post' => $post])
                        @endforeach
                    </div>
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-slate-900">Nenhuma publicação nesta categoria</p>
                        <p class="mt-2 text-sm text-slate-500">Volte em breve para acompanhar as novidades.</p>
                    </div>
                @endif
            </div>

            @include('web.default.partials.blog-sidebar', [
                'categorias' => $categorias ?? collect(),
                'recentes' => $recentes ?? collect(),
                'active' => $categoria,
            ])
        </div>
    </section>
@endsection
