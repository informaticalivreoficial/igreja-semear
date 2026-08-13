@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Minha família</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Minha família</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Veja os membros da sua família.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @if($familia)
                    <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-600/10 text-sky-700">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-display text-xl font-bold text-slate-900">{{ $familia->name }}</h2>
                                <p class="text-sm text-slate-500">{{ $familia->members->count() }} {{ $familia->members->count() === 1 ? 'membro' : 'membros' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            @foreach($familia->members->sortBy([
                                ['family_role', 'desc'],
                                ['name', 'asc'],
                            ]) as $pessoa)
                                @php
                                    $roles = ['chefe' => 3, 'conjuge' => 2, 'filho' => 1, null => 0, 'outro' => 0];
                                    $cor = match ($pessoa->family_role) {
                                        'chefe' => 'bg-sky-100 text-sky-700',
                                        'conjuge' => 'bg-emerald-100 text-emerald-700',
                                        'filho' => 'bg-amber-100 text-amber-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp
                                <div class="flex items-center gap-4 rounded-xl border border-slate-100 p-4 {{ $pessoa->id === $member->id ? 'ring-2 ring-sky-200' : '' }}">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-200 font-bold text-slate-700">
                                        {{ strtoupper(substr($pessoa->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-semibold text-slate-800">
                                            {{ $pessoa->name }}
                                            @if($pessoa->id === $member->id)
                                                <span class="text-xs font-medium text-sky-600">(você)</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $pessoa->family_role_label }}</p>
                                    </div>
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $cor }}">{{ $pessoa->family_role_label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl border border-slate-100 bg-white p-12 text-center shadow-sm">
                        <p class="font-display text-xl font-bold text-slate-900">Você ainda não está vinculado(a) a uma família</p>
                        <p class="mt-2 text-sm text-slate-500">Fale com a secretaria da igreja para cadastrar sua família.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
