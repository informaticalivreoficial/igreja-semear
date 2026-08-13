@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Ministérios</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Ministérios</h1>
            <p class="mt-3 max-w-2xl text-sky-100/90">Conheça os ministérios da igreja e encontre um lugar para servir.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="container-site">
            @if($ministerios->count())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($ministerios as $ministerio)
                        <div class="card-post group overflow-hidden">
                            <div class="aspect-[16/9] overflow-hidden">
                                <img
                                    src="{{ $ministerio->cover ? \Illuminate\Support\Facades\Storage::url($ministerio->cover) : asset('backend/assets/images/image.jpg') }}"
                                    alt="{{ $ministerio->name }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <h2 class="font-display text-xl font-bold text-slate-900">{{ $ministerio->name }}</h2>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $ministerio->description }}</p>
                                @if($ministerio->leader)
                                    <p class="mt-4 border-t border-slate-100 pt-3 text-xs text-slate-400">
                                        Liderado por <strong class="text-slate-600">{{ $ministerio->leader->name }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                    <p class="font-display text-xl font-bold text-slate-900">Em breve</p>
                    <p class="mt-2 text-sm text-slate-500">Os ministérios serão divulgados em breve.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
