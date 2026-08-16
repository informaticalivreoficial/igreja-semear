<div>
    {{-- BUSCA E CATEGORIAS --}}
    <div class="mb-10 rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-5">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" wire:model.live.debounce.400ms="busca"
                    class="input-site w-full pl-11"
                    placeholder="Buscar pregações...">
            </div>

            @if ($categorias->count())
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" wire:click="setCategoria('')"
                        class="cursor-pointer rounded-full border px-4 py-1.5 text-sm font-semibold transition {{ $categoria === '' ? 'border-brand-600 bg-brand-600 text-white' : 'border-brand-100 bg-white text-brand-700' }}">
                        Todas
                    </button>
                    @foreach ($categorias as $cat)
                        <button type="button" wire:click="setCategoria('{{ $cat }}')"
                            class="cursor-pointer rounded-full border px-4 py-1.5 text-sm font-semibold transition {{ $categoria === $cat ? 'border-brand-600 bg-brand-600 text-white' : 'border-brand-100 bg-white text-brand-700' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if ($pregacoes->count())
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($pregacoes as $video)
                <a target="_blank" rel="noopener" href="{{ $video->watchUrl() }}"
                    class="group card-post overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="relative aspect-video w-full overflow-hidden bg-black">
                        <img src="{{ $video->thumbnail() }}" alt="{{ $video->title }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        <span class="absolute inset-0 flex items-center justify-center bg-black/30 opacity-0 transition group-hover:opacity-100">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-red-600 text-white shadow-lg">
                                <i class="fas fa-play ml-0.5"></i>
                            </span>
                        </span>
                    </div>
                    <div class="p-5">
                        @if ($video->category)
                            <span class="badge-cat">{{ $video->category }}</span>
                        @endif
                        <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-brand-600">
                            {{ $video->publish_at?->translatedFormat('d \de M \de Y') }}
                        </p>
                        <h3 class="font-display mt-2 line-clamp-2 text-base font-bold leading-snug text-brand-900">
                            {{ $video->title }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $pregacoes->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
            <p class="font-display text-xl font-bold text-brand-900">Nenhuma pregação encontrada</p>
            <p class="mt-2 text-sm text-slate-500">Ajuste a busca ou acompanhe as novidades no canal oficial.</p>
        </div>
    @endif
</div>