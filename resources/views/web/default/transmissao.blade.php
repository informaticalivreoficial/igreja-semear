@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Transmissão ao Vivo</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Transmissão ao Vivo</h1>
            <p class="mt-3 max-w-2xl text-brand-100/90">Acompanhe os nossos cultos onde estiver.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="container-site max-w-5xl">
            <div class="rounded-2xl border border-brand-100 bg-white p-14 text-center shadow-sm">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-50 text-brand-400">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </span>
                <h2 class="font-display mt-6 text-2xl font-bold text-brand-900">Nenhuma transmissão no momento</h2>
                <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-brand-700">
                    A transmissão ao vivo acontece nos horários dos nossos cultos. Acompanhe as nossas redes sociais para ser avisado.
                </p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    @if(optional($configuracoes)->youtube)
                        <a href="{{ $configuracoes->youtube }}" target="_blank" rel="noopener noreferrer" class="btn-primary">Canal no YouTube</a>
                    @endif
                    @if(optional($configuracoes)->instagram)
                        <a href="{{ $configuracoes->instagram }}" target="_blank" rel="noopener noreferrer" class="btn-secondary">Instagram</a>
                    @endif
                </div>
            </div>

            <div class="mt-8 rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold text-brand-900">Horários dos cultos</h2>
                <p class="mt-2 text-sm leading-6 text-brand-700">
                    Consulte os horários dos nossos cultos e reuniões na página
                    <a href="{{ route('web.pagina', ['slug' => 'cultos-e-horarios']) }}" class="font-semibold text-brand-600 hover:text-brand-700">Cultos e horários</a>.
                </p>
            </div>
        </div>
    </section>
@endsection
