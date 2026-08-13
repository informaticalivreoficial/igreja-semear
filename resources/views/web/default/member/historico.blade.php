@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Histórico</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Histórico de inscrições</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Registro das suas inscrições em eventos já realizados.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @forelse($inscricoes as $inscricao)
                    <div class="mb-4 flex flex-col gap-2 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-display text-base font-bold text-slate-900">{{ $inscricao->event?->title }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $inscricao->event?->start_at?->translatedFormat('d \d\e F \à\s H:i') ?? '—' }}
                            </p>
                        </div>
                        @if($inscricao->status === 'cancelada')
                            <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Cancelada</span>
                        @else
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Realizado</span>
                        @endif
                    </div>
                @empty
                    <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-slate-900">Nenhum registro por enquanto</p>
                        <p class="mt-2 text-sm text-slate-500">Seu histórico de eventos aparecerá aqui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
