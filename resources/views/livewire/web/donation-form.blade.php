<div>
    @section('title', 'Doações')

    {{-- Hero --}}
    <section class="page-hero py-14 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="breadcrumb-site mb-4">
                <a href="{{ route('web.home') }}" class="hover:text-accent-300">Início</a>
                <span class="mx-2 opacity-60">/</span>
                <span class="opacity-80">Doações</span>
            </nav>
            <h1 class="text-3xl font-bold text-white sm:text-4xl">Contribua com a Igreja Semear</h1>
            <p class="mt-3 max-w-2xl text-brand-100/90">
                Sua doação ajuda a manter os ministérios, projetos sociais e a obra de Deus.
                Escolha abaixo como deseja contribuir.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6 sm:py-14">
        {{-- Indicador de progresso --}}
        <div class="mb-8">
            <ol class="flex items-center gap-1 sm:gap-2">
                @php
                    $steps = [
                        1 => ['Motivo', 'fa-check'],
                        2 => ['Valor', 'fa-check'],
                        3 => ['Identificação', 'fa-check'],
                        4 => ['Pagamento', 'fa-check'],
                    ];
                @endphp
                @foreach ($steps as $num => [$label, $icon])
                    <li class="flex items-center gap-1 sm:gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold transition
                            {{ $step >= $num ? 'bg-brand-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $step > $num ? '✓' : $num }}
                        </span>
                        <span class="hidden text-xs font-medium sm:inline {{ $step >= $num ? 'text-brand-700' : 'text-slate-400' }}">
                            {{ $label }}
                        </span>
                        @if (! $loop->last)
                            <span class="h-px w-4 sm:w-8 {{ $step > $num ? 'bg-brand-500' : 'bg-slate-200' }}"></span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>

        @if ($paid)
            {{-- Sucesso --}}
            <div class="card-post rounded-2xl border-2 border-green-200 bg-green-50 p-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl text-green-600">✓</div>
                <h2 class="text-2xl font-bold text-green-800">Doação confirmada!</h2>
                <p class="mt-2 text-green-700">
                    Recebemos a sua contribuição de <strong>R$ {{ number_format($amount, 2, ',', '.') }}</strong>.
                    Muito obrigado por fazer parte dessa obra!
                </p>
                @if ($donation && $donation->uuid)
                    <p class="mt-3 text-xs text-green-600">Referência: <span class="font-mono">{{ $donation->uuid }}</span></p>
                @endif
                <button type="button" wire:click="restart" class="btn-primary mt-6">
                    Fazer outra doação
                </button>
            </div>
        @else
            @if ($errorMessage)
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <span class="mt-0.5 text-lg leading-none">⚠️</span>
                    <span>{{ $errorMessage }}</span>
                </div>
            @endif

            {{-- Passo 1: Motivo --}}
            <div x-show="$wire.step === 1" x-transition>
                <h2 class="mb-1 text-xl font-bold text-brand-900">Qual é o motivo da sua contribuição?</h2>
                <p class="mb-6 text-sm text-slate-500">Selecione a categoria da sua doação.</p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ($types as $key => $label)
                        <button type="button"
                            wire:click="selectType('{{ $key }}')"
                            wire:loading.attr="disabled"
                            class="group flex items-center gap-4 rounded-2xl border-2 bg-white p-5 text-left transition
                                   {{ $type === $key ? 'border-brand-600 bg-brand-50' : 'border-slate-200 hover:border-brand-300' }}">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-xl text-brand-700"
                                wire:loading.remove>
                                {!! $key === 'tithe' ? '⛪' : ($key === 'offering' ? '🤝' : ($key === 'donation' ? '❤️' : '✝️')) !!}
                            </span>
                            <span class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-100"
                                wire:loading>
                                <span class="h-5 w-5 animate-spin rounded-full border-2 border-brand-600 border-t-transparent"></span>
                            </span>
                            <span>
                                <span class="block font-semibold text-slate-800">{{ $label }}</span>
                                <span class="block text-xs text-slate-500">
                                    {{ $key === 'tithe' ? 'Os dízimos sustentam a obra.' : ($key === 'offering' ? 'Ofertas para projetos.' : ($key === 'donation' ? 'Doação livre.' : 'Outro destino.')) }}
                                </span>
                            </span>
                            @if ($type === $key)
                                <span class="ml-auto text-brand-600">●</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Passo 2: Valor --}}
            <div x-show="$wire.step === 2" x-transition>
                <h2 class="mb-1 text-xl font-bold text-brand-900">Quanto deseja contribuir?</h2>
                <p class="mb-6 text-sm text-slate-500">O valor será usado na sua {{ $types[$type] ?? 'doação' }}.</p>

                <div class="mb-6 grid grid-cols-3 gap-3 sm:grid-cols-5">
                    @foreach ([50, 100, 150, 250, 500] as $quick)
                        <button type="button"
                            wire:click="selectAmount('{{ number_format($quick, 2, ',', '.') }}')"
                            wire:loading.attr="disabled"
                            class="rounded-2xl border-2 bg-white py-4 text-sm font-semibold transition
                                   {{ $amount == $quick ? 'border-brand-600 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-600 hover:border-brand-300' }}">
                            R$ {{ $quick }}
                        </button>
                    @endforeach
                </div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">Outro valor</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg font-semibold text-slate-400">R$</span>
                    <input type="text"
                        inputmode="numeric"
                        wire:model="amountInput"
                        x-data="{}"
                        x-on:input="let n = parseInt($el.value.replace(/\D/g, '') || 0, 10); $el.value = n ? (n / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '';"
                        class="input-site block w-full rounded-xl border-2 border-slate-200 py-3.5 pl-12 pr-4 text-2xl font-bold text-brand-800 focus:border-brand-500 focus:outline-none"
                        placeholder="0,00">
                </div>

                <div class="mt-5">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Observação (opcional)</label>
                    <input type="text" wire:model="description" class="input-site" maxlength="255"
                        placeholder="Ex.: Viagem de missões, construção, etc.">
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="btn-secondary flex-1 sm:flex-none"
                        wire:loading.attr="disabled" wire:target="previousStep">
                        <span wire:loading.remove wire:target="previousStep">Voltar</span>
                        <span wire:loading wire:target="previousStep" class="inline-flex items-center gap-2">
                            <span class="h-4 w-4 animate-spin rounded-full border-2 border-brand-600 border-t-transparent"></span>
                            Aguarde...
                        </span>
                    </button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-[2] sm:flex-none sm:px-10"
                        wire:loading.attr="disabled" wire:target="nextStep">
                        <span wire:loading.remove wire:target="nextStep">Continuar</span>
                        <span wire:loading wire:target="nextStep" class="inline-flex items-center gap-2">
                            <span class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                            Aguarde...
                        </span>
                    </button>
                </div>
            </div>

            {{-- Passo 3: Identificação --}}
            <div x-show="$wire.step === 3" x-transition>
                <h2 class="mb-1 text-xl font-bold text-brand-900">Quem está contribuindo?</h2>
                <p class="mb-6 text-sm text-slate-500">Seus dados ficam seguros e são usados apenas para a sua doação.</p>

                <label class="mb-5 flex items-center justify-between rounded-2xl border-2 border-slate-200 bg-white p-4">
                    <span class="text-sm font-medium text-slate-700">Doar anonimamente</span>
                    <button type="button"
                        wire:click="$toggle('isAnonymous')"
                        class="relative h-6 w-11 rounded-full transition {{ $isAnonymous ? 'bg-brand-600' : 'bg-slate-300' }}">
                        <span class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition {{ $isAnonymous ? 'left-[22px]' : 'left-0.5' }}"></span>
                    </button>
                </label>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nome completo {{ $isAnonymous ? '(opcional)' : '*' }}</label>
                        <input type="text" wire:model="name" class="input-site" placeholder="Seu nome" {{ $isAnonymous ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">E-mail {{ $isAnonymous ? '(opcional)' : '*' }}</label>
                        <input type="email" wire:model="email" class="input-site" placeholder="voce@email.com" {{ $isAnonymous ? 'disabled' : '' }}>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">CPF <span class="font-normal text-slate-400">(opcional)</span></label>
                        <input type="text" wire:model="cpf" x-data x-init="if (window.IMask && !$el._imask) { $el._imask = IMask($el, { mask: '000.000.000-00' }); }" class="input-site" placeholder="000.000.000-00" maxlength="14" inputmode="numeric" {{ $isAnonymous ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="btn-secondary flex-1 sm:flex-none"
                        wire:loading.attr="disabled" wire:target="previousStep">
                        <span wire:loading.remove wire:target="previousStep">Voltar</span>
                        <span wire:loading wire:target="previousStep" class="inline-flex items-center gap-2">
                            <span class="h-4 w-4 animate-spin rounded-full border-2 border-brand-600 border-t-transparent"></span>
                            Aguarde...
                        </span>
                    </button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-[2] sm:flex-none sm:px-10"
                        wire:loading.attr="disabled" wire:target="nextStep">
                        <span wire:loading.remove wire:target="nextStep">Continuar</span>
                        <span wire:loading wire:target="nextStep" class="inline-flex items-center gap-2">
                            <span class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                            Aguarde...
                        </span>
                    </button>
                </div>
            </div>

            {{-- Passo 4: Pagamento --}}
            <div x-show="$wire.step === 4" x-transition>
                <h2 class="mb-1 text-xl font-bold text-brand-900">Pagamento</h2>
                <p class="mb-6 text-sm text-slate-500">
                    Valor: <strong class="text-brand-700">R$ {{ number_format($amount, 2, ',', '.') }}</strong>
                    @if ($types[$type] ?? null) · {{ $types[$type] }} @endif
                </p>

                {{-- Escolha do método --}}
                <div class="mb-8 grid grid-cols-2 gap-3">
                    <button type="button"
                        wire:click="selectPaymentMethod('pix')"
                        class="flex items-center justify-center gap-2 rounded-2xl border-2 bg-white py-4 text-sm font-semibold transition
                               {{ $paymentMethod === 'pix' ? 'border-brand-600 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                        PIX
                    </button>
                    <button type="button"
                        wire:click="selectPaymentMethod('card')"
                        class="flex items-center justify-center gap-2 rounded-2xl border-2 bg-white py-4 text-sm font-semibold transition
                               {{ $paymentMethod === 'card' ? 'border-brand-600 bg-brand-50 text-brand-700' : 'border-slate-200 text-slate-500 hover:border-brand-300' }}">
                        Cartão de crédito
                    </button>
                </div>

                @if ($paymentMethod === 'pix')
                    @if ($processing)
                        <div class="flex items-center justify-center rounded-2xl border border-brand-100 bg-brand-50 p-10">
                            <span class="text-brand-700">Gerando cobrança PIX...</span>
                        </div>
                    @elseif ($qrCodeImage)
                        <div class="mx-auto max-w-sm text-center">
                            <img src="{{ $qrCodeImage }}"
                                class="mx-auto rounded-2xl border-2 border-brand-100 bg-white p-3"
                                alt="QR Code PIX">
                            <p class="mt-4 text-sm font-medium text-slate-600">Escaneie o QR Code no app do seu banco</p>
                            <button type="button"
                                x-on:click="navigator.clipboard.writeText(@js($pixCopyPaste)); $el.textContent = 'Copiado!';"
                                class="btn-secondary mt-3 w-full">
                                Copiar código PIX
                            </button>
                            <p class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-400" wire:poll.4s="checkPayment">
                                <span class="h-2 w-2 animate-pulse rounded-full bg-accent-500"></span>
                                Aguardando pagamento...
                            </p>
                            <button type="button" wire:click="restart" class="mt-2 text-xs text-slate-400 underline">
                                Cancelar e voltar ao início
                            </button>
                        </div>
                    @else
                        <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">
                            <p>Para gerar o pagamento PIX, clique no botão abaixo.</p>
                            <button type="button" wire:click="createDonation" class="btn-primary mt-4"
                                wire:loading.attr="disabled" wire:target="createDonation">
                                <span wire:loading.remove wire:target="createDonation">Gerar pagamento PIX</span>
                                <span wire:loading wire:target="createDonation" class="inline-flex items-center gap-2">
                                    <span class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                                    Gerando...
                                </span>
                            </button>
                        </div>
                    @endif
                @else
                    {{-- Cartão --}}
                    @if ($donationId && ! $paid && ! $errorMessage)
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-8 text-center">
                            <p class="text-base font-semibold text-amber-800">Pagamento em processamento</p>
                            <p class="mt-2 text-sm text-amber-700">
                                Sua contribuição será confirmada assim que o pagamento for aprovado.
                            </p>
                            <button type="button" wire:click="restart" class="btn-secondary mt-4">
                                Fazer outra doação
                            </button>
                        </div>
                    @else
                    <div wire:ignore x-data x-effect="$wire.paymentMethod === 'card' && window.__initPbCard()">
                        <form id="pb-card-form" class="space-y-4" x-on:submit.prevent="window.__pbPayWithCard()">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Número do cartão</label>
                                <input type="text" id="pbCardNumber" inputmode="numeric" autocomplete="cc-number"
                                    placeholder="0000 0000 0000 0000"
                                    class="h-10 w-full rounded-xl border-2 border-slate-200 px-3 outline-none focus:border-brand-500">
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Mês</label>
                                    <input type="text" id="pbExpMonth" inputmode="numeric" maxlength="2"
                                        placeholder="MM" autocomplete="cc-exp-month"
                                        class="h-10 w-full rounded-xl border-2 border-slate-200 px-3 outline-none focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Ano</label>
                                    <input type="text" id="pbExpYear" inputmode="numeric" maxlength="4"
                                        placeholder="AAAA" autocomplete="cc-exp-year"
                                        class="h-10 w-full rounded-xl border-2 border-slate-200 px-3 outline-none focus:border-brand-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">CVV</label>
                                    <input type="text" id="pbSecurityCode" inputmode="numeric" maxlength="4"
                                        placeholder="123" autocomplete="cc-csc"
                                        class="h-10 w-full rounded-xl border-2 border-slate-200 px-3 outline-none focus:border-brand-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nome no cartão</label>
                                <input type="text" id="pbHolder" placeholder="Nome como está no cartão"
                                    autocomplete="cc-name"
                                    class="h-10 w-full rounded-xl border-2 border-slate-200 px-3 outline-none focus:border-brand-500">
                            </div>
                            <button type="submit" id="pb-card-submit"
                                class="w-full rounded-xl bg-brand-600 py-3 text-sm font-bold text-white transition hover:bg-brand-700">
                                Confirmar pagamento
                            </button>
                        </form>
                        <p class="mt-3 text-center text-xs text-slate-400">
                            Pagamento processado pelo PagBank com criptografia de ponta a ponta.
                        </p>
                    </div>
                    @endif
                @endif
            </div>
        @endif
    </section>

    <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>

    <script>
        window.__initPbCard = function () {
            if (!window.PagSeguro || !window.Livewire) return;
            window.__pbCardReady = true;
        };

        window.__pbPayWithCard = function () {
            const publicKey = @js(config('services.pagbank.public_key'));
            const componentId = @js($this->getId());

            if (!publicKey || !window.PagSeguro || !window.Livewire) return;

            const $wire = window.Livewire.find(componentId);
            if (! $wire) return;

            const btn = document.getElementById('pb-card-submit');
            if (btn) { btn.disabled = true; btn.textContent = 'Processando...'; }

            const card = PagSeguro.encryptCard({
                publicKey,
                holder: document.getElementById('pbHolder')?.value?.trim(),
                number: (document.getElementById('pbCardNumber')?.value || '').replace(/\D/g, ''),
                expMonth: document.getElementById('pbExpMonth')?.value?.trim(),
                expYear: document.getElementById('pbExpYear')?.value?.trim(),
                securityCode: document.getElementById('pbSecurityCode')?.value?.trim(),
            });

            if (card?.hasErrors || !card?.encryptedCard) {
                if (btn) { btn.disabled = false; btn.textContent = 'Confirmar pagamento'; }
                window.Livewire.find(componentId).dispatch('toast', {
                    message: 'Verifique os dados do cartão e tente novamente.',
                    type: 'error',
                });
                return;
            }

            window.Livewire.find(componentId).call('payWithCard', card.encryptedCard);
        };
    </script>
</div>