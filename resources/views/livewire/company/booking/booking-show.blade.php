<div class="max-w-6xl mx-auto" x-data="{ confirmingCancel: @entangle('confirmingCancel') }">

    @php
        $statusColors = [
            'PENDING'   => ['bg' => 'rgba(245,158,11,0.1)',  'color' => '#d97706'],
            'CONFIRMED' => ['bg' => 'rgba(35,197,94,0.1)',   'color' => '#15803d'],
            'CANCELLED' => ['bg' => 'rgba(239,68,68,0.1)',   'color' => '#dc2626'],
            'COMPLETED' => ['bg' => 'rgba(99,102,241,0.1)',  'color' => '#6366f1'],
        ];
        $paymentColors = [
            'PENDING'   => ['bg' => 'rgba(245,158,11,0.1)',  'color' => '#d97706'],
            'PAID'      => ['bg' => 'rgba(35,197,94,0.1)',   'color' => '#15803d'],
            'REFUSED'   => ['bg' => 'rgba(239,68,68,0.1)',   'color' => '#dc2626'],
            'REFUNDED'  => ['bg' => 'rgba(99,102,241,0.1)',  'color' => '#6366f1'],
            'EXPIRED'   => ['bg' => 'rgba(239,68,68,0.1)',   'color' => '#dc2626'],
        ];
        $statusLabels = [
            'PENDING'   => 'Pendente',
            'CONFIRMED' => 'Confirmado',
            'CANCELLED' => 'Cancelado',
            'COMPLETED' => 'Concluído',
        ];
        $paymentLabels = [
            'PENDING'  => 'Aguardando',
            'PAID'     => 'Pago',
            'REFUSED'  => 'Recusado',
            'REFUNDED' => 'Reembolsado',
            'EXPIRED'  => 'Expirado',
        ];
        $s  = $booking->status->value ?? 'PENDING';
        $ps = $booking->payment_status->value ?? 'PENDING';
    @endphp

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('company.bookings.index') }}"
           class="h-10 w-10 rounded-xl flex items-center justify-center transition shrink-0"
           style="background: rgba(22,163,183,0.08); color: #16a3b7;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-extrabold" style="color: #051e34;">
                Reserva #{{ strtoupper(substr($booking->uuid, 0, 8)) }}
            </h1>
            <p class="text-xs" style="color: #87c2c0;">
                Criada em {{ $booking->created_at->format('d/m/Y \à\s H:i') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- COLUNA PRINCIPAL --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- CLIENTE --}}
            <div class="bg-white rounded-3xl p-5" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-4" style="color: #87c2c0;">Cliente</h2>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 font-extrabold text-base"
                         style="background: rgba(22,163,183,0.1); color: #16a3b7;">
                        {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-extrabold text-sm" style="color: #051e34;">{{ $booking->customer_name }}</p>
                        <p class="text-xs" style="color: #87c2c0;">{{ $booking->customer_email }}</p>
                    </div>
                </div>
                @if($booking->customer_phone ?? null)
                    <div class="mt-4 pt-4 flex items-center gap-2 text-sm" style="border-top: 1px solid #f5f2ec; color: #051e34;">
                        <svg class="w-4 h-4" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $booking->customer_phone }}
                    </div>
                @endif
            </div>

            {{-- PASSEIO --}}
            <div class="bg-white rounded-3xl p-5" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-4" style="color: #87c2c0;">Passeio</h2>
                <p class="font-extrabold text-base mb-3" style="color: #051e34;">{{ $booking->tour?->title }}</p>
                <div class="flex flex-wrap items-center gap-2">
                    @if($booking->tourDate)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                              style="background: rgba(99,102,241,0.08); color: #6366f1;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ $booking->tourDate->date->format('d/m/Y') }} · {{ substr($booking->tourDate->start_time, 0, 5) }}
                        </span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                          style="background: rgba(245,158,11,0.08); color: #d97706;">
                        {{ $booking->adults }} adulto(s)
                        @if($booking->children > 0) · {{ $booking->children }} criança(s) @endif
                    </span>
                </div>
            </div>

            {{-- HISTÓRICO --}}
            <div class="bg-white rounded-3xl p-5" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-4" style="color: #87c2c0;">Histórico</h2>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-2 h-2 rounded-full mt-1.5 shrink-0" style="background: #16a3b7;"></div>
                        <div>
                            <p class="text-sm font-semibold" style="color: #051e34;">Reserva criada</p>
                            <p class="text-xs" style="color: #87c2c0;">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($booking->paid_at)
                        <div class="flex gap-3">
                            <div class="w-2 h-2 rounded-full mt-1.5 shrink-0" style="background: #15803d;"></div>
                            <div>
                                <p class="text-sm font-semibold" style="color: #051e34;">Pagamento confirmado</p>
                                <p class="text-xs" style="color: #87c2c0;">{{ \Carbon\Carbon::parse($booking->paid_at)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($booking->cancelled_at)
                        <div class="flex gap-3">
                            <div class="w-2 h-2 rounded-full mt-1.5 shrink-0" style="background: #dc2626;"></div>
                            <div>
                                <p class="text-sm font-semibold" style="color: #051e34;">Reserva cancelada</p>
                                <p class="text-xs" style="color: #87c2c0;">{{ \Carbon\Carbon::parse($booking->cancelled_at)->format('d/m/Y H:i') }}</p>
                                @if($booking->cancellation_reason)
                                    <p class="text-xs mt-1" style="color: #87c2c0;">Motivo: {{ $booking->cancellation_reason }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-5">

            {{-- STATUS --}}
            <div class="bg-white rounded-3xl p-5" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-4" style="color: #87c2c0;">Status</h2>
                <div class="flex flex-col gap-2">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold text-center"
                          style="background: {{ $statusColors[$s]['bg'] }}; color: {{ $statusColors[$s]['color'] }};">
                        {{ $statusLabels[$s] }}
                    </span>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold text-center"
                          style="background: {{ $paymentColors[$ps]['bg'] }}; color: {{ $paymentColors[$ps]['color'] }};">
                        {{ $paymentLabels[$ps] }}
                    </span>
                </div>
            </div>

            {{-- FINANCEIRO --}}
            <div class="bg-white rounded-3xl p-5" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-4" style="color: #87c2c0;">Financeiro</h2>
                <div class="space-y-2.5 text-sm">
                    <div class="flex items-center justify-between">
                        <span style="color: #87c2c0;">Valor bruto</span>
                        <span class="font-bold" style="color: #051e34;">R$ {{ number_format($booking->total, 2, ',', '.') }}</span>
                    </div>
                    @if($booking->walletTransaction)
                        <div class="flex items-center justify-between">
                            <span style="color: #87c2c0;">Comissão ({{ $booking->walletTransaction->fee_percentage }}%)</span>
                            <span class="font-bold" style="color: #dc2626;">- R$ {{ number_format($booking->walletTransaction->fee_amount, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-2.5" style="border-top: 1px solid #f5f2ec;">
                            <span class="font-bold" style="color: #051e34;">Você recebe</span>
                            <span class="font-extrabold text-base" style="color: #23c55e;">R$ {{ number_format($booking->walletTransaction->net_amount, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="pt-2.5" style="border-top: 1px solid #f5f2ec;">
                        <span class="text-xs" style="color: #87c2c0;">
                            Pagamento via {{ $booking->payment_method === 'pix' ? 'PIX' : 'Cartão de crédito' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- AÇÕES --}}
            @if($s !== 'CANCELLED' && $ps === 'PAID')
                <button
                    wire:click="confirmCancel"
                    type="button"
                    class="w-full h-12 rounded-2xl flex items-center justify-center gap-2 text-sm font-bold transition"
                    style="background: rgba(239,68,68,0.08); color: #dc2626;"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                    </svg>
                    Cancelar reserva
                </button>
            @endif

        </div>

    </div>

    {{-- MODAL DE CONFIRMAÇÃO --}}
    <div x-show="confirmingCancel" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="background: rgba(5,30,52,0.5);">
        <div @click.outside="confirmingCancel = false"
             class="bg-white rounded-3xl p-6 w-full max-w-md">
            <h3 class="text-lg font-extrabold mb-2" style="color: #051e34;">Cancelar esta reserva?</h3>
            <p class="text-sm mb-4" style="color: #87c2c0;">
                O valor será estornado ao cliente e as vagas voltarão a ficar disponíveis. Essa ação não pode ser desfeita.
            </p>

            <label class="block text-xs font-bold uppercase tracking-widest mb-2" style="color: #87c2c0;">
                Motivo (opcional)
            </label>
            <textarea
                wire:model="cancellationReason"
                rows="3"
                placeholder="Ex: cliente solicitou o cancelamento"
                class="w-full rounded-2xl text-sm p-3 outline-none mb-5"
                style="border: 1.5px solid #e8e4d8; color: #051e34;"
            ></textarea>

            <div class="flex items-center gap-3">
                <button @click="confirmingCancel = false" type="button"
                    class="flex-1 h-11 rounded-xl text-sm font-bold transition"
                    style="background: #f5f2ec; color: #051e34;">
                    Voltar
                </button>
                <button wire:click="cancelBooking" wire:loading.attr="disabled" type="button"
                    class="flex-1 h-11 rounded-xl text-sm font-bold text-white transition disabled:opacity-50"
                    style="background: #dc2626;">
                    <span wire:loading.remove wire:target="cancelBooking">Confirmar cancelamento</span>
                    <span wire:loading wire:target="cancelBooking">Cancelando...</span>
                </button>
            </div>
        </div>
    </div>

</div>