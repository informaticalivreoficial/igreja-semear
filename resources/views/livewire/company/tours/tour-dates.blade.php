<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Agenda do Passeio
            </h1>

            <p class="text-sm text-slate-500">
                Gerencie datas, vagas e bloqueios.
            </p>
        </div>

        <button
            wire:click="createDate"
            class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 px-5 py-3 font-semibold text-white shadow-sm transition hover:bg-emerald-600"
        >

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4V20M4 12H20"/>

            </svg>

            Nova Data

        </button>

    </div>

    {{-- CALENDÁRIO --}}
    <div class="overflow-hidden rounded-3xl border bg-white p-6 shadow-sm">

        <div
            x-data="calendarComponent()"
            x-init="init()"
            x-on:refresh-calendar.window="
                calendar.removeAllEvents();
                calendar.addEventSource($event.detail.events)
            "
            wire:ignore
        >
            <div id="calendar"></div>
        </div>

    </div>

    {{-- TABELA --}}
    <div class="overflow-hidden rounded-3xl border bg-white shadow-sm">

        <div class="border-b px-6 py-4">

            <h2 class="font-semibold text-slate-700">
                Datas cadastradas
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b bg-slate-50">

                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4">
                            Data
                        </th>

                        <th class="px-6 py-4">
                            Horário
                        </th>

                        <th class="px-6 py-4">
                            Vagas
                        </th>

                        <th class="px-6 py-4">
                            Preço
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Ações
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($dates as $item)

                        <tr class="transition hover:bg-slate-50">

                            {{-- DATA --}}
                            <td class="px-6 py-4 font-medium text-slate-700">

                                {{ $item->date->format('d/m/Y') }}

                            </td>

                            {{-- HORÁRIO --}}
                            <td class="px-6 py-4 text-slate-600">

                                {{ $item->start_time }}

                                @if($item->end_time)

                                    - {{ $item->end_time }}

                                @endif

                            </td>

                            {{-- VAGAS --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                                    {{ $item->available_slots }} vagas

                                </span>

                            </td>

                            {{-- PREÇO --}}
                            <td class="px-6 py-4 font-semibold text-slate-700">

                                R$ {{ number_format($item->price, 2, ',', '.') }}

                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"

                                    @class([

                                        'bg-green-100 text-green-700' =>
                                            $item->status->value === 'OPEN',

                                        'bg-red-100 text-red-700' =>
                                            $item->status->value === 'BLOCKED',

                                        'bg-yellow-100 text-yellow-700' =>
                                            $item->status->value === 'FULL',

                                        'bg-slate-200 text-slate-700' =>
                                            $item->status->value === 'CANCELLED',
                                    ])
                                >

                                    {{ $item->status->label() }}

                                </span>

                            </td>

                            {{-- AÇÕES --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- STATUS --}}
                                    <button
                                        wire:click="toggle({{ $item->id }})"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition
                                        {{ $item->active
                                            ? 'bg-green-500'
                                            : 'bg-slate-300' }}"
                                    >

                                        <span
                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition
                                            {{ $item->active
                                                ? 'translate-x-6'
                                                : 'translate-x-1' }}"
                                        ></span>

                                    </button>

                                    {{-- EDITAR --}}
                                    <button
                                        wire:click="edit({{ $item->id }})"
                                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-600 transition hover:bg-slate-100"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5h2m-1-1v2m-6 9l8-8 4 4-8 8H6v-4z"/>

                                        </svg>

                                    </button>

                                    {{-- EXCLUIR --}}
                                    <button
                                        wire:click="setDeleteId({{ $item->id }})"
                                        class="inline-flex items-center justify-center rounded-xl bg-red-50 p-2 text-red-600 transition hover:bg-red-100"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7L5 7M10 11V17M14 11V17M6 7L7 19C7.1 20.1 7.9 21 9 21H15C16.1 21 16.9 20.1 17 19L18 7M9 7V4C9 3.4 9.4 3 10 3H14C14.6 3 15 3.4 15 4V7"/>

                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="mb-4 rounded-full bg-slate-100 p-4">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-8 w-8 text-slate-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M8 7V3M16 7V3M4 11H20M5 5H19C20.1 5 21 5.9 21 7V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V7C3 5.9 3.9 5 5 5Z"/>

                                        </svg>

                                    </div>

                                    <p class="font-medium text-slate-500">
                                        Nenhuma data cadastrada.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINAÇÃO --}}
        <div class="border-t px-6 py-4">

            {{ $dates->links() }}

        </div>

    </div>

    {{-- MODAL --}}
    <div
        x-cloak
        x-show="$wire.showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        @click.self="$wire.resetForm()"  {{-- ✅ só fecha ao clicar no backdrop --}}
    >

        <div
            class="w-full max-w-4xl rounded-3xl bg-white shadow-2xl"
        >

            {{-- HEADER --}}
            <div class="flex items-center justify-between border-b px-6 py-4">

                <h2 class="text-lg font-bold">

                    {{ $editingId
                        ? 'Editar Data'
                        : 'Nova Data' }}

                </h2>

                <button
                    wire:click="resetForm"
                    class="rounded-xl p-2 hover:bg-slate-100"
                >
                    ✕
                </button>

            </div>

            {{-- BODY --}}
            <div class="p-6">

                <form
                    wire:submit="save"
                    class="grid grid-cols-1 gap-4 md:grid-cols-3"
                >

                    {{-- DATA --}}
                    <div
                        x-data="{ picker: null }"
                        x-init="
                            picker = flatpickr($refs.datepicker, {
                                locale: 'pt',
                                altInput: true,
                                altFormat: 'd/m/Y',
                                dateFormat: 'Y-m-d',
                                minDate: 'today',
                                onChange: function(selectedDates, dateStr) {
                                    $wire.set('date', dateStr)
                                    $el.classList.remove('date-error')
                                }
                            })                               

                            window.addEventListener('tour-date-edit', (event) => {
                                picker.setDate(event.detail.date, true)
                                $el.classList.remove('date-error')
                            })

                            window.addEventListener('tour-date-reset', () => {
                                picker.clear()
                                $el.classList.remove('date-error')
                            })

                            window.addEventListener('validation-errors', (event) => {
                                if (event.detail.fields.includes('date')) {
                                    $el.classList.add('date-error')
                                } else {
                                    $el.classList.remove('date-error')
                                }
                            })
                        "
                        wire:ignore
                    >
                        <label class="mb-1 block text-sm font-semibold">Data</label>
                        <input x-ref="datepicker" type="text" class="w-full rounded-xl border px-3 py-2">
                    </div>

                    {{-- SAÍDA --}}
                    <div
                        x-data="{ picker: null }"
                        x-init="
                            picker = flatpickr($refs.starttime, {
                                locale: 'pt',
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: 'H:i',
                                time_24hr: true,
                                onChange: function(selectedDates, dateStr) {
                                    $wire.set('start_time', dateStr)
                                    $el.classList.remove('date-error')
                                }
                            })

                            window.addEventListener('tour-date-edit', (event) => {
                                picker.setDate(event.detail.start_time, true, 'H:i')
                                $el.classList.remove('date-error')
                            })

                            window.addEventListener('tour-date-reset', () => {
                                picker.clear()
                                $el.classList.remove('date-error')
                            })

                            window.addEventListener('validation-errors', (event) => {
                                if (event.detail.fields.includes('start_time')) {
                                    $el.classList.add('date-error')
                                } else {
                                    $el.classList.remove('date-error')
                                }
                            })
                        "
                        wire:ignore
                    >
                        <label class="mb-1 block text-sm font-semibold">Saída</label>
                        <input x-ref="starttime" type="text" class="w-full rounded-xl border px-3 py-2">
                    </div>
                    

                    {{-- RETORNO --}}
                    <div
                        x-data="{ picker: null }"
                        x-init="
                            picker = flatpickr($refs.endtime, {
                                locale: 'pt',
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: 'H:i',
                                time_24hr: true,
                                onChange: function(selectedDates, dateStr) {
                                    $wire.set('end_time', dateStr)
                                }
                            })

                            window.addEventListener('tour-date-edit', (event) => {
                                picker.setDate(event.detail.end_time, true, 'H:i')
                            })

                            window.addEventListener('tour-date-reset', () => {
                                picker.clear()
                            })
                        "
                        wire:ignore
                    >
                        <label class="mb-1 block text-sm font-semibold">Retorno</label>
                        <input x-ref="endtime" type="text" class="w-full rounded-xl border px-3 py-2">
                    </div>

                    {{-- VAGAS --}}
                    <div>

                        <label class="mb-1 block text-sm font-semibold">
                            Vagas
                        </label>

                        <input
                            type="number"
                            wire:model="available_slots"
                            min="1"
                            class="w-full rounded-xl border px-3 py-2"
                        >

                    </div>

                    {{-- PREÇO --}}
                    <div>

                        <label class="mb-1 block text-sm font-semibold">
                            Preço
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            wire:model.live="price"
                            class="w-full rounded-xl border px-3 py-2"
                        >

                    </div>

                    {{-- STATUS --}}
                    <div>

                        <label class="mb-1 block text-sm font-semibold">
                            Status
                        </label>

                        <select
                            wire:model.live="status"
                            class="w-full rounded-xl border px-3 py-2"
                        >

                            <option value="OPEN">
                                Disponível
                            </option>

                            <option value="BLOCKED">
                                Bloqueado
                            </option>

                            <option value="FULL">
                                Lotado
                            </option>

                            <option value="CANCELLED">
                                Cancelado
                            </option>

                        </select>

                    </div>

                    {{-- FOOTER --}}
                    <div class="col-span-1 mt-6 flex justify-end gap-2 md:col-span-3">

                        <button
                            type="button"
                            wire:click="resetForm"
                            class="rounded-xl border px-5 py-2 hover:bg-slate-100"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-500 px-5 py-2 font-semibold text-white transition hover:bg-emerald-600"
                        >

                            {{ $editingId
                                ? 'Atualizar'
                                : 'Salvar' }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script>

function calendarComponent() {
    return {
        calendar: null,

        init() {
            const wire = this.$wire // ✅ captura o $wire do contexto Alpine

            this.calendar = new Calendar(
                document.getElementById('calendar'),
                {
                    plugins: [dayGridPlugin, interactionPlugin],
                    initialView: 'dayGridMonth',
                    locale: 'pt-br',
                    height: 'auto',
                    selectable: true,
                    eventDisplay: 'block',
                    dayMaxEvents: true,
                    moreLinkClick: 'popover',
                    events: @json($this->calendarEvents()),

                    dateClick: (info) => {
                        wire.createDate(info.dateStr)
                    },

                    eventClick: (info) => {
                        wire.edit(info.event.id)
                    },

                    customButtons: {
                        prev: {
                            text: '‹',
                            click: () => {
                                this.calendar.prev()
                                setTimeout(() => this.syncMonth(wire), 50)
                            }
                        },
                        next: {
                            text: '›',
                            click: () => {
                                this.calendar.next()
                                setTimeout(() => this.syncMonth(wire), 50)
                            }
                        },
                        today: {
                            text: 'Hoje',
                            click: () => {
                                this.calendar.today()
                                setTimeout(() => this.syncMonth(wire), 50)
                            }
                        },
                    },

                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'today next'
                    },
                }
            )

            this.calendar.render()
        },

        syncMonth(wire) {
            const date = this.calendar.getDate()
            const month = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0')
            wire.setMonth(month)
        }
    }
}

</script>

@endpush

@push('styles')
<style>
    .date-error input:not([type="hidden"]) {
        border-color: rgb(239 68 68) !important;
        border-width: 1px !important;
        border-style: solid !important;
    }
</style>
@endpush