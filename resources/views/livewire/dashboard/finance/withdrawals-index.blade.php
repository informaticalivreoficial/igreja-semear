<div class="bg-slate-50 min-h-screen -m-4 p-4 lg:p-6" x-data="{
    showRejectModal: @entangle('showRejectModal'),
    showPayModal: @entangle('showPayModal'),
    showApproveConfirmModal: @entangle('showApproveConfirmModal'),
}">
    @section('title', $title)

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Saques</h1>
        <p class="text-sm text-slate-400 font-medium mt-0.5">Gerencie as solicitações de saque das operadoras</p>
    </div>

    {{-- FILTROS COM CONTADORES --}}
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <button wire:click="setFilter('requested')"
            class="px-4 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 {{ $statusFilter === 'requested' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
            Aguardando aprovação
            <span class="px-1.5 py-0.5 rounded-md text-xs {{ $statusFilter === 'requested' ? 'bg-white/20' : 'bg-amber-100 text-amber-700' }}">{{ $counts['requested'] }}</span>
        </button>
        <button wire:click="setFilter('approved')"
            class="px-4 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 {{ $statusFilter === 'approved' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
            Aprovados (a pagar)
            <span class="px-1.5 py-0.5 rounded-md text-xs {{ $statusFilter === 'approved' ? 'bg-white/20' : 'bg-indigo-100 text-indigo-700' }}">{{ $counts['approved'] }}</span>
        </button>
        <button wire:click="setFilter('paid')"
            class="px-4 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 {{ $statusFilter === 'paid' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
            Pagos
            <span class="px-1.5 py-0.5 rounded-md text-xs {{ $statusFilter === 'paid' ? 'bg-white/20' : 'bg-green-100 text-green-700' }}">{{ $counts['paid'] }}</span>
        </button>
        <button wire:click="setFilter('rejected')"
            class="px-4 py-2.5 rounded-xl text-sm font-bold transition-colors flex items-center gap-2 {{ $statusFilter === 'rejected' ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50' }}">
            Recusados
            <span class="px-1.5 py-0.5 rounded-md text-xs {{ $statusFilter === 'rejected' ? 'bg-white/20' : 'bg-red-100 text-red-700' }}">{{ $counts['rejected'] }}</span>
        </button>
    </div>

    {{-- LISTA --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        @forelse($withdrawals as $withdrawal)
            @php
                $holderDocument = preg_replace('/\D/', '', $withdrawal->bankAccount?->holder_document ?? '');
                $companyDocument = preg_replace('/\D/', '', $withdrawal->company->document_company ?? '');
                $responsableCpf = preg_replace('/\D/', '', $withdrawal->company->responsable_cpf ?? '');

                $documentMatches = $holderDocument && (
                    $holderDocument === $companyDocument || $holderDocument === $responsableCpf
                );

                $documentMismatch = $holderDocument && !$documentMatches;
            @endphp

            <div class="flex flex-col lg:flex-row lg:items-center gap-4 px-5 py-4 border-b border-slate-50 last:border-0">

                {{-- INFO --}}
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-sm text-slate-600 shrink-0">
                        {{ strtoupper(substr($withdrawal->company->alias_name ?? $withdrawal->company->social_name ?? '?', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ $withdrawal->company->alias_name ?? $withdrawal->company->social_name }}
                            </p>
                            @if($documentMismatch)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700 shrink-0"
                                    title="O titular da conta bancária não corresponde ao CNPJ da empresa nem ao CPF do responsável cadastrado">
                                    ⚠️ Titular diverge
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 truncate">
                            {{ $withdrawal->bankAccount?->label ?? 'Conta bancária não informada' }}
                        </p>
                        @if($withdrawal->bankAccount?->holder_name)
                            <p class="text-xs {{ $documentMismatch ? 'text-amber-600 font-semibold' : 'text-slate-400' }} truncate">
                                Titular: {{ $withdrawal->bankAccount->holder_name }}
                                @if($withdrawal->bankAccount->holder_document)
                                    · {{ $withdrawal->bankAccount->holder_document }}
                                @endif
                            </p>
                        @endif
                        <p class="text-xs text-slate-400 mt-0.5">
                            Solicitado {{ $withdrawal->requested_at?->diffForHumans() }}
                        </p>
                    </div>
                </div>

                {{-- VALOR + AÇÕES --}}
                <div class="flex items-center gap-6 shrink-0">
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900">R$ {{ number_format($withdrawal->net_amount, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-400">Líquido</p>
                    </div>

                    @if($withdrawal->status === \App\Enums\WithdrawalStatusEnum::REQUESTED)
                        <div class="flex items-center gap-2">
                            <button wire:click="openApprove({{ $withdrawal->id }})"
                                class="h-10 px-4 rounded-xl bg-green-50 text-green-700 text-xs font-bold hover:bg-green-100 transition-colors">
                                Aprovar
                            </button>
                            <button wire:click="openReject({{ $withdrawal->id }})"
                                class="h-10 px-4 rounded-xl bg-red-50 text-red-700 text-xs font-bold hover:bg-red-100 transition-colors">
                                Recusar
                            </button>
                        </div>
                    @elseif($withdrawal->status === \App\Enums\WithdrawalStatusEnum::APPROVED)
                        <button wire:click="openPay({{ $withdrawal->id }})"
                            class="h-10 px-4 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition-colors">
                            Marcar como pago
                        </button>
                    @elseif($withdrawal->status === \App\Enums\WithdrawalStatusEnum::PAID)
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            Pago {{ $withdrawal->paid_at?->format('d/m/Y') }}
                        </span>
                    @elseif($withdrawal->status === \App\Enums\WithdrawalStatusEnum::REJECTED)
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                            Recusado
                        </span>
                    @endif
                </div>

            </div>
        @empty
            <div class="text-center py-16 px-6">
                <p class="text-sm font-bold text-slate-600">Nenhum saque nessa categoria</p>
            </div>
        @endforelse
    </div>

    @if($withdrawals->hasPages())
        <div class="mt-5">{{ $withdrawals->links() }}</div>
    @endif

    {{-- MODAL: RECUSAR --}}
    <div x-show="showRejectModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(15,23,42,0.5);">
        <div @click.outside="showRejectModal = false" class="bg-white rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-lg font-black text-slate-900 mb-2">Recusar saque?</h3>
            <p class="text-sm text-slate-500 mb-4">
                O valor será devolvido automaticamente ao saldo disponível da operadora.
            </p>
            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Motivo (opcional)</label>
            <textarea wire:model="rejectReason" rows="3" placeholder="Ex: dados bancários inválidos"
                class="w-full rounded-xl border border-slate-200 text-sm p-3 outline-none mb-5 focus:border-red-400"></textarea>
            <div class="flex items-center gap-3">
                <button @click="showRejectModal = false" class="flex-1 h-11 rounded-xl bg-slate-100 text-slate-700 text-sm font-bold">Voltar</button>
                <button wire:click="confirmReject" wire:loading.attr="disabled"
                    class="flex-1 h-11 rounded-xl bg-red-600 text-white text-sm font-bold disabled:opacity-50">
                    <span wire:loading.remove wire:target="confirmReject">Confirmar recusa</span>
                    <span wire:loading wire:target="confirmReject">Recusando...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: PAGAR --}}
    <div x-show="showPayModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(15,23,42,0.5);">
        <div @click.outside="showPayModal = false" class="bg-white rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-lg font-black text-slate-900 mb-2">Marcar saque como pago</h3>
            <p class="text-sm text-slate-500 mb-4">
                Confirme que o PIX/TED foi realizado e informe o comprovante ou código da transação.
            </p>
            <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Comprovante / Código da transação</label>
            <input type="text" wire:model="paymentReference" placeholder="Ex: E12345678202601010101S00123456"
                class="w-full h-12 rounded-xl border border-slate-200 text-sm px-4 outline-none mb-1.5 focus:border-indigo-400">
            @error('paymentReference')
                <p class="text-xs text-red-600 mb-4">{{ $message }}</p>
            @enderror
            <div class="flex items-center gap-3 mt-5">
                <button @click="showPayModal = false" class="flex-1 h-11 rounded-xl bg-slate-100 text-slate-700 text-sm font-bold">Voltar</button>
                <button wire:click="confirmPay" wire:loading.attr="disabled"
                    class="flex-1 h-11 rounded-xl bg-indigo-600 text-white text-sm font-bold disabled:opacity-50">
                    <span wire:loading.remove wire:target="confirmPay">Confirmar pagamento</span>
                    <span wire:loading wire:target="confirmPay">Salvando...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: CONFIRMAR APROVAÇÃO COM DIVERGÊNCIA --}}
    <div x-show="showApproveConfirmModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(15,23,42,0.5);">
        <div @click.outside="showApproveConfirmModal = false" class="bg-white rounded-2xl p-6 w-full max-w-md">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                    <span class="text-xl">⚠️</span>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900">Titular da conta diverge</h3>
                    <p class="text-xs text-slate-400">Confirme antes de aprovar</p>
                </div>
            </div>

            @if($selectedWithdrawal?->bankAccount)
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 mb-4 text-xs text-slate-600 space-y-1">
                    <p><span class="font-bold">Titular da conta:</span> {{ $selectedWithdrawal->bankAccount->holder_name }} ({{ $selectedWithdrawal->bankAccount->holder_document ?: 'sem documento' }})</p>
                    <p><span class="font-bold">Empresa:</span> {{ $selectedWithdrawal->company->alias_name ?? $selectedWithdrawal->company->social_name }} ({{ $selectedWithdrawal->company->document_company ?? 'sem CNPJ' }})</p>
                </div>
            @endif

            <p class="text-sm text-slate-500 mb-5">
                O documento do titular da conta bancária não corresponde ao CNPJ da empresa nem ao CPF do responsável cadastrado. Verifique manualmente antes de prosseguir — aprovar por engano pode enviar o valor para a conta errada.
            </p>

            <div class="flex items-center gap-3">
                <button @click="showApproveConfirmModal = false" class="flex-1 h-11 rounded-xl bg-slate-100 text-slate-700 text-sm font-bold">
                    Cancelar
                </button>
                <button wire:click="confirmApproveAnyway" wire:loading.attr="disabled"
                    class="flex-1 h-11 rounded-xl bg-amber-600 text-white text-sm font-bold disabled:opacity-50">
                    <span wire:loading.remove wire:target="confirmApproveAnyway">Aprovar mesmo assim</span>
                    <span wire:loading wire:target="confirmApproveAnyway">Aprovando...</span>
                </button>
            </div>
        </div>
    </div>

</div>