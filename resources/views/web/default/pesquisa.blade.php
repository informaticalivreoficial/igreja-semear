@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Pesquisa</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">
                Resultados para "{{ $search }}"
            </h1>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="container-site max-w-4xl space-y-10">
            <div>
                <h2 class="section-title">Artigos e Notícias</h2>
                @if($artigos->count())
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach($artigos as $post)
                            @include('web.default.partials.post-card', ['post' => $post])
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-sm text-slate-500">Nenhum artigo ou notícia encontrado.</p>
                @endif
            </div>

            <div>
                <h2 class="section-title">Páginas</h2>
                @if($paginas->count())
                    <ul class="mt-6 space-y-2">
                        @foreach($paginas as $post)
                            <li>
                                <a href="{{ route('web.pagina', ['slug' => $post->slug]) }}" class="flex items-center justify-between rounded-xl border border-slate-100 bg-white px-5 py-4 shadow-sm transition hover:border-sky-200">
                                    <span class="font-semibold text-slate-800">{{ $post->title }}</span>
                                    <span class="text-sky-600">&rarr;</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 text-sm text-slate-500">Nenhuma página encontrada.</p>
                @endif
            </div>
        </div>
    </section>
@endsection
