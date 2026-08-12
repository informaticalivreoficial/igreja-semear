{{--
    MINI CALENDÁRIO DE DATAS DISPONÍVEIS - VERSÃO MODERNIZADA
    Dependências: Alpine.js, Tailwind CSS
    Design System: Gradientes, Glassmorphism, Animações
--}}

@php
    $datesByMonth = $dates->groupBy(fn($d) => $d->date->format('Y-m'));
    $monthKeys    = $datesByMonth->keys()->sort()->values();

    $calendarData = $datesByMonth->map(fn($group) =>
        $group->map(fn($d) => [
            'day'            => (int) $d->date->format('j'),
            'date_label'     => $d->date->translatedFormat('D, d \d\e M'),
            'start_time'     => $d->start_time,
            'end_time'       => $d->end_time ?? null,
            'price'          => number_format($d->price, 2, ',', '.'),
            'available_slots'=> $d->available_slots,
            'low_stock'      => $d->available_slots <= 4,
            'booking_url'    => route('checkout', $d->id),
        ])->keyBy('day')
    )->toJson();

    $monthLabels = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => \Carbon\Carbon::createFromFormat('Y-m', $ym)->translatedFormat('F Y')
    ])->toJson();

    $firstWeekdays = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => (int) \Carbon\Carbon::createFromFormat('Y-m', $ym)->startOfMonth()->dayOfWeek
    ])->toJson();

    $daysInMonth = $monthKeys->mapWithKeys(fn($ym) => [
        $ym => (int) \Carbon\Carbon::createFromFormat('Y-m', $ym)->daysInMonth
    ])->toJson();
@endphp

<div
    x-data="tourCalendar({{ $calendarData }}, {{ $monthLabels }}, {{ $firstWeekdays }}, {{ $daysInMonth }}, '{{ $monthKeys->first() }}')"
    x-init="init()"
    class="bg-white rounded-2xl overflow-hidden shadow-xl border border-blue-100 transform transition-all duration-300 hover:shadow-2xl"
