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
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" x-data x-cloak x-show="true">
                    {{ $errorMessage }}
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
                            class="group flex items-center gap-4 rounded-2xl border-2 bg-white p-5 text-left transition
                                   {{ $type === $key ? 'border-brand-600 bg-brand-50' : 'border-slate-200 hover:border-brand-300' }}">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-xl text-brand-700">
                                {!! $key === 'tithe' ? '⛪' : ($key === 'offering' ? '🤝' : ($key === 'donation' ? '❤️' : '✝️')) !!}
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
                    <button type="button" wire:click="previousStep" class="btn-secondary flex-1 sm:flex-none">
                        Voltar
                    </button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-[2] sm:flex-none sm:px-10">
                        Continuar
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
                    <button type="button" wire:click="previousStep" class="btn-secondary flex-1 sm:flex-none">
                        Voltar
                    </button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-[2] sm:flex-none sm:px-10">
                        Continuar
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
                    @elseif ($qrCodeBase64)
                        <div class="mx-auto max-w-sm text-center">
                            <img src="data:image/png;base64,{{ $qrCodeBase64 }}"
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
                            <button type="button" wire:click="createDonation" class="btn-primary mt-4">
                                Gerar pagamento PIX
                            </button>
                        </div>
                    @endif
                @else
                    {{-- Cartão --}}
                    <div wire:ignore x-data x-init="window.__initMpCard()">
                        <div id="mp-card-form" class="space-y-4"></div>
                        <p class="mt-3 text-center text-xs text-slate-400">
                            Pagamento processado pelo Mercado Pago com criptografia de ponta a ponta.
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </section>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        window.__initMpCard = function () {
            const publicKey = @js(config('services.mercadopago.public_key'));
            const amount = @js($amount);
            const componentId = @js($this->getId());

            if (!publicKey || !window.MercadoPago || !window.Livewire) return;

            const mp = new MercadoPago(publicKey);

            const cardForm = mp.cardForm({
                amount: amount,
                autoMount: true,
                form: {
                    id: 'mp-card-form',
                    cardholderName: { placeholder: 'Nome impresso no cartão', fieldStyle: { 'font-size': '15px' } },
                    cardNumber: { placeholder: 'Número do cartão' },
                    expirationDate: { placeholder: 'MM/AA' },
                    securityCode: { placeholder: 'CVC' },
                    installments: { placeholder: 'Parcelas' },
                    identificationType: {},
                    identificationNumber: {},
                },
                callbacks: {
                    onFormMounted: () => {},
                    onSubmit: () => { cardForm.createCardToken(); },
                    onFetching: () => {},
                    onError: (error) => {
                        window.Livewire.find(componentId).dispatch('toast', {
                            message: 'Erro no cartão: ' + (error?.message || 'tente novamente'),
                            type: 'error',
                        });
                    },
                    onTokenized: (data) => {
                        window.Livewire.find(componentId).call('payWithCard', data.token);
                    },
                },
            });
        };
    </script>
</div>