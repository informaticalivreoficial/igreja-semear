<div class="max-w-7xl mx-auto space-y-6" x-data>

    @if(!$hasCompany)
        <div class="bg-white rounded-3xl p-16 text-center" style="border: 1.5px dashed #e8e4d8;">
            <p class="text-sm" style="color: #87c2c0;">Você ainda não tem uma empresa vinculada.</p>
        </div>
    @else

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold" style="color: #051e34;">Relatórios</h1>
                <p class="text-sm mt-1" style="color: #87c2c0;">{{ $period_label }}</p>
            </div>

            <div class="flex items-center gap-2">
                <button wire:click="setPeriod('today')"
                    class="h-11 px-4 rounded-2xl text-sm font-bold transition"
                    style="{{ $period === 'today' ? 'background:#051e34;color:white;' : 'background:white;color:#87c2c0;border:1.5px solid #e8e4d8;' }}">
                    Hoje
                </button>
                <button wire:click="setPeriod('month')"
                    class="h-11 px-4 rounded-2xl text-sm font-bold transition"
                    style="{{ $period === 'month' ? 'background:#051e34;color:white;' : 'background:white;color:#87c2c0;border:1.5px solid #e8e4d8;' }}">
                    Mês
                </button>
                <button wire:click="setPeriod('year')"
                    class="h-11 px-4 rounded-2xl text-sm font-bold transition"
                    style="{{ $period === 'year' ? 'background:#051e34;color:white;' : 'background:white;color:#87c2c0;border:1.5px solid #e8e4d8;' }}">
                    Ano
                </button>
                <button wire:click="exportPdf"
                    class="h-11 px-5 rounded-2xl text-sm font-bold text-white transition flex items-center gap-2"
                    style="background: #16a3b7;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 10v6m0 0l-3-3m3 3l3-3M5 5h14v14H5V5z"/>
                    </svg>
                    Exportar PDF
                </button>
            </div>
        </div>

        {{-- VENDAS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
                <p class="text-sm font-semibold mb-2" style="color: #87c2c0;">Faturamento</p>
                <p class="text-2xl font-extrabold" style="color: #23c55e;">R$ {{ number_format($sales['total_revenue'], 2, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
                <p class="text-sm font-semibold mb-2" style="color: #87c2c0;">Reservas pagas</p>
                <p class="text-2xl font-extrabold" style="color: #051e34;">{{ $sales['total_paid_count'] }}</p>
            </div>
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
                <p class="text-sm font-semibold mb-2" style="color: #87c2c0;">Ticket médio</p>
                <p class="text-2xl font-extrabold" style="color: #051e34;">R$ {{ number_format($sales['average_ticket'], 2, ',', '.') }}</p>
            </div>
        </div>

        {{-- RESERVAS --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <h3 class="font-extrabold text-base mb-4" style="color: #051e34;">Reservas</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
                <div>
                    <p class="text-xs" style="color: #87c2c0;">Total</p>
                    <p class="text-lg font-extrabold" style="color: #051e34;">{{ $bookings['total'] }}</p>
                </div>
                @foreach($bookings['by_status'] as $status => $count)
                    <div>
                        <p class="text-xs" style="color: #87c2c0;">{{ ucfirst(strtolower($status)) }}</p>
                        <p class="text-lg font-extrabold" style="color: #051e34;">{{ $count }}</p>
                    </div>
                @endforeach
            </div>

            @if($bookings['top_tours']->isNotEmpty())
                <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: #87c2c0;">Mais reservados</p>
                <div class="space-y-1.5">
                    @foreach($bookings['top_tours'] as $title => $count)
                        <div class="flex items-center justify-between text-sm">
                            <span style="color: #051e34;">{{ $title }}</span>
                            <span class="font-bold" style="color: #16a3b7;">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- DESEMPENHO POR PASSEIO --}}
        <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8e4d8;">
            <div class="px-6 py-4" style="border-bottom: 1px solid #f5f2ec;">
                <h3 class="font-extrabold text-base" style="color: #051e34;">Desempenho por passeio</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="border-bottom: 1px solid #f5f2ec;">
                            <th class="text-left px-6 py-3 font-bold" style="color: #87c2c0;">Passeio</th>
                            <th class="text-right px-6 py-3 font-bold" style="color: #87c2c0;">Reservas</th>
                            <th class="text-right px-6 py-3 font-bold" style="color: #87c2c0;">Faturamento</th>
                            <th class="text-right px-6 py-3 font-bold" style="color: #87c2c0;">Ticket médio</th>
                            <th class="text-right px-6 py-3 font-bold" style="color: #87c2c0;">Ocupação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr style="border-bottom: 1px solid #f5f2ec;">
                                <td class="px-6 py-3 font-semibold" style="color: #051e34;">{{ $tour['title'] }}</td>
                                <td class="px-6 py-3 text-right" style="color: #051e34;">{{ $tour['bookings'] }}</td>
                                <td class="px-6 py-3 text-right font-bold" style="color: #23c55e;">R$ {{ number_format($tour['revenue'], 2, ',', '.') }}</td>
                                <td class="px-6 py-3 text-right" style="color: #051e34;">R$ {{ number_format($tour['average_ticket'], 2, ',', '.') }}</td>
                                <td class="px-6 py-3 text-right" style="color: #051e34;">{{ $tour['occupancy'] }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-8 text-center" style="color: #87c2c0;">Sem dados nesse período.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- FINANCEIRO + CLIENTES --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
                <h3 class="font-extrabold text-base mb-4" style="color: #051e34;">Financeiro</h3>
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between"><span style="color:#87c2c0;">Saldo disponível</span><span class="font-bold" style="color:#23c55e;">R$ {{ number_format($financial['available_balance'], 2, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span style="color:#87c2c0;">Saldo pendente</span><span class="font-bold" style="color:#d97706;">R$ {{ number_format($financial['pending_balance'], 2, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span style="color:#87c2c0;">Comissão no período</span><span class="font-bold" style="color:#051e34;">R$ {{ number_format($financial['commission_period'], 2, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span style="color:#87c2c0;">Sacado no período</span><span class="font-bold" style="color:#051e34;">R$ {{ number_format($financial['withdrawn_period'], 2, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span style="color:#87c2c0;">Saques em aberto</span><span class="font-bold" style="color:#6366f1;">R$ {{ number_format($financial['pending_withdrawals'], 2, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span style="color:#87c2c0;">Cancelado</span><span class="font-bold" style="color:#dc2626;">R$ {{ number_format($financial['cancelled_balance'], 2, ',', '.') }}</span></div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
                <h3 class="font-extrabold text-base mb-4" style="color: #051e34;">Clientes</h3>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div>
                        <p class="text-2xl font-extrabold" style="color: #051e34;">{{ $clients['total'] }}</p>
                        <p class="text-xs" style="color: #87c2c0;">Total</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold" style="color: #16a3b7;">{{ $clients['new'] }}</p>
                        <p class="text-xs" style="color: #87c2c0;">Novos</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold" style="color: #6366f1;">{{ $clients['returning'] }}</p>
                        <p class="text-xs" style="color: #87c2c0;">Recorrentes</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- EMBARCAÇÕES --}}
        @if(!empty($vessels))
            <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8e4d8;">
                <div class="px-6 py-4" style="border-bottom: 1px solid #f5f2ec;">
                    <h3 class="font-extrabold text-base" style="color: #051e34;">Uso de embarcações</h3>
                </div>
                <div class="divide-y" style="border-color: #f5f2ec;">
                    @foreach($vessels as $vessel)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <span class="text-sm font-semibold" style="color: #051e34;">{{ $vessel['name'] }}</span>
                            <span class="text-sm font-bold" style="color: #16a3b7;">{{ $vessel['bookings'] }} reservas</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    @endif
</div>