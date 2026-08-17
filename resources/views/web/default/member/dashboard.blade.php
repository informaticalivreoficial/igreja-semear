@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Minha conta</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Olá, {{ strtok($member->name, ' ') }}!</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Bem-vindo(a) à sua área do membro. Acompanhe a vida da igreja por aqui.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1 space-y-6">
                <div class="grid gap-4 sm:grid-cols-3">
                    <a href="{{ route('member.agenda') }}" class="rounded-2xl border border-brand-100 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Próximos eventos</p>
                        <p class="mt-2 font-display text-3xl font-bold text-brand-700">{{ $proximos_eventos->count() }}</p>
                    </a>
                    <a href="{{ route('member.inscricoes') }}" class="rounded-2xl border border-brand-100 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Minhas inscrições</p>
                        <p class="mt-2 font-display text-3xl font-bold text-brand-700">{{ $minhas_inscricoes->count() }}</p>
                    </a>
                    <a href="{{ route('member.avisos') }}" class="rounded-2xl border border-brand-100 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Avisos da igreja</p>
                        <p class="mt-2 font-display text-3xl font-bold text-brand-700">{{ $avisos->count() }}</p>
                    </a>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h2 class="font-display text-lg font-bold text-brand-900">Próximos eventos</h2>
                            <a href="{{ route('member.agenda') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Ver agenda</a>
                        </div>
                        <div class="mt-4 space-y-4">
                            @forelse($proximos_eventos as $evento)
                                <div class="flex items-center gap-3">
                                    <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-600/10 text-brand-700">
                                        <span class="text-base font-extrabold leading-none">{{ $evento->start_at->format('d') }}</span>
                                        <span class="text-[10px] font-bold uppercase">{{ $evento->start_at->translatedFormat('M') }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800">{{ $evento->title }}</p>
                                        <p class="text-xs text-slate-500">{{ $evento->start_at->translatedFormat('l, d \d\e F') }} · {{ $evento->start_at->format('H:i') }}h</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Nenhum evento agendado no momento.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h2 class="font-display text-lg font-bold text-brand-900">Avisos</h2>
                            <a href="{{ route('member.avisos') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Ver todos</a>
                        </div>
                        <div class="mt-4 space-y-4">
                            @forelse($avisos as $aviso)
                                <a href="{{ route('member.avisos', ['#aviso-'.$aviso->id]) }}" class="block rounded-xl border border-brand-100 p-3 transition hover:border-brand-200 hover:bg-brand-50/50">
                                    <p class="text-sm font-semibold text-slate-800">{{ $aviso->title }}</p>
                                    <p class="mt-1 line-clamp-2 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($aviso->content), 120) }}</p>
                                </a>
                            @empty
                                <p class="text-sm text-slate-500">Sem avisos no momento.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                    <h2 class="font-display text-lg font-bold text-brand-900">Minhas próximas inscrições</h2>
                    @forelse($minhas_inscricoes as $inscricao)
                        <div class="mt-4 flex items-center justify-between gap-3 border-b border-brand-100 pb-3 last:border-0">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $inscricao->event->title }}</p>
                                <p class="text-xs text-slate-500">{{ $inscricao->event->start_at?->translatedFormat('d \d\e F \à\s H:i') }}</p>
                            </div>
                            @if($inscricao->status === \App\Models\EventRegistration::STATUS_CONFIRMADA)
                                <span class="rounded-full bg-accent-500/15 px-2.5 py-1 text-xs font-semibold text-accent-700">Confirmada</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pendente</span>
                            @endif
                        </div>
                    @empty
                        <p class="mt-3 text-sm text-slate-500">Você ainda não possui inscrições ativas. <a href="{{ route('member.agenda') }}" class="font-semibold text-brand-600">Inscreva-se em um evento.</a></p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
