<div>
    <form wire:submit="send" class="space-y-5">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="oracao-nome" class="mb-1.5 block text-sm font-semibold text-slate-800">Seu Nome *</label>
                <input type="text" id="oracao-nome" wire:model="name" class="input-site" placeholder="Nome completo">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="oracao-email" class="mb-1.5 block text-sm font-semibold text-slate-800">E-mail *</label>
                <input type="email" id="oracao-email" wire:model="email" class="input-site" placeholder="Seu melhor e-mail">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="oracao-phone" class="mb-1.5 block text-sm font-semibold text-slate-800">Telefone / WhatsApp</label>
            <input
                type="text"
                id="oracao-phone"
                wire:model="phone"
                x-data
                x-init="if (window.IMask && !$el._imask) { $el._imask = IMask($el, { mask: '(00) 00000-0000' }); }"
                class="input-site"
                placeholder="(00) 00000-0000"
                inputmode="tel"
            >
            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="oracao-message" class="mb-1.5 block text-sm font-semibold text-slate-800">Seu pedido de oração *</label>
            <textarea id="oracao-message" wire:model="message" rows="6" class="input-site resize-none" placeholder="Conte seu pedido..."></textarea>
            @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-start gap-3 text-sm text-slate-600">
            <input type="checkbox" wire:model="privacy" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
            <span>
                Autorizo a {{ optional($configuracoes)->app_name ?: 'Semear' }} a receber o meu pedido e, se necessário,
                colocá-lo na rede de oração. Li e aceito a
                <a href="{{ route('web.politica') }}" target="_blank" rel="noopener" class="text-sky-600 underline">Política de Privacidade</a>.
            </span>
        </label>
        @error('privacy') <p class="text-xs text-red-600">{{ $message }}</p> @enderror

        <button type="submit" wire:loading.attr="disabled" wire:target="send" class="btn-primary">
            <span wire:loading wire:target="send" class="hidden">Enviando...</span>
            <span wire:loading.remove wire:target="send">Enviar pedido</span>
        </button>
    </form>

    <div
        x-data="{ show: false }"
        x-on:pedido-enviado.window="show = true"
        x-cloak
        x-show="show"
        x-transition
        class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-sm text-green-800"
    >
        <p class="font-semibold">Pedido enviado com sucesso!</p>
        <p class="mt-1">Recebemos o seu pedido de oração. Estaremos intercedendo por você.</p>
    </div>
</div>
