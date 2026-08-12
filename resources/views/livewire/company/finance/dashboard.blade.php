<div class="max-w-7xl mx-auto space-y-8">

    {{-- CARDS DE SALDO --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-4">

        {{-- Disponível --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Disponível</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10zm-1-7l-3-3 1.41-1.41L11 12.17l5.59-5.58L18 8l-7 7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #23c55e;">
                R$ {{ number_format($data['available_balance'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">Pronto para saque</p>
        </div>

        {{-- Pendente --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Pendente</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(245,158,11,0.1);">
                    <svg class="w-5 h-5" style="color: #d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #d97706;">
                R$ {{ number_format($data['pending_balance'], 2, ',', '.') }}
            </p>
            @if($data['next_release'])
                <p class="text-xs mt-1" style="color: #c5bfb2;">
                    Lançamento {{ $data['next_release']->available_at->diffForHumans() }}
                </p>
            @else
                <p class="text-xs mt-1" style="color: #c5bfb2;">Aguardando liberação</p>
            @endif
        </div>

        {{-- Total vendas --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Total vendas</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #051e34;">
                R$ {{ number_format($data['total_sales'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">
                Taxa: R$ {{ number_format($data['total_commission'], 2, ',', '.') }}
            </p>
        </div>

        {{-- Total sacado --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Total sacado</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(99,102,241,0.1);">
                    <svg class="w-5 h-5" style="color: #6366f1;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12l7 7 7-7"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #051e34;">
                R$ {{ number_format($data['total_withdrawn'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">Valores transferidos</p>
        </div>

        {{-- Cancelado --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Cancelado</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                    style="background: rgba(239,68,68,0.1);">
                    <svg class="w-5 h-5" style="color: #dc2626;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M15 9l-6 6M9 9l6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #dc2626;">
                R$ {{ number_format($data['cancelled_balance'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">Reservas estornadas</p>
        </div>

    </div>

    {{-- BOTÃO SAQUE --}}
    @if($data['available_balance'] > 0)
        <div class="bg-white rounded-3xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
             style="border: 1px solid #e8e4d8;">
            <div>
                <h3 class="font-extrabold text-base" style="color: #051e34;">Solicitar saque</h3>
                <p class="text-sm mt-1" style="color: #87c2c0;">
                    Você tem <strong style="color: #23c55e;">R$ {{ number_format($data['available_balance'], 2, ',', '.') }}</strong> disponível para saque.
                </p>
            </div>
            <button
                wire:click="$set('showWithdrawalModal', true)"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-bold transition shrink-0"
                style="background: #23c55e; color: white;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12l7 7 7-7"/>
                </svg>
                Solicitar saque
            </button>
        </div>
    @endif

    {{-- EXTRATO --}}
    <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8e4d8;">

        <div class="px-6 py-4" style="border-bottom: 1px solid #f5f2ec;">
            <h3 class="font-extrabold text-base" style="color: #051e34;">Extrato</h3>
        </div>

        @if($transactions->isEmpty())
            <div class="p-12 text-center">
                <p class="text-sm" style="color: #87c2c0;">Nenhuma transação encontrada.</p>
            </div>
        @else
            <div class="divide-y" style="border-color: #f5f2ec;">
                @foreach($transactions as $transaction)
                    @php
                        $isWithdrawal = $transaction->type->value === 'withdrawal';
                        $isAvailable  = $transaction->status->value === 'available';
                        $isPending    = $transaction->status->value === 'pending';
                        $isPaid       = $transaction->status->value === 'paid';

                        $statusLabel = match($transaction->status->value) {
                            'pending'   => 'Pendente',
                            'available' => 'Disponível',
                            'paid'      => 'Pago',
                            'cancelled' => 'Cancelado',
                            default     => $transaction->status->value,
                        };

                        $statusColor = match($transaction->status->value) {
                            'pending'   => ['bg' => 'rgba(245,158,11,0.1)',  'color' => '#d97706'],
                            'available' => ['bg' => 'rgba(35,197,94,0.1)',   'color' => '#15803d'],
                            'paid'      => ['bg' => 'rgba(99,102,241,0.1)',  'color' => '#6366f1'],
                            'cancelled' => ['bg' => 'rgba(239,68,68,0.1)',   'color' => '#dc2626'],
                            default     => ['bg' => 'rgba(0,0,0,0.05)',      'color' => '#64748b'],
                        };
                    @endphp

                    <div class="px-6 py-4 flex items-center gap-4">

                        {{-- Ícone tipo --}}
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                             style="background: {{ $isWithdrawal ? 'rgba(239,68,68,0.08)' : 'rgba(35,197,94,0.08)' }};">
                            @if($isWithdrawal)
                                <svg class="w-5 h-5" style="color: #dc2626;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 5v14M5 12l7 7 7-7"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 19V5M5 12l7-7 7 7"/>
                                </svg>
                            @endif
                        </div>

                        {{-- Descrição --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate" style="color: #051e34;">
                                {{ $transaction->description }}
                            </p>
                            <p class="text-xs mt-0.5" style="color: #c5bfb2;">
                                {{ $transaction->created_at->format('d/m/Y \à\s H:i') }}
                                @if($isPending && $transaction->available_at)
                                    · Lançado {{ $transaction->available_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>

                        {{-- Status --}}
                        <span class="px-3 py-1 rounded-full text-xs font-bold shrink-0"
                              style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['color'] }};">
                            {{ $statusLabel }}
                        </span>

                        {{-- Valor --}}
                        <div class="text-right shrink-0">
                            <p class="text-sm font-extrabold"
                               style="color: {{ $isWithdrawal ? '#dc2626' : '#23c55e' }};">
                                {{ $isWithdrawal ? '-' : '+' }}R$ {{ number_format(abs($transaction->net_amount), 2, ',', '.') }}
                            </p>
                            @if(!$isWithdrawal && $transaction->fee_amount > 0)
                                <p class="text-xs" style="color: #c5bfb2;">
                                    Taxa: R$ {{ number_format($transaction->fee_amount, 2, ',', '.') }}
                                </p>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="px-6 py-4" style="border-top: 1px solid #f5f2ec;">
                {{ $transactions->links() }}
            </div>
        @endif

    </div>

    {{-- MODAL SAQUE --}}
    @if($showWithdrawalModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
             style="background: rgba(0,0,0,0.5);"
             wire:click.self="$set('showWithdrawalModal', false)">

            <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-extrabold text-lg" style="color: #051e34;">Solicitar saque</h3>
                    <button wire:click="$set('showWithdrawalModal', false)"
                            class="w-8 h-8 rounded-xl flex items-center justify-center transition hover:bg-gray-100"
                            style="color: #87c2c0;">✕</button>
                </div>

                <div class="mb-4 p-4 rounded-2xl" style="background: rgba(35,197,94,0.06); border: 1px solid rgba(35,197,94,0.2);">
                    <p class="text-sm" style="color: #87c2c0;">Saldo disponível</p>
                    <p class="text-2xl font-extrabold" style="color: #23c55e;">
                        R$ {{ number_format($data['available_balance'], 2, ',', '.') }}
                    </p>
                </div>

                {{-- Conta bancária --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-3" style="color:#051e34;">
                        Conta para recebimento
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        @forelse($this->getCompany()->bankAccounts as $account)

                            <button
                                type="button"
                                wire:click="$set('bankAccountId', {{ $account->id }})"
                                class="relative w-full text-left rounded-2xl p-3 transition-all duration-200"
                                style="
                                    border:2px solid {{ $bankAccountId == $account->id ? '#23c55e' : '#e8e4d8' }};
                                    background: {{ $bankAccountId == $account->id ? 'rgba(35,197,94,.06)' : '#fff' }};
                                "
                            >

                                @if($bankAccountId == $account->id)
                                    <div
                                        class="absolute top-2 right-2 w-5 h-5 rounded-full flex items-center justify-center"
                                        style="background:#23c55e;color:white;"
                                    >
                                        <i class="fas fa-check text-[10px]"></i>
                                    </div>
                                @endif

                                <div class="font-semibold text-sm truncate" style="color:#051e34;">
                                    {{ $account->type === 'pix' ? 'PIX' : $account->bank_name }}
                                </div>

                                <div class="text-xs mt-1 truncate" style="color:#87c2c0;">
                                    {{ $account->label }}
                                </div>

                                <div class="text-[11px] mt-2 text-gray-500 truncate">
                                    {{ $account->holder_name }}
                                </div>

                            </button>

                        @empty

                            <div
                                class="rounded-2xl p-4 text-center"
                                style="border:2px dashed #e8e4d8;color:#87c2c0;"
                            >
                                Nenhuma conta bancária cadastrada.
                            </div>

                        @endforelse

                    </div>

                    @error('bankAccountId')
                        <p class="text-xs mt-2 text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6"
                    x-data="{
                        display: '',
                        format(digits) {
                            digits = digits.replace(/\D/g, '');
                            if (!digits) digits = '0';
                            let num = (parseInt(digits, 10) / 100).toFixed(2);
                            let [int, dec] = num.split('.');
                            int = int.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            return 'R$ ' + int + ',' + dec;
                        },
                        onInput(e) {
                            let digits = e.target.value.replace(/\D/g, '');
                            this.display = this.format(digits);
                            $wire.set('withdrawalAmount', parseInt(digits || '0', 10) / 100);
                        }
                    }"
                >
                    <label class="block text-sm font-semibold mb-2" style="color: #051e34;">
                        Valor do saque
                    </label>
                    <input
                        type="text"
                        inputmode="numeric"
                        x-model="display"
                        @input="onInput($event)"
                        placeholder="R$ 0,00"
                        class="w-full h-12 px-4 rounded-2xl text-sm outline-none transition"
                        style="border: 1.5px solid #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onblur="this.style.borderColor='#e8e4d8'"
                    >
                    @error('withdrawalAmount')
                        <p class="text-xs mt-1.5" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button wire:click="$set('showWithdrawalModal', false)"
                            class="flex-1 h-12 rounded-2xl text-sm font-bold transition"
                            style="border: 1.5px solid #e8e4d8; color: #87c2c0;">
                        Cancelar
                    </button>
                    <button wire:click="requestWithdrawal"
                            wire:loading.attr="disabled"
                            class="flex-1 h-12 rounded-2xl text-sm font-bold transition"
                            style="background: #23c55e; color: white;">
                        <span wire:loading.remove wire:target="requestWithdrawal">Confirmar saque</span>
                        <span wire:loading wire:target="requestWithdrawal">Processando...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>