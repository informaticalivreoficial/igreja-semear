<footer class="shrink-0 border-t border-slate-200 bg-white px-6 py-4 no-print">
    <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500">
        <p>
            © {{ date('Y') }} <strong class="text-forest-700">{{ env('APP_NAME') }}</strong>
            — Feito com ❤️ por
            <a href="{{ config('app.desenvolvedor_url') }}" target="_blank" class="font-medium text-forest-600 hover:underline">
                Informática Livre
            </a>
        </p>
        <p class="flex items-center gap-1.5">
            <i class="fas fa-seedling text-gold-500"></i>
            Painel Administrativo v1.0
        </p>
    </div>
</footer>
