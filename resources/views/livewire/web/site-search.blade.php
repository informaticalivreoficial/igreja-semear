<div
    x-data="{ open: false }"
    @click.outside="open = false"
    class="relative w-full"
>
    <form action="{{ route('web.blog.searchBlog') }}" method="GET" class="relative">
        <svg
            class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
        </svg>
        <input
            type="text"
            name="search"
            placeholder="Buscar no site..."
            wire:model.live.debounce.250ms="term"
            @focus="open = true"
            autocomplete="off"
            class="w-full rounded-full border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
        />
    </form>

    <div
        x-cloak
        x-show="open && $wire.term.trim().length >= 2"
        x-transition
        class="absolute left-0 right-0 top-full z-50 mt-2 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-xl"
    >
        @if($this->results->isNotEmpty())
            <ul class="max-h-96 divide-y divide-slate-100 overflow-y-auto">
                @foreach($this->results as $result)
                    <li>
                        <a
                            href="{{ route($result->type === 'noticia' ? 'web.noticia' : 'web.blog.artigo', ['slug' => $result->slug]) }}"
                            class="flex items-start gap-3 px-4 py-3 transition hover:bg-sky-50"
                        >
                            <span class="mt-0.5 text-xs font-bold uppercase tracking-wide text-sky-600">
                                {{ $result->type === 'noticia' ? 'Notícia' : 'Artigo' }}
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-semibold text-slate-800">{{ $result->title }}</span>
                                <span class="block text-xs text-slate-500">
                                    {{ $result->categoriaObject?->title }}
                                    @if($result->publish_at)
                                        &middot; {{ $result->publish_at->format('d/m/Y') }}
                                    @endif
                                </span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="px-4 py-4 text-sm text-slate-500">
                Nenhum resultado para <strong>"{{ $this->term }}"</strong>.
            </p>
        @endif

        <div class="border-t border-slate-100 bg-slate-50 px-4 py-2">
            <a
                href="{{ route('web.blog.searchBlog', ['search' => $this->term]) }}"
                class="text-xs font-semibold text-sky-600 hover:text-sky-700"
            >
                Ver todos os resultados &rarr;
            </a>
        </div>
    </div>
</div>
