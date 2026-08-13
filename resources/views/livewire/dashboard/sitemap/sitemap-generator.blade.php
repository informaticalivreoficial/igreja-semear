<div>
    @section('title', 'Sitemap')

    <div class="content-header">
        <h1><i class="fas fa-sitemap"></i> Sitemap</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                        <i class="fas fa-link"></i>
                    </span>
                    <div>
                        <span class="block text-xs uppercase tracking-wide text-slate-400">Total de URLs</span>
                        <span class="block text-2xl font-bold text-slate-800">{{ $totalUrls }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                        <i class="fas fa-clock"></i>
                    </span>
                    <div>
                        <span class="block text-xs uppercase tracking-wide text-slate-400">Última Geração</span>
                        <span class="block text-2xl font-bold text-slate-800">{{ $lastGenerated ?? 'Nunca gerado' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <button wire:click="generate" class="btn btn-primary btn-lg">
                    <i class="fas fa-sync-alt mr-2"></i> Gerar Sitemap Agora
                </button>

                @if ($lastGenerated)
                    <a href="{{ asset('sitemap.xml') }}" target="_blank" class="btn btn-success btn-lg">
                        <i class="fas fa-eye mr-2"></i> Visualizar Sitemap
                    </a>
                @endif
            </div>

            <div class="alert alert-info mt-6">
                <h5><i class="fas fa-info"></i> Informações</h5>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    <li>O sitemap é salvo em: <code class="text-lime-700">{{ public_path('sitemap.xml') }}</code></li>
                    <li>Adicione no Google Search Console: <code class="text-lime-700">{{ url('sitemap.xml') }}</code></li>
                    <li>Configure para gerar automaticamente via cron job</li>
                </ul>
            </div>
        </div>
    </div>
</div>
