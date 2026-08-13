@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Eventos</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Eventos</h1>
            <p class="mt-3 max-w-2xl text-sky-100/90">Acompanhe a agenda de eventos da igreja.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="container-site">
            @if($eventos->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($eventos as $evento)
                        <div class="card-post group">
                            @if($evento->cover)
                                <div class="aspect-[16/9] overflow-hidden">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($evento->cover) }}"
                                        alt="{{ $evento->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                </div>
                            @endif
                            <div class="flex flex-1 flex-col p-5">
                                @if($evento->start_at)
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-sky-600/10 text-sky-700">
                                            <span class="text-lg font-extrabold leading-none">{{ $evento->start_at->format('d') }}</span>
                                            <span class="text-xs font-bold uppercase">{{ $evento->start_at->translatedFormat('M') }}</span>
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            <p class="font-semibold uppercase tracking-wide text-sky-600">{{ $evento->start_at->translatedFormat('l') }}</p>
                                            <p>{{ $evento->start_at->format('H:i') }}h</p>
                                        </div>
                                    </div>
                                @endif
                                <h2 class="font-display mt-4 text-lg font-bold leading-snug text-slate-900">{{ $evento->title }}</h2>
                                @if($evento->description)
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($evento->description, 140) }}</p>
                                @endif
                                @if($evento->location)
                                    <p class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs text-slate-500">
                                        <svg class="h-4 w-4 shrink-0 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $evento->location }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $eventos->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                    <p class="font-display text-xl font-bold text-slate-900">Nenhum evento por enquanto</p>
                    <p class="mt-2 text-sm text-slate-500">Acompanhe o site e as redes sociais para novidades.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
