<div class="max-w-6xl mx-auto space-y-6">    

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- COLUNA ESQUERDA --}}
        <div class="lg:col-span-5 space-y-5">

            {{-- SALDO --}}
            <div class="rounded-3xl p-6 text-white" style="background: linear-gradient(135deg, #051e34 0%, #0a3358 100%);">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest" style="color: #87c2c0;">Saldo Disponível</span>
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.08);">
                        <svg class="w-5 h-5" style="color: #fadd37;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-base font-semibold" style="color: #87c2c0;">R$</span>
                    <span class="text-4xl font-extrabold text-white">{{ number_format($balance, 2, ',', '.') }}</span>
                </div>
                <p class="text-xs mt-2" style="color: #87c2c0;">Valor disponível para saque imediato</p>
            </div>

            {{-- FORMULÁRIO --}}
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">

                <h3 class="font-extrabold text-base mb-5 flex items-center gap-2" style="color: #051e34;">
                    Nova Solicitação
                    <div wire:loading wire:target="requestWithdrawal">
                        <svg class="animate-spin h-4 w-4" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                    </div>
                </h3>

                <form wire:submit.prevent="requestWithdrawal" class="space-y-5">

                    {{-- CONTA DE DESTINO --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest mb-3" style="color: #87c2c0;">
                            Conta de Destino
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @forelse($bankAccounts as $account)
                                <label
                                    wire:click="$set('selectedAccountId', {{ $account->id }})"
                                    class="relative cursor-pointer rounded-2xl p-3 transition-all"
                                    style="
                                        border:2px solid {{ $selectedAccountId == $account->id ? '#23c55e' : '#e8e4d8' }};
                                        background:{{ $selectedAccountId == $account->id ? 'rgba(35,197,94,.05)' : '#fff' }};
                                    "
                                >

                                    @if($selectedAccountId == $account->id)
                                        <div
                                            class="absolute top-2 right-2 w-5 h-5 rounded-full flex items-center justify-center"
                                            style="background:#23c55e;color:white;"
                                        >
                                            <i class="fas fa-check text-[10px]"></i>
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-2 mb-2">

                                        <div
                                            class="w-8 h-8 rounded-xl flex items-center justify-center"
                                            style="background:{{ $account->type === 'pix'
                                                ? 'rgba(35,197,94,.1)'
                                                : 'rgba(22,163,183,.1)' }}"
                                        >

                                            @if($account->type === 'pix')
                                                <i class="fa-solid fa-bolt text-sm" style="color:#23c55e;"></i>
                                            @else
                                                <i class="fa-solid fa-building-columns text-sm" style="color:#16a3b7;"></i>
                                            @endif

                                        </div>

                                        <div class="min-w-0">
                                            <div class="font-bold text-xs truncate" style="color:#051e34;">
                                                {{ $account->type === 'pix' ? 'PIX' : $account->bank_name }}
                                            </div>

                                            @if($account->is_default)
                                                <span
                                                    class="text-[10px] font-bold"
                                                    style="color:#16a34a;"
                                                >
                                                    Principal
                                                </span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="text-[11px] truncate" style="color:#87c2c0;">
                                        {{ $account->label }}
                                    </div>

                                    <div class="text-[11px] truncate mt-1 text-gray-500">
                                        {{ $account->holder_name }}
                                    </div>

                                </label>
                            @empty
                                <div class="p-4 rounded-2xl text-center" style="border: 2px dashed #e8e4d8;">
                                    <p class="text-xs mb-2" style="color: #87c2c0;">Nenhuma conta cadastrada.</p>
                                    <a href="{{ route('company.finance.banks') }}"
                                       class="text-xs font-bold" style="color: #16a3b7;">
                                        Cadastrar conta
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        @error('selectedAccountId')
                            <p class="text-xs mt-1.5 font-semibold" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- VALOR --}}
                    <div 
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
                                $wire.set('amount', parseInt(digits || '0', 10) / 100);
                            }
                    }">
                        <label class="block text-xs font-bold uppercase tracking-widest mb-2" style="color: #87c2c0;">
                            Valor do saque
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold" style="color: #87c2c0;">R$</span>
                            <input
                                type="text"
                                inputmode="numeric"
                                x-model="display"
                                @input="onInput($event)"
                                placeholder="0,00"
                                class="w-full h-12 pl-12 pr-4 rounded-2xl text-sm font-bold outline-none transition"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;"
                                onfocus="this.style.borderColor='#16a3b7'"
                                onblur="this.style.borderColor='#e8e4d8'"
                            >
                        </div>
                        @error('amount')
                            <p class="text-xs mt-1.5 font-semibold" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>                    

                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full h-12 rounded-2xl text-sm font-bold transition"
                        style="background: #051e34; color: white;">
                        <span wire:loading.remove wire:target="requestWithdrawal">Confirmar Solicitação</span>
                        <span wire:loading wire:target="requestWithdrawal">Processando...</span>
                    </button>

                </form>

                @if($successMsg)
                    <div class="mt-4 p-4 rounded-2xl flex items-center gap-2 text-sm font-semibold"
                         style="background: rgba(35,197,94,0.08); color: #15803d;">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $successMsg }}
                    </div>
                @endif

            </div>
        </div>

        {{-- COLUNA DIREITA --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8e4d8;">

                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom: 1px solid #f5f2ec;">
                    <h3 class="font-extrabold text-base" style="color: #051e34;">Histórico de Saques</h3>
                    <span class="text-xs font-bold uppercase tracking-widest" style="color: #c5bfb2;">Últimos registros</span>
                </div>

                @if($withdrawals->isEmpty())
                    <div class="p-16 text-center">
                        <div class="w-16 h-16 mx-auto rounded-3xl flex items-center justify-center mb-4"
                             style="background: rgba(22,163,183,0.08);">
                            <svg class="w-8 h-8" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12l7 7 7-7"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold" style="color: #87c2c0;">Nenhum saque solicitado ainda.</p>
                    </div>
                @else
                    <div class="divide-y" style="border-color: #f5f2ec;">
                        @foreach($withdrawals as $withdrawal)
                            @php
                                $statusLabel = $withdrawal->status->label();
                                $statusHex = $withdrawal->status->color();
                            @endphp
                            <div class="px-6 py-5">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-lg font-extrabold" style="color:#051e34;">
                                            R$ {{ number_format($withdrawal->amount,2,',','.') }}
                                        </div>
                                        @if($withdrawal->fee > 0)
                                            <div class="text-xs mt-1 text-gray-500">
                                                Taxa:
                                                R$ {{ number_format($withdrawal->fee,2,',','.') }}
                                            </div>
                                            <div class="text-xs text-green-600 font-semibold">
                                                Líquido:
                                                R$ {{ number_format($withdrawal->net_amount,2,',','.') }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                        style="background: {{ $statusHex }}1a; color: {{ $statusHex }};">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <div class="text-gray-400">
                                            Solicitado
                                        </div>
                                        <div style="color:#051e34;">
                                            {{ optional($withdrawal->requested_at)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    @if($withdrawal->approved_at)
                                        <div>
                                            <div class="text-gray-400">
                                                Aprovado
                                            </div>
                                            <div style="color:#051e34;">
                                                {{ $withdrawal->approved_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    @endif
                                    @if($withdrawal->paid_at)
                                        <div>
                                            <div class="text-gray-400">
                                                Pago
                                            </div>
                                            <div style="color:#051e34;">
                                                {{ $withdrawal->paid_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($withdrawal->bankAccount)
                                    <div class="mt-4 text-xs">
                                        <span class="font-semibold" style="color:#87c2c0;">
                                            Conta:
                                        </span>
                                        {{ $withdrawal->bankAccount->label }}
                                    </div>
                                @endif
                                @if($withdrawal->payment_reference)
                                    <div class="mt-2 text-xs break-all">
                                        <span class="font-semibold" style="color:#87c2c0;">
                                            Referência:
                                        </span>
                                        {{ $withdrawal->payment_reference }}
                                    </div>
                                @endif
                                @if($withdrawal->notes)
                                    <div
                                        class="mt-4 p-3 rounded-xl text-xs"
                                        style="background:#f8fafc;"
                                    >
                                        {{ $withdrawal->notes }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($withdrawals->hasPages())
                        <div class="px-6 py-4" style="border-top: 1px solid #f5f2ec;">
                            {{ $withdrawals->links() }}
                        </div>
                    @endif
                @endif

            </div>
        </div>

    </div>

</div>