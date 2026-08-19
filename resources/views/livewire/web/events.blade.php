<div>
    @php
        $typeLabels = [
            'evento' => 'Evento',
            'culto' => 'Culto',
            'campanha' => 'Campanha',
            'especial' => 'Especial',
        ];

        $typeBadges = [
            'culto' => 'badge-cat',
            'evento' => 'badge-cat-amber',
            'campanha' => 'badge-cat',
            'especial' => 'badge-cat-amber',
        ];
    @endphp

    {{-- FILTROS --}}
    <div class="mb-10 rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="mr-1 hidden text-xs font-bold uppercase tracking-wide text-brand-600 sm:inline">Filtrar por:</span>
                <button type="button" wire:click="setFilter('tipo', '')"
                    class="cursor-pointer rounded-full border px-4 py-1.5 text-sm font-semibold transition {{ $tipo === '' ? 'border-brand-600 bg-brand-600 text-white' : 'border-brand-100 bg-white text-brand-700' }}">
                    Todos
                </button>
                @foreach ($typeLabels as $key => $label)
                    <button type="button" wire:click="setFilter('tipo', '{{ $key }}')"
                        class="cursor-pointer rounded-full border px-4 py-1.5 text-sm font-semibold transition {{ $tipo === $key ? 'border-brand-600 bg-brand-600 text-white' : 'border-brand-100 bg-white text-brand-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select wire:model.live="periodo" class="form-control sm:w-64">
                    <option value="todos">Todos os períodos</option>
                    <option value="proximos">Próximos eventos</option>
                    <option value="passados">Eventos realizados</option>
                </select>
                <div class="relative flex-1">
                    <i class="fas fa-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="search" wire:model.live.debounce.400ms="busca"
                        placeholder="Buscar por título ou local..." class="form-control pl-9">
                </div>
            </div>
        </div>
    </div>

    @if($eventos->count())
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($eventos as $evento)
                <div class="card-post group">
                    @if($evento->cover)
                        <div class="aspect-[16/9] overflow-hidden">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($evento->cover) }}"
                                alt="{{ $evento->title }}"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    @endif
                    <div class="flex flex-1 flex-col p-5">
                        @if($evento->start_at)
                            <div class="flex items-center gap-3">
                                <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-accent-500/15 text-accent-700">
                                    <span class="text-lg font-extrabold leading-none">{{ $evento->start_at->format('d') }}</span>
                                    <span class="text-xs font-bold uppercase">{{ $evento->start_at->translatedFormat('M') }}</span>
                                </div>
                                <div class="text-xs text-slate-500">
                                    <p class="font-semibold uppercase tracking-wide text-brand-600">{{ $evento->start_at->translatedFormat('l') }}</p>
                                    <p>{{ $evento->start_at->format('H:i') }}h</p>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 flex items-center gap-2">
                            @if(isset($typeBadges[$evento->type]))
                                <span class="{{ $typeBadges[$evento->type] }}">{{ $typeLabels[$evento->type] ?? ucfirst($evento->type) }}</span>
                            @endif
                            <h2 class="font-display text-lg font-bold leading-snug text-brand-900">{{ $evento->title }}</h2>
                        </div>

                        @if($evento->description)
                            <p class="mt-2 text-sm leading-6 text-slate-600">{!! \Illuminate\Support\Str::limit($evento->description, 140) !!}</p>
                        @endif

                        @if($evento->location)
                            <p class="mt-4 flex items-center gap-2 border-t border-brand-100 pt-3 text-xs text-slate-500">
                                <svg class="h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $evento->location }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $eventos->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
            <p class="font-display text-xl font-bold text-brand-900">Nenhum evento encontrado</p>
            <p class="mt-2 text-sm text-slate-500">Ajuste os filtros ou acompanhe o site e as redes sociais para novidades.</p>
        </div>
    @endif
</div>