>

    {{-- Header com preço --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
        <p class="text-blue-100 text-sm mb-1 font-medium">A partir de</p>
        <p class="text-4xl font-extrabold tracking-tight">
            R$ {{ number_format($tour->price, 2, ',', '.') }}
        </p>
        <p class="text-blue-200 text-sm mt-1">por pessoa</p>
        
        {{-- Badge de melhor preço --}}
        <div class="mt-3 inline-flex items-center gap-1 px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-semibold">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Melhor preço garantido
        </div>
    </div>

    <div class="p-5">

        {{-- Navegação do mês --}}
        <div class="flex items-center justify-between mb-5">
            <button
                @click="prevMonth()"
                :disabled="!hasPrev()"
                :class="hasPrev() ? 'hover:bg-blue-50 hover:border-blue-300 cursor-pointer' : 'opacity-30 cursor-not-allowed'"
                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 border-2 border-gray-200 text-gray-600"
                aria-label="Mês anterior"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>

            <span 
                class="text-lg font-extrabold capitalize bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" 
                x-text="currentMonthLabel()"
            ></span>

            <button
                @click="nextMonth()"
                :disabled="!hasNext()"
                :class="hasNext() ? 'hover:bg-blue-50 hover:border-blue-300 cursor-pointer' : 'opacity-30 cursor-not-allowed'"
                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 border-2 border-gray-200 text-gray-600"
                aria-label="Próximo mês"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>

        {{-- Dias da semana --}}
        <div class="grid grid-cols-7 mb-3">
            @foreach(['Dom','Seg','Ter','Qua','Qui','Sex','Sáb'] as $dow)
                <div class="text-center text-xs font-bold text-gray-400 pb-2">{{ $dow }}</div>
            @endforeach
        </div>

        {{-- Grade de dias --}}
        <div class="grid grid-cols-7 gap-2">
            <template x-for="cell in calendarCells()" :key="cell.key">
                <div class="flex justify-center">
                    {{-- Célula vazia --}}
                    <div x-show="cell.empty" class="w-9 h-9"></div>

                    {{-- Dia com passeio --}}
                    <button
                        x-show="!cell.empty && cell.hasTour"
                        @click="selectDay(cell.day)"
                        :class="{
                            'bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg transform scale-110': selectedDay === cell.day,
                            'bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-700 hover:from-blue-100 hover:to-indigo-100 hover:shadow-md hover:scale-105': selectedDay !== cell.day && !cell.lowStock,
                            'bg-gradient-to-br from-amber-50 to-orange-50 text-amber-700 hover:from-amber-100 hover:to-orange-100 hover:shadow-md hover:scale-105': selectedDay !== cell.day && cell.lowStock
                        }"
                        class="w-9 h-9 rounded-lg text-sm font-bold transition-all duration-200 relative flex items-center justify-center"
                        :aria-label="`Selecionar dia ${cell.day}`"
                    >
                        <span x-text="cell.day"></span>
                        
                        {{-- Indicador de vagas --}}
                        <span
                            x-show="selectedDay !== cell.day"
                            class="absolute -bottom-0.5 left-1/2 transform -translate-x-1/2 flex gap-0.5"
                        >
                            <span 
                                class="w-1 h-1 rounded-full"
                                :class="cell.lowStock ? 'bg-orange-400 animate-pulse' : 'bg-blue-400'"
                            ></span>
                        </span>

                        {{-- Check de selecionado --}}
                        <span x-show="selectedDay === cell.day" class="absolute -top-1 -right-1">
                            <svg class="w-4 h-4 text-green-400 bg-white rounded-full" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </span>
                    </button>

                    {{-- Dia sem passeio --}}
                    <div
                        x-show="!cell.empty && !cell.hasTour"
                        class="w-9 h-9 rounded-lg flex items-center justify-center text-sm text-gray-300 font-medium"
                        x-text="cell.day"
                    ></div>
                </div>
            </template>
        </div>

        {{-- Legenda --}}
        <div class="flex items-center justify-center gap-6 mt-5 mb-5">
            <span class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-blue-400 to-blue-500 shadow-sm"></span> 
                Disponível
            </span>
            <span class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-400 shadow-sm animate-pulse"></span> 
                Últimas vagas
            </span>
        </div>

        {{-- Detalhe da data selecionada --}}
        <div
            x-show="selectedDay !== null"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="rounded-2xl p-5 mb-5 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-2 border-blue-200 shadow-inner"
        >
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
                <p class="font-extrabold text-gray-800" x-text="selectedData()?.date_label"></p>
            </div>

            <div class="space-y-3">
                {{-- Horário --}}
                <div class="flex items-center justify-between bg-white/60 backdrop-blur rounded-xl p-3">
                    <span class="flex items-center gap-2 text-sm font-semibold text-gray-600">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        Horário
                    </span>
                    <span class="font-extrabold text-gray-800">
                        <span x-text="selectedData()?.start_time"></span>
                        <template x-if="selectedData()?.end_time">
                            <span class="text-gray-500"> → <span x-text="selectedData()?.end_time"></span></span>
                        </template>
                    </span>
                </div>

                {{-- Preço --}}
                <div class="flex items-center justify-between bg-white/60 backdrop-blur rounded-xl p-3">
                    <span class="flex items-center gap-2 text-sm font-semibold text-gray-600">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        Preço
                    </span>
                    <span class="font-extrabold text-lg bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        R$ <span x-text="selectedData()?.price"></span>
                    </span>
                </div>

                {{-- Vagas --}}
                <div class="flex items-center justify-between bg-white/60 backdrop-blur rounded-xl p-3">
                    <span class="flex items-center gap-2 text-sm font-semibold text-gray-600">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                        Vagas
                    </span>
                    <span
                        class="font-bold text-sm px-3 py-1 rounded-full"
                        :class="selectedData()?.low_stock
                            ? 'bg-gradient-to-r from-amber-400 to-orange-400 text-white shadow-md'
                            : 'bg-gradient-to-r from-emerald-400 to-green-500 text-white shadow-md'"
                    >
                        <span x-text="selectedData()?.available_slots"></span>
                        <span x-text="selectedData()?.low_stock ? ' — Garanta já!' : ' disponíveis'"></span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Placeholder --}}
        <div
            x-show="selectedDay === null"
            class="rounded-2xl p-6 mb-5 text-center bg-gradient-to-br from-gray-50 to-blue-50 border-2 border-dashed border-gray-200"
        >
            <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-500">Selecione um dia disponível</p>
            <p class="text-xs text-gray-400 mt-1">Os dias marcados têm passeio confirmado</p>
        </div>

        {{-- Botão de reserva --}}
        <a
            :href="selectedData()?.booking_url ?? '#'"
            :class="selectedDay ? 'opacity-100 cursor-pointer' : 'opacity-40 pointer-events-none'"
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                text-white font-extrabold py-4 rounded-xl shadow-lg hover:shadow-xl 
                transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            Reservar agora
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>

    </div>
</div>

{{-- Alpine.js component (mantido igual) --}}
@once
@push('scripts')
<script>
function tourCalendar(data, labels, firstWeekdays, daysInMonth, initialMonth) {
    return {
        data,
        labels,
        firstWeekdays,
        daysInMonth,
        monthKeys: Object.keys(labels).sort(),
        currentMonthIndex: 0,
        selectedDay: null,

        init() {
            this.currentMonthIndex = this.monthKeys.indexOf(initialMonth);
        },

        get currentMonth() {
            return this.monthKeys[this.currentMonthIndex];
        },

        currentMonthLabel() {
            return this.labels[this.currentMonth];
        },

        hasPrev() { return this.currentMonthIndex > 0; },
        hasNext() { return this.currentMonthIndex < this.monthKeys.length - 1; },

        prevMonth() {
            if (this.hasPrev()) {
                this.currentMonthIndex--;
                this.selectedDay = null;
            }
        },

        nextMonth() {
            if (this.hasNext()) {
                this.currentMonthIndex++;
                this.selectedDay = null;
            }
        },

        calendarCells() {
            const month     = this.currentMonth;
            const offset    = this.firstWeekdays[month];
            const total     = this.daysInMonth[month];
            const monthData = this.data[month] || {};
            const cells     = [];

            for (let i = 0; i < offset; i++) {
                cells.push({ key: `e${i}`, empty: true });
            }

            for (let d = 1; d <= total; d++) {
                const info = monthData[d] || null;
                cells.push({
                    key:      `d${d}`,
                    empty:    false,
                    day:      d,
                    hasTour:  !!info,
                    lowStock: info?.low_stock ?? false,
                });
            }

            return cells;
        },

        selectDay(day) {
            this.selectedDay = this.selectedDay === day ? null : day;
        },

        selectedData() {
            if (!this.selectedDay) return null;
            return (this.data[this.currentMonth] || {})[this.selectedDay] ?? null;
        },
    };
}
</script>
@endpush
@endonce