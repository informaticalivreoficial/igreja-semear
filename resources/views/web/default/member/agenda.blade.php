@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Agenda</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Agenda de eventos</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Inscreva-se nos eventos da igreja.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @if($eventos->count())
                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach($eventos as $evento)
                            @php
                                $inscrito = in_array($evento->id, $inscrito_ids);
                            @endphp
                            <div class="flex flex-col rounded-2xl border border-brand-100 bg-white p-5 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-brand-600/10 text-brand-700">
                                        <span class="text-lg font-extrabold leading-none">{{ $evento->start_at->format('d') }}</span>
                                        <span class="text-xs font-bold uppercase">{{ $evento->start_at->translatedFormat('M') }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="truncate font-display text-base font-bold text-brand-900">{{ $evento->title }}</h2>
                                        <p class="text-xs text-slate-500">{{ $evento->start_at->translatedFormat('l') }} · {{ $evento->start_at->format('H:i') }}h</p>
                                    </div>
                                </div>

                                @if($evento->description)
                                    <p class="mt-3 line-clamp-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($evento->description, 140) }}</p>
                                @endif

                                @if($evento->location)
                                    <p class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                                        <svg class="h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $evento->location }}
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center justify-between border-t border-brand-100 pt-4">
                                    <span class="text-xs text-slate-500">{{ $evento->registrations_count }} inscrito(s)</span>
                                    @if($inscrito)
                                        <span class="rounded-full bg-accent-500/15 px-3 py-1 text-xs font-semibold text-accent-700">Inscrito</span>
                                    @else
                                        <form method="POST" action="{{ route('member.inscrever') }}">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $evento->id }}">
                                            <button type="submit" class="btn-primary btn-sm">Inscrever-se</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-brand-900">Nenhum evento futuro no momento</p>
                        <p class="mt-2 text-sm text-slate-500">Acompanhe as novidades da igreja.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
