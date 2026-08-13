@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Política de Privacidade</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Política de Privacidade</h1>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container-site max-w-4xl">
            @if(optional($configuracoes)->privacy_policy)
                <div class="prose-site text-slate-700">
                    {!! $configuracoes->privacy_policy !!}
                </div>
            @else
                <div class="prose-site text-slate-700">
                    <p>
                        A {{ optional($configuracoes)->app_name ?: 'Semear' }} preza pela privacidade dos dados
                        dos seus visitantes e membros. Esta página apresentará em breve a nossa Política de Privacidade
                        detalhada, explicando quais dados coletamos e como os utilizamos.
                    </p>
                </div>
            @endif
        </div>
    </section>
@endsection
