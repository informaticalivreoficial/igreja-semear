@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Contribuições</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Minhas contribuições</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Acompanhe o histórico das suas doações e ofertas.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                <div class="mb-6 rounded-2xl bg-sky-700 p-6 text-white shadow-sm">
                    <p class="text-sm font-semibold text-sky-100">Total contribuído</p>
                    <p class="font-display mt-1 text-3xl font-bold">R$ {{ number_format($total, 2, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-sky-200">{{ $doacoes->count() }} {{ $doacoes->count() === 1 ? 'registro' : 'registros' }}</p>
                </div>

                @forelse($doacoes as $doacao)
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $doacao->type_label }}</p>
                            <p class="text-xs text-slate-500">{{ $doacao->created_at?->translatedFormat('d \d\e F \d\e Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-sky-700">R$ {{ number_format($doacao->amount, 2, ',', '.') }}</p>
                            @if($doacao->method_label && $doacao->method_label !== '—')
                                <p class="text-xs capitalize text-slate-400">{{ $doacao->method_label }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-slate-900">Nenhuma contribuição registrada</p>
                        <p class="mt-2 text-sm text-slate-500">Suas ofertas e doações aparecerão aqui.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
