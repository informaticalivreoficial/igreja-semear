@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Minhas inscrições</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Minhas inscrições</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Acompanhe o status das suas inscrições.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @forelse($inscricoes as $inscricao)
                    <div class="mb-4 flex flex-col gap-3 rounded-2xl border border-brand-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-display text-base font-bold text-brand-900">{{ $inscricao->event?->title }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $inscricao->event?->start_at?->translatedFormat('d \d\e F \à\s H:i') ?? '—' }}
                            </p>
                            <p class="mt-1 text-xs text-slate-400">Inscrito em {{ $inscricao->created_at->translatedFormat('d/m/Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @php
                                $badge = match ($inscricao->status) {
                                    'confirmada' => 'bg-accent-500/15 text-accent-700',
                                    'cancelada' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-amber-100 text-amber-700',
                                };
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $badge }}">{{ $inscricao->status }}</span>
                            @if($inscricao->event?->start_at?->gt(now()) && $inscricao->status !== 'cancelada')
                                <form method="POST" action="{{ route('member.inscricao.cancelar', $inscricao) }}" onsubmit="return confirm('Cancelar esta inscrição?')">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700">Cancelar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-brand-900">Você ainda não se inscreveu em nenhum evento</p>
                        <p class="mt-2 text-sm text-slate-500"><a href="{{ route('member.agenda') }}" class="font-semibold text-brand-600">Ver agenda</a> para se inscrever.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
