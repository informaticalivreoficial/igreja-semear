@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Pedidos de oração</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Pedidos de oração</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Envie seus pedidos e acompanhe as respostas.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1 space-y-6">
                <form method="POST" action="{{ route('member.oracoes.store') }}" class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                    @csrf
                    <h2 class="font-display text-lg font-bold text-brand-900">Novo pedido</h2>
                    <textarea name="message" rows="4" required class="form-control mt-4" placeholder="Escreva o seu pedido de oração..."></textarea>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="btn-primary">Enviar pedido</button>
                    </div>
                </form>

                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                    <h2 class="font-display text-lg font-bold text-brand-900">Meus pedidos</h2>
                    <div class="mt-4 space-y-4">
                        @forelse($oracoes as $pedido)
                            <div class="rounded-xl border border-brand-100 p-4">
                                <p class="text-sm leading-6 text-slate-700">{{ $pedido->message }}</p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xs text-slate-400">{{ $pedido->created_at->translatedFormat('d \d\e F \d\e Y') }}</span>
                                    @if($pedido->status === 'respondido' && $pedido->answer)
                                        <span class="rounded-full bg-accent-500/15 px-2.5 py-1 text-xs font-semibold text-accent-700">Respondido</span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pendente</span>
                                    @endif
                                </div>
                                @if($pedido->status === 'respondido' && $pedido->answer)
                                    <div class="mt-3 rounded-lg bg-brand-50 p-3 text-sm text-brand-800">
                                        <strong>Resposta:</strong> {{ $pedido->answer }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Você ainda não enviou nenhum pedido.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
