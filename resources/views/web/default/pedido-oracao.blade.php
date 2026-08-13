@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Pedido de Oração</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Pedido de Oração</h1>
            <p class="mt-3 max-w-2xl text-sky-100/90">Não tema, creia. Envie o seu pedido e a nossa equipe intercederá por você.</p>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container-site grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="section-title">Envie seu pedido</h2>
                <p class="mt-4 leading-7 text-slate-600">
                    "Peçam, e será dado; busquem, e encontrarão; batam, e a porta será aberta." (Mateus 7:7)
                </p>
                <div class="mt-10">
                    <livewire:web.prayer-request />
                </div>
            </div>

            <div class="space-y-5">
                <div class="page-hero rounded-2xl p-8">
                    <h3 class="font-display text-xl font-bold text-white">Precisa de alguém para conversar?</h3>
                    <p class="mt-2 text-sm leading-6 text-sky-100/90">
                        Nossa equipe está à disposição para orar com você e oferecer acolhimento.
                    </p>
                    <a href="{{ route('web.atendimento') }}" class="btn-white btn-sm mt-4">Fale conosco</a>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-8">
                    <h3 class="font-display text-lg font-bold text-slate-900">Oração do Pai Nosso</h3>
                    <p class="mt-3 text-sm italic leading-7 text-slate-600">
                        "Pai nosso, que estás nos céus, santificado seja o teu nome. Venha o teu reino; seja feita a tua vontade, assim na terra como no céu..."
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
