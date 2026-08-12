<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div class="relative w-full lg:max-w-xl">

            <svg
                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <circle cx="11" cy="11" r="8"/>
                <path d="M21 21l-4.35-4.35"/>
            </svg>

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar embarcação..."
                class="w-full h-12 pl-10 pr-4 rounded-2xl border border-slate-200 bg-white text-sm focus:border-cyan-500 focus:ring focus:ring-cyan-100 outline-none transition"
            >

        </div>

        <a
            href="{{ route('company.vessels.create') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-emerald-500 text-white text-sm font-bold shadow-sm hover:bg-emerald-400 transition"
        >

            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5"
                viewBox="0 0 24 24"
            >
                <path d="M12 5v14M5 12h14"/>
            </svg>

            Nova Embarcação

        </a>

    </div>

    

    {{-- EMPTY --}}
    @if ($vessels->isEmpty())

        <div class="bg-white border border-dashed border-slate-300 rounded-3xl py-20 px-6 flex flex-col items-center justify-center text-center">

            <div class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center mb-5">
                🚤
            </div>

            <h3 class="text-lg font-bold text-slate-900 mb-2">
                Nenhuma embarcação cadastrada
            </h3>

            <p class="text-sm text-slate-500 mb-6">
                Adicione sua primeira embarcação para começar.
            </p>

            <a
                href="{{ route('company.vessels.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-emerald-500 text-white text-sm font-bold hover:bg-emerald-400 transition"
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                >
                    <path d="M12 5v14M5 12h14"/>
                </svg>

                Nova Embarcação

            </a>

        </div>

    @else

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach ($vessels as $vessel)

                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

                    {{-- IMAGE --}}
                    <div class="relative">

                        <img
                            src="{{ $vessel->cover() }}"
                            alt="{{ $vessel->name }}"
                            class="w-full h-52 object-cover"
                        >

                        {{-- STATUS --}}
                        <div class="absolute top-4 right-4">

                            @if ($vessel->active)

                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">

                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                    Ativo

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">

                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>

                                    Inativo

                                </span>

                            @endif

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 flex flex-col h-full">

                        {{-- TITLE --}}
                        <div class="mb-4">

                            <h3 class="text-lg font-bold text-slate-900 leading-tight">
                                {{ $vessel->name }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ $vessel->type ?? 'Sem categoria' }}
                            </p>

                        </div>

                        {{-- INFO --}}
                        <div class="grid grid-cols-2 gap-3 mb-5 text-sm">

                            <div class="bg-slate-50 rounded-xl px-3 py-2">
                                👥 {{ $vessel->capacity }} pessoas
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2">
                                📏 {{ $vessel->size }}m
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2">
                                📅 {{ $vessel->year }}
                            </div>

                            <div class="bg-slate-50 rounded-xl px-3 py-2">
                                🚿 {{ $vessel->bathroom }} banheiro(s)
                            </div>

                        </div>

                        {{-- FEATURES --}}
                        <div class="flex flex-wrap gap-2 mb-5">

                            @if ($vessel->barbecue)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                    🍖 Churrasqueira
                                </span>
                            @endif

                            @if ($vessel->suite)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                    🛏 Suíte
                                </span>
                            @endif

                            @if ($vessel->sound_system)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                    🎵 Som
                                </span>
                            @endif

                            @if ($vessel->kitchen)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">
                                    🍳 Cozinha
                                </span>
                            @endif

                        </div>

                        {{-- ACTIONS --}}
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-2">

                            <a
                                href="{{ route('company.vessels.edit', $vessel) }}"
                                class="flex-1 h-11 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition"
                            >
                                Editar
                            </a>

                            <button
                                wire:click="toggleStatus({{ $vessel->id }})"
                                class="flex-1 h-11 inline-flex items-center justify-center rounded-xl text-sm font-bold transition {{ $vessel->active
                                    ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
                                    : 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                                }}"
                            >

                                {{ $vessel->active ? 'Desativar' : 'Ativar' }}

                            </button>

                            <button
                                wire:click="setDeleteId({{ $vessel->id }})"
                                class="w-11 h-11 inline-flex items-center justify-center rounded-xl bg-red-100 text-red-600 hover:bg-red-200 transition"
                            >

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    viewBox="0 0 24 24"
                                >
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4h6v2"/>
                                </svg>

                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $vessels->links() }}
        </div>

    @endif   

</div>