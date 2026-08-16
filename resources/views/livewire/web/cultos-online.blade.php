<div>
    {{-- AO VIVO / ÚLTIMO CULTO --}}
    @if ($aoVivo)
        <div class="mb-12 overflow-hidden rounded-3xl border border-brand-100 bg-white shadow-sm">
            <div class="relative aspect-video w-full bg-black">
                <iframe class="absolute inset-0 h-full w-full"
                    src="{{ $aoVivo->embedUrl() }}?autoplay=1&rel=0"
                    title="{{ $aoVivo->title }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
            <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-red-600 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-white"></span>
                        Ao vivo
                    </span>
                    <h2 class="font-display mt-3 text-xl font-bold text-brand-900">{{ $aoVivo->title }}</h2>
                </div>
                <a target="_blank" rel="noopener" href="{{ $aoVivo->watchUrl() }}"
                    class="btn btn-secondary shrink-0">
                    <i class="fab fa-youtube mr-2"></i> Assistir no YouTube
                </a>
            </div>
        </div>
    @else
        <div class="mb-12 overflow-hidden rounded-3xl border border-brand-100 bg-white shadow-sm">
            <div class="relative flex aspect-video w-full flex-col items-center justify-center bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 p-8 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10">
                    <i class="fab fa-youtube text-3xl text-accent-400"></i>
                </div>
                <p class="font-display mt-5 text-2xl font-bold text-white">Nenhuma transmissão ao vivo no momento</p>
                <p class="mt-2 max-w-md text-sm text-brand-200">
                    Acompanhe nossos últimos cultos abaixo ou inscreva-se no canal para ser avisado das próximas transmissões.
                </p>
            </div>
        </div>
    @endif

    {{-- PRÓXIMA TRANSMISSÃO --}}
    @if ($proximaTransmissao && $proximaTransmissao->isFuture())
        <div class="mb-12 flex flex-col gap-4 rounded-3xl border border-accent-500/30 bg-accent-500/10 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-accent-500 text-white">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-accent-700">Próxima transmissão</p>
                    <p class="font-display text-lg font-bold text-brand-900">
                        {{ $proximaTransmissao->translatedFormat('l, d \de F') }} às {{ $proximaTransmissao->format('H:i') }}h
                    </p>
                </div>
            </div>
            @if ($config?->youtube)
                <a target="_blank" rel="noopener" href="{{ $config->youtube }}" class="btn btn-primary shrink-0">
                    <i class="fab fa-youtube mr-2"></i> Ver canal
                </a>
            @endif
        </div>
    @endif

    {{-- ÚLTIMOS CULTOS --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="font-display text-2xl font-bold text-brand-900">Últimos cultos</h2>
        @if ($config?->youtube)
            <a target="_blank" rel="noopener" href="{{ $config->youtube }}"
                class="text-sm font-semibold text-brand-600 hover:text-brand-700">
                Ver canal <i class="fas fa-arrow-right ml-1"></i>
            </a>
        @endif
    </div>

    @if ($ultimosCultos->count())
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($ultimosCultos as $video)
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
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-600">
                            {{ $video->publish_at?->translatedFormat('d \de M \de Y') }}
                        </p>
                        <h3 class="font-display mt-2 line-clamp-2 text-base font-bold leading-snug text-brand-900">
                            {{ $video->title }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>

        @if ($ultimosCultos->hasMorePages())
            <div class="mt-10 text-center">
                <button wire:click="loadMore" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i> Carregar mais cultos
                </button>
            </div>
        @endif
    @else
        <div class="rounded-2xl border border-brand-100 bg-white p-12 text-center shadow-sm">
            <p class="font-display text-xl font-bold text-brand-900">Nenhum culto publicado ainda</p>
            <p class="mt-2 text-sm text-slate-500">Em breve você encontrará aqui os últimos cultos da igreja.</p>
        </div>
    @endif
</div>