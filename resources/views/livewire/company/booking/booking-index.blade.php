<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        {{-- SEARCH --}}
        <div class="relative w-full lg:max-w-xl">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #87c2c0;"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <path d="M21 21l-4.35-4.35"/>
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Buscar por nome, e-mail ou código..."
                class="w-full h-12 pl-11 pr-4 rounded-2xl text-sm outline-none transition"
                style="border: 1.5px solid #e8e4d8; background: white; color: #051e34;"
                onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.1)'"
                onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
            >
        </div>

        {{-- FILTROS --}}
        <div class="flex items-center gap-3">
            <select wire:model.live="statusFilter"
                class="h-12 px-4 rounded-2xl text-sm font-semibold outline-none transition"
                style="border: 1.5px solid #e8e4d8; background: white; color: #051e34;">
                <option value="">Todos status</option>
                <option value="PENDING">Pendente</option>
                <option value="CONFIRMED">Confirmado</option>
                <option value="CANCELLED">Cancelado</option>
                <option value="COMPLETED">Concluído</option>
            </select>

            <select wire:model.live="paymentFilter"
                class="h-12 px-4 rounded-2xl text-sm font-semibold outline-none transition"
                style="border: 1.5px solid #e8e4d8; background: white; color: #051e34;">
                <option value="">Todos pagamentos</option>
                <option value="PENDING">Aguardando</option>
                <option value="PAID">Pago</option>
                <option value="REFUSED">Recusado</option>
                <option value="REFUNDED">Reembolsado</option>
            </select>
        </div>

    </div>

    {{-- EMPTY --}}
    @if($bookings->isEmpty())
        <div class="bg-white rounded-3xl p-16 text-center" style="border: 1.5px dashed #e8e4d8;">
            <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center mb-5"
                 style="background: rgba(22,163,183,0.08);">
                <svg class="w-10 h-10" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h2 class="text-xl font-extrabold mb-2" style="color: #051e34;">Nenhuma reserva encontrada</h2>
            <p class="text-sm" style="color: #87c2c0;">As reservas aparecerão aqui quando os clientes realizarem compras.</p>
        </div>

    @else

        {{-- LISTA --}}
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <a href="{{ route('company.bookings.show', $booking) }}" 
                class="block bg-white rounded-3xl overflow-hidden transition-all duration-300 hover:shadow-md"
                     style="border: 1px solid #e8e4d8;"
                     >

                    <div class="p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4">

                            {{-- INFO CLIENTE --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    {{-- Avatar --}}
                                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 font-extrabold text-sm"
                                         style="background: rgba(22,163,183,0.1); color: #16a3b7;">
                                        {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-extrabold text-sm truncate" style="color: #051e34;">
                                            {{ $booking->customer_name }}
                                        </p>
                                        <p class="text-xs truncate" style="color: #87c2c0;">
                                            {{ $booking->customer_email }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Tour e data --}}
                                <div class="flex flex-wrap items-center gap-2 mt-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                                          style="background: rgba(22,163,183,0.08); color: #16a3b7;">
                                        {{ $booking->tour?->title }}
                                    </span>
                                    @if($booking->tourDate)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                                              style="background: rgba(99,102,241,0.08); color: #6366f1;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                                <line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                            {{ $booking->tourDate->date->format('d/m/Y') }}
                                            · {{ substr($booking->tourDate->start_time, 0, 5) }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold"
                                          style="background: rgba(245,158,11,0.08); color: #d97706;">
                                        {{ $booking->adults }} adulto(s)
                                        @if($booking->children > 0) · {{ $booking->children }} criança(s) @endif
                                    </span>
                                </div>
                            </div>

                            {{-- STATUS + VALOR + AÇÕES --}}
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 shrink-0">

                                {{-- Status --}}
                                <div class="flex flex-col gap-1.5">
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
                                        ];
                                        $s  = $booking->status->value ?? 'PENDING';
                                        $ps = $booking->payment_status->value ?? 'PENDING';
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                          style="background: {{ $statusColors[$s]['bg'] }}; color: {{ $statusColors[$s]['color'] }};">
                                        {{ $statusLabels[$s] }}
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                                          style="background: {{ $paymentColors[$ps]['bg'] }}; color: {{ $paymentColors[$ps]['color'] }};">
                                        {{ $paymentLabels[$ps] }}
                                    </span>
                                </div>

                                {{-- Valor --}}
                                <div class="text-right">
                                    <p class="text-xl font-extrabold" style="color: #23c55e;">
                                        R$ {{ number_format($booking->total, 2, ',', '.') }}
                                    </p>
                                    <p class="text-xs" style="color: #87c2c0;">
                                        {{ $booking->payment_method === 'pix' ? 'PIX' : 'Cartão' }}
                                    </p>
                                </div>

                                {{-- Ações 
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="setDeleteId({{ $booking->id }})"
                                        type="button"
                                        class="h-10 w-10 rounded-xl flex items-center justify-center transition"
                                        style="background: rgba(239,68,68,0.08); color: #dc2626;"
                                        title="Cancelar reserva">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                        </svg>
                                    </button>
                                </div>
                                --}}
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="px-5 py-3 flex items-center justify-between"
                         style="border-top: 1px solid #f5f2ec;">
                        <span class="text-xs font-mono" style="color: #c5bfb2;">
                            #{{ strtoupper(substr($booking->uuid, 0, 8)) }}
                        </span>
                        <span class="text-xs" style="color: #c5bfb2;">
                            {{ $booking->created_at->format('d/m/Y \à\s H:i') }}
                        </span>
                    </div>

                </a>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>

    @endif

</div>