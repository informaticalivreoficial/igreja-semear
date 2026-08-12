<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1
            class="text-2xl font-extrabold tracking-tight"
            style="color: #051e34;"
        >
            {{ $tour ? 'Editar Passeio' : 'Cadastrar Passeio' }}
        </h1>

        <p
            class="text-sm mt-2"
            style="color: #87c2c0;"
        >
            Configure as informações do passeio para publicação no marketplace.
        </p>

    </div>

    {{-- ALERT --}}
    @if (!$tour)

        <div
            class="flex items-start gap-3 rounded-xl px-4 py-3 mb-6"
            style="background-color: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.4);"
        >

            <svg
                class="w-5 h-5 mt-0.5 shrink-0"
                style="color: #c4a800;"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 16v-4M12 8h.01"/>
            </svg>

            <p
                class="text-sm"
                style="color: #7a6800;"
            >
                Preencha corretamente as informações para aumentar a conversão das reservas.
            </p>

        </div>

    @endif

    <form wire:submit="save" class="space-y-6">

        {{-- CARD: DADOS PRINCIPAIS --}}
        <div
            class="bg-white rounded-2xl overflow-hidden"
            style="border: 1px solid #e8e4d8;"
        >

            {{-- HEADER --}}
            <div
                class="flex items-center gap-3 px-6 py-4"
                style="border-bottom: 1px solid #f0ece4;"
            >

                <div
                    class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                    style="background-color: rgba(22,163,183,0.1);"
                >

                    <svg
                        class="w-5 h-5"
                        style="color: #16a3b7;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                        <path d="M3 21h18"/>
                    </svg>

                </div>

                <div>

                    <h2
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Dados do Passeio
                    </h2>

                    <p
                        class="text-xs"
                        style="color: #87c2c0;"
                    >
                        Informações principais da experiência.
                    </p>

                </div>

            </div>

            {{-- BODY --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- EMBARCAÇÃO --}}
                <div class="flex flex-col gap-1.5">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Embarcação *
                    </label>

                    <select
                        wire:model="vessel_id"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('vessel_id'),
                            'input-pagbank-error input-error' => $errors->has('vessel_id'),
                        ])
                    >

                        <option value="">
                            Selecione
                        </option>

                        @foreach($vessels as $vessel)

                            <option value="{{ $vessel->id }}">
                                {{ $vessel->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('vessel_id')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- TIPO --}}
                <div class="flex flex-col gap-1.5">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Tipo de Passeio *
                    </label>

                    <select
                        wire:model="tour_type"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('tour_type'),
                            'input-pagbank-error input-error' => $errors->has('tour_type'),
                        ])
                    >
                        <option value="">Selecione</option>
                        @foreach(\App\Enums\TourTypeEnum::cases() as $type)
                            <option value="{{ $type->value }}">
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>

                    @error('tour_type')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- TÍTULO --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Título do Passeio *
                    </label>

                    <input
                        type="text"
                        wire:model="title"
                        placeholder="Ex: Passeio Ilha Anchieta Premium"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('title'),
                            'input-pagbank-error input-error' => $errors->has('title'),
                        ])
                    >

                    @error('title')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- PREÇO --}}
                <div
                    x-data="{
                        display: '',

                        init() {
                            if ($wire.price) {
                                this.display = this.format($wire.price.toString())
                            }
                        },

                        format(value) {
                            value = value.replace(/\D/g, '')

                            value = (Number(value) / 100).toFixed(2) + ''

                            value = value.replace('.', ',')

                            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.')

                            return 'R$ ' + value
                        }
                    }"
                >
                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Preço *
                    </label>

                    <input
                        type="text"

                        x-model="display"

                        x-on:input="
                            display = format($event.target.value)

                            let numeric = display
                                .replace('R$ ', '')
                                .replace(/\./g, '')
                                .replace(',', '.')

                            $wire.set('price', numeric)
                        "

                        placeholder="R$ 0,00"

                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('price'),
                            'input-pagbank-error input-error' => $errors->has('price'),
                        ])
                    >

                    @error('price')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- DURAÇÃO --}}
                <div class="flex flex-col gap-1.5">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Duração *
                    </label>

                    <input
                        type="text"
                        wire:model="duration"
                        placeholder="Ex: 7 horas"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('duration'),
                            'input-pagbank-error input-error' => $errors->has('duration'),
                        ])
                    >

                    @error('duration')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- EMBARQUE --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Local de Embarque *
                    </label>

                    <input
                        type="text"
                        wire:model="boarding_place"
                        placeholder="Ex: Marina Saco da Ribeira"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('boarding_place'),
                            'input-pagbank-error input-error' => $errors->has('boarding_place'),
                        ])
                    >

                    @error('boarding_place')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>

        {{-- CARD: DESCRIÇÃO --}}
        <div
            class="bg-white rounded-2xl overflow-hidden"
            style="border: 1px solid #e8e4d8;"
        >

            <div
                class="flex items-center gap-3 px-6 py-4"
                style="border-bottom: 1px solid #f0ece4;"
            >

                <div
                    class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                    style="background-color: rgba(35,197,94,0.1);"
                >

                    <svg
                        class="w-5 h-5"
                        style="color: #23c55e;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    </svg>

                </div>

                <div>

                    <h2
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Sobre o Passeio
                    </h2>

                    <p
                        class="text-xs"
                        style="color: #87c2c0;"
                    >
                        Explique a experiência oferecida.
                    </p>

                </div>

            </div>

            <div class="p-6 space-y-5">

                {{-- DESCRIÇÃO --}}
                <div class="flex flex-col gap-1.5">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Descrição
                    </label>

                    <textarea
                        wire:model="description"
                        rows="7"
                        placeholder="Descreva os diferenciais do passeio..."
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8;"
                    ></textarea>

                </div>

                {{-- REGRAS --}}
                <div class="flex flex-col gap-1.5">

                    <label
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Regras
                    </label>

                    <textarea
                        wire:model="rules"
                        rows="5"
                        placeholder="Ex: Não permitido som externo..."
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8;"
                    ></textarea>

                </div>

            </div>

        </div>

        {{-- CARD: GALERIA --}}
        @include('livewire.company.tours.partials.gallery')

        {{-- STATUS --}}
        <div
            class="bg-white rounded-2xl p-5 flex items-center justify-between gap-4 flex-wrap"
            style="border: 1px solid #e8e4d8;"
        >

            <div>

                <h3
                    class="text-sm font-bold mb-1"
                    style="color: #051e34;"
                >
                    Status do Passeio
                </h3>

                <p
                    class="text-xs"
                    style="color: #87c2c0;"
                >
                    Passeios ativos aparecem no marketplace.
                </p>

            </div>

            <label class="inline-flex items-center gap-3 cursor-pointer">

                <input
                    type="checkbox"
                    wire:model="active"
                    class="w-5 h-5 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                >

                <span
                    class="text-sm font-bold"
                    style="color: #051e34;"
                >
                    Passeio ativo
                </span>

            </label>

        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pt-2">

            <a
                href="{{ route('company.dashboard') }}"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition"
                style="border: 1px solid #e8e4d8; background: white; color: #87c2c0;"
                onmouseover="this.style.color='#051e34'"
                onmouseout="this.style.color='#87c2c0'"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #051e34; box-shadow: 0 2px 0 #15803d;"
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                >
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                </svg>

                {{ $tour ? 'Atualizar Passeio' : 'Salvar Passeio' }}

            </button>

        </div>

    </form>

</div>

@push('scripts')
    <script>
        init() {
            if ($wire.price) {
                this.display = this.format($wire.price.toString())
            }
        }
    </script>
@endpush