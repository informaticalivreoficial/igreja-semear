@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>{{ $post->title }}</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">{{ $post->title }}</h1>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container-site max-w-4xl">
            <div class="prose-site text-slate-700">
                {!! $post->content !!}
            </div>

            @if($post->slug === 'localizacao' && optional($configuracoes)->maps_google)
                <div class="mt-10 overflow-hidden rounded-2xl border border-slate-100 shadow-sm">
                    {!! $configuracoes->maps_google !!}
                </div>
            @endif

            @if($post->images()->get()->count())
                <div class="mt-10 grid gap-4 sm:grid-cols-2">
                    @foreach($post->images()->get() as $image)
                        <img src="{{ $image->path }}" alt="{{ $post->title }}" class="w-full rounded-2xl object-cover shadow-sm">
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
