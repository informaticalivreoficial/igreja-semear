@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Avisos</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Avisos da igreja</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Comunicados e novidades da comunidade.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @forelse($avisos as $aviso)
                    <article id="aviso-{{ $aviso->id }}" class="mb-5 overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm">
                        @if($aviso->cover)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($aviso->cover) }}" alt="{{ $aviso->title }}" class="h-48 w-full object-cover">
                        @endif
                        <div class="p-6">
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-600">
                                {{ $aviso->publish_at?->translatedFormat('d \d\e F \d\e Y') ?? 'Aviso' }}
                            </p>
                            <h2 class="font-display mt-2 text-xl font-bold text-brand-900">{{ $aviso->title }}</h2>
                            <div class="prose-site mt-3 text-sm">{!! $aviso->content !!}</div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-brand-900">Nenhum aviso no momento</p>
                        <p class="mt-2 text-sm text-slate-500">Os comunicados da igreja aparecerão aqui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
