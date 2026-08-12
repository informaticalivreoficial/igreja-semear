<div class="max-w-7xl mx-auto">
    
    {{-- HEADER --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        {{-- SEARCH --}}
        <div class="relative w-full lg:max-w-xl">

            <svg
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
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
                placeholder="Buscar passeio..."
                class="w-full h-12 pl-12 pr-4 rounded-2xl border border-slate-200 bg-white text-sm focus:border-cyan-500 focus:ring focus:ring-cyan-100 outline-none transition"
            >

        </div>

        {{-- BUTTON --}}
        <a
            href="{{ route('company.tours.create') }}"
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

            Novo Passeio

        </a>

    </div>

    {{-- EMPTY --}}
    @if($tours->isEmpty())

        <div
            class="bg-white rounded-3xl p-12 text-center"
            style="border: 1px solid #e8e4d8;"
        >

            <div
                class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center mb-5"
                style="background-color: rgba(22,163,183,0.08);"
            >

                <svg
                    class="w-10 h-10"
                    style="color: #16a3b7;"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    <path d="M3 21h18"/>
                </svg>

            </div>

            <h2
                class="text-xl font-extrabold mb-2"
                style="color: #051e34;"
            >
                Nenhum passeio cadastrado
            </h2>

            <p
                class="text-sm mb-6"
                style="color: #87c2c0;"
            >
                Comece cadastrando seu primeiro passeio.
            </p>

            <a
                href="{{ route('company.tours.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold transition"
                style="background-color: #23c55e; color: #ffffff;"
            >
                Criar passeio
            </a>

        </div>

    @else

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($tours as $tour)

                <div
                    class="bg-white rounded-3xl overflow-hidden transition hover:-translate-y-1"
                    style="border: 1px solid #e8e4d8;"
                >

                    {{-- IMAGE --}}
                    <div class="relative">

                        @if($tour->images->first())

                            <img
                                src="{{ $tour->cover() }}"
                                class="w-full h-52 object-cover"
                            >

                        @else

                            <div
                                class="w-full h-52 flex items-center justify-center"
                                style="background-color: rgba(22,163,183,0.06);"
                            >

                                <svg
                                    class="w-12 h-12"
                                    style="color: #16a3b7;"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M3 17l4-8 4 4 4-6 4 10"/>
                                    <path d="M3 21h18"/>
                                </svg>

                            </div>

                        @endif

                        {{-- STATUS --}}
                        <div class="absolute top-3 right-3">

                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold"
                                style="
                                    background-color: {{ $tour->active ? 'rgb(35,197,94)' : 'rgba(239,68,68)' }};
                                    color: {{ $tour->active ? '#ffffff' : '#ffffff' }};
                                "
                            >
                                {{ $tour->active ? 'Ativo' : 'Inativo' }}
                            </span>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5">

                        <div class="mb-4">

                            <h2
                                class="text-lg font-extrabold leading-tight"
                                style="color: #051e34;"
                            >
                                {{ $tour->title }}
                            </h2>

                            <p
                                class="text-sm mt-1"
                                style="color: #87c2c0;"
                            >
                                {{ $tour->vessel?->name }}
                            </p>

                        </div>

                        {{-- INFO --}}
                        <div class="space-y-2 mb-5">

                            <div class="flex items-center justify-between text-sm">
                                <span style="color: #87c2c0;">Tipo</span>
                                <strong style="color: #051e34;">
                                    {{ $tour->tour_type->label() }}
                                </strong>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span style="color: #87c2c0;">Duração</span>
                                <strong style="color: #051e34;">
                                    {{ $tour->duration }} Hs
                                </strong>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <span style="color: #87c2c0;">Preço</span>
                                <strong style="color: #23c55e;">
                                    R$ {{ number_format($tour->price, 2, ',', '.') }}
                                </strong>
                            </div>

                        </div>

                        {{-- ACTIONS --}}
                        <div class="space-y-2">

                            {{-- LINHA 1 --}}
                            <div class="flex items-center gap-2">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('company.tours.edit', $tour->uuid) }}"
                                    class="flex-1 h-11 inline-flex items-center justify-center rounded-xl bg-cyan-50 text-cyan-700 text-sm font-bold hover:bg-cyan-100 transition"
                                >
                                    Editar
                                </a>

                                {{-- CALENDAR --}}
                                <a
                                    href="{{ route('company.tours.dates', $tour->uuid) }}"
                                    class="flex-1 h-11 inline-flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 text-sm font-bold hover:bg-indigo-100 transition"
                                >

                                    <svg
                                        class="w-4 h-4 mr-2"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>

                                    Agenda

                                </a>

                            </div>

                            {{-- LINHA 2 --}}
                            <div class="flex items-center gap-2">

                                {{-- STATUS --}}
                                <button
                                    wire:click="toggleStatus({{ $tour->id }})"
                                    type="button"
                                    class="flex-1 h-11 rounded-xl text-sm font-bold transition"
                                    style="
                                        background-color: {{ $tour->active ? 'rgba(250,204,21,0.15)' : 'rgba(35,197,94,0.15)' }};
                                        color: {{ $tour->active ? '#ca8a04' : '#15803d' }};
                                    "
                                >
                                    {{ $tour->active ? 'Desativar' : 'Ativar' }}
                                </button>

                                {{-- DELETE --}}
                                <button
                                    wire:click="setDeleteId({{ $tour->id }})"
                                    type="button"
                                    class="h-11 w-11 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition flex items-center justify-center shrink-0"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M3 6h18"/>
                                        <path d="M8 6V4h8v2"/>
                                        <path d="M19 6l-1 14H6L5 6"/>
                                    </svg>
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $tours->links() }}
        </div>

    @endif
</div>