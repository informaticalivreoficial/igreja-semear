@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Pregações</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Pregações</h1>
            <p class="mt-3 max-w-2xl text-brand-100/90">Ouça e assista as mensagens que transformam vidas.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-16">
        <div class="container-site">
            <livewire:web.pregacoes />
        </div>
    </section>
@endsection