<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">

        <h1 class="text-2xl font-extrabold tracking-tight" style="color: #051e34;">
            {{ $vessel ? 'Editar Embarcação' : 'Cadastrar Embarcação' }}
        </h1>

        <p class="text-sm mt-2" style="color: #87c2c0;">
            Cadastre sua embarcação para começar a vender passeios.
        </p>

    </div>

    {{-- ALERT --}}
    @if (!$vessel)
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

            <p class="text-sm" style="color: #7a6800;">
                Preencha os dados da embarcação corretamente para aumentar a conversão das reservas.
            </p>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">

        {{-- CARD: DADOS PRINCIPAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden p-6 space-y-6" style="border: 1px solid #e8e4d8;">

            {{-- PRIMEIRA LINHA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NOME --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Nome da Embarcação *
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        placeholder="Ex: Ocean Prime"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('name'),
                            'input-pagbank-error input-error' => $errors->has('name'),
                        ])
                    >

                    @error('name')
                        <p class="text-xs mt-1" style="color: #e53e3e;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- TIPO --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Tipo da Embarcação *
                    </label>

                    <select
                        wire:model="type"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('type'),
                            'input-pagbank-error input-error' => $errors->has('type'),
                        ])
                    >
                        <option value="">Selecione</option>
                        <option value="Lancha">Lancha</option>
                        <option value="Iate">Iate</option>
                        <option value="Catamarã">Catamarã</option>
                        <option value="Escuna">Escuna</option>
                        <option value="Veleiro">Veleiro</option>
                        <option value="Jet Ski">Jet Ski</option>
                    </select>

                    @error('type')
                        <p class="text-xs mt-1" style="color: #e53e3e;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- SEGUNDA LINHA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                {{-- CAPACIDADE --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Capacidade *
                    </label>

                    <input
                        type="number"
                        wire:model="capacity"
                        placeholder="12"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('capacity'),
                            'input-pagbank-error input-error' => $errors->has('capacity'),
                        ])
                    >
                    @error('capacity')
                        <p class="text-xs mt-1" style="color: #e53e3e;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- ANO --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Ano
                    </label>

                    <input
                        type="number"
                        wire:model="year"
                        placeholder="2024"
                        class="input-pagbank input-pagbank-default"
                    >

                </div>

                {{-- TAMANHO --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Tamanho (m)
                    </label>

                    <input
                        type="text"
                        wire:model="size"
                        placeholder="42"
                        class="input-pagbank input-pagbank-default"
                    >

                </div>

                {{-- BANHEIROS --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Banheiros
                    </label>

                    <input
                        type="number"
                        wire:model="bathroom"
                        placeholder="2"
                        class="input-pagbank input-pagbank-default"
                    >

                </div>

            </div>

        </div>

        {{-- CARD: COMODIDADES --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

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
                        <path d="M9 12l2 2 4-4"/>
                        <path d="M21 12c0 1.66-.67 3.16-1.76 4.24A5.98 5.98 0 0115 18H9a6 6 0 110-12h6a6 6 0 016 6z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">
                        Comodidades
                    </h2>

                    <p class="text-xs" style="color: #87c2c0;">
                        Recursos disponíveis na embarcação.
                    </p>
                </div>

            </div>

            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- CHURRASQUEIRA --}}
                <label
                    class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                    style="border-color: #e8e4d8;"
                >
                    <input
                        type="checkbox"
                        wire:model="barbecue"
                        class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                    >

                    <span class="text-sm font-medium" style="color: #051e34;">
                        🍖 Churrasqueira
                    </span>
                </label>

                {{-- SUITE --}}
                <label
                    class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                    style="border-color: #e8e4d8;"
                >
                    <input
                        type="checkbox"
                        wire:model="suite"
                        class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                    >

                    <span class="text-sm font-medium" style="color: #051e34;">
                        🛏 Suíte
                    </span>
                </label>

                {{-- SOM --}}
                <label
                    class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                    style="border-color: #e8e4d8;"
                >
                    <input
                        type="checkbox"
                        wire:model="sound_system"
                        class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                    >

                    <span class="text-sm font-medium" style="color: #051e34;">
                        🎵 Som
                    </span>
                </label>

                {{-- COZINHA --}}
                <label
                    class="flex items-center gap-3 rounded-xl border px-4 py-3 cursor-pointer transition"
                    style="border-color: #e8e4d8;"
                >
                    <input
                        type="checkbox"
                        wire:model="kitchen"
                        class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                    >

                    <span class="text-sm font-medium" style="color: #051e34;">
                        🍳 Cozinha
                    </span>
                </label>

            </div>

        </div>

        {{-- CARD: DESCRIÇÃO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

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
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">
                        Descrição
                    </h2>

                    <p class="text-xs" style="color: #87c2c0;">
                        Descreva os diferenciais da embarcação.
                    </p>
                </div>

            </div>

            <div class="p-6">

                <textarea
                    wire:model="description"
                    rows="8"
                    placeholder="Ex: Embarcação premium equipada para passeios exclusivos..."
                    class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                    style="border-color: #e8e4d8; color: #051e34;"
                    onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                    onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                ></textarea>

            </div>

        </div>

        {{-- CARD: GALERIA --}}
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
                    style="background-color: rgba(51,123,188,0.1);"
                >
                    <svg
                        class="w-5 h-5"
                        style="color: #337bbc;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>

                <div>

                    <h2 class="text-sm font-bold" style="color: #051e34;">
                        Galeria de Fotos
                    </h2>

                    <p class="text-xs" style="color: #87c2c0;">
                        Adicione imagens da embarcação para aumentar as reservas.
                    </p>

                </div>

            </div>

            <div class="p-6 space-y-6">

                {{-- UPLOAD --}}
                <label
                    class="border-2 border-dashed rounded-2xl p-10 flex flex-col items-center justify-center text-center cursor-pointer transition"
                    style="border-color: #d9d4c7;"
                    onmouseover="this.style.borderColor='#16a3b7'; this.style.backgroundColor='rgba(22,163,183,0.03)'"
                    onmouseout="this.style.borderColor='#d9d4c7'; this.style.backgroundColor='transparent'"
                >

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                        style="background-color: rgba(22,163,183,0.08);"
                    >

                        <svg
                            class="w-8 h-8"
                            style="color: #16a3b7;"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>

                    </div>

                    <p
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Clique para enviar imagens
                    </p>

                    <p
                        class="text-xs mt-1"
                        style="color: #87c2c0;"
                    >
                        PNG, JPG ou WEBP até 2MB
                    </p>

                    <input
                        type="file"
                        wire:model="images"
                        multiple
                        accept="image/png,image/jpeg,image/webp"
                        class="hidden"
                    >

                </label>

                {{-- LOADING --}}
                <div wire:loading wire:target="images">

                    <div
                        class="rounded-xl px-4 py-3 text-sm font-medium"
                        style="background-color: rgba(22,163,183,0.08); color: #16a3b7;"
                    >
                        Enviando imagens...
                    </div>

                </div>

                {{-- ERRO --}}
                @error('images.*')
                    <p class="text-sm" style="color: #e53e3e;">
                        {{ $message }}
                    </p>
                @enderror

                {{-- PREVIEW NOVAS --}}
                @if ($images)

                    <div>

                        <h3
                            class="text-sm font-bold mb-3"
                            style="color: #051e34;"
                        >
                            Novas imagens
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4">

                            @foreach ($images as $index => $image)

                                <div class="relative group">

                                    <img
                                        src="{{ $image->temporaryUrl() }}"
                                        class="w-full h-32 object-cover rounded-xl border"
                                        style="border-color: #e8e4d8;"
                                    >

                                    {{-- DELETE PREVIEW --}}
                                    <button
                                        type="button"
                                        wire:click="removeTempImage({{ $index }})"
                                        class="absolute top-2 right-2 w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                    >
                                        ✕
                                    </button>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

                {{-- IMAGENS SALVAS --}}
                @if ($savedImages && count($savedImages))

                    <div>

                        <h3
                            class="text-sm font-bold mb-3"
                            style="color: #051e34;"
                        >
                            Imagens da embarcação
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                            @foreach ($savedImages as $image)

                                <div class="relative group">

                                    <img
                                        src="{{ Storage::url($image->path) }}"
                                        class="w-full aspect-[4/3] object-cover rounded-2xl border"
                                        style="border-color: #e8e4d8;"
                                    >

                                    {{-- CAPA --}}
                                    @if ($image->cover)

                                        <div
                                            class="absolute top-2 left-2 px-2 py-1 rounded-lg text-[11px] font-bold"
                                            style="background-color: #fadd37; color: #051e34;"
                                        >
                                            CAPA
                                        </div>

                                    @endif

                                    {{-- ACTIONS --}}
                                    <div class="absolute top-2 right-2 flex items-center gap-2">

                                        {{-- DEFINIR CAPA --}}
                                        <button
                                            type="button"
                                            wire:click="setCover({{ $image->id }})"
                                            class="w-9 h-9 rounded-xl bg-white/90 backdrop-blur flex items-center justify-center shadow hover:scale-105 transition"
                                        >

                                            ⭐

                                        </button>

                                        {{-- EXCLUIR --}}
                                        <button
                                            type="button"
                                            wire:click="deleteImage({{ $image->id }})"
                                            class="w-9 h-9 rounded-xl bg-red-500 text-white flex items-center justify-center shadow hover:bg-red-600 transition"
                                        >

                                            ✕

                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif

            </div>

        </div>

        {{-- STATUS --}}
        <div class="bg-white rounded-2xl p-5 flex items-center justify-between gap-4 flex-wrap"
            style="border: 1px solid #e8e4d8;"
        >

            <div>

                <h3 class="text-sm font-bold mb-1" style="color: #051e34;">
                    Status da Embarcação
                </h3>

                <p class="text-xs" style="color: #87c2c0;">
                    Embarcações ativas aparecem para os clientes no marketplace.
                </p>

            </div>

            <label class="inline-flex items-center gap-3 cursor-pointer">

                <input
                    type="checkbox"
                    wire:model="active"
                    class="w-5 h-5 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500"
                >

                <span class="text-sm font-bold" style="color: #051e34;">
                    Embarcação ativa
                </span>

            </label>

        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pt-2">

            <a
                href="{{ route('company.vessels.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition border"
                style="border-color: #e8e4d8; color: #051e34;"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #051e34; box-shadow: 0 2px 0 #15803d;"
                onmouseover="this.style.backgroundColor='#1aad52'"
                onmouseout="this.style.backgroundColor='#23c55e'"
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

                {{ $vessel ? 'Atualizar Embarcação' : 'Salvar Embarcação' }}
            </button>

        </div>

    </form>

</div>

@push('scripts')
    <script>

        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-error', () => {
                setTimeout(() => {
                    const firstError = document.querySelector('.input-error');
                    if (!firstError) return;
                    const offset = 120;
                    const targetPosition =
                        firstError.getBoundingClientRect().top
                        + window.pageYOffset
                        - offset;
                    smoothScrollTo(targetPosition, 1200);
                    firstError.focus();
                }, 100);
            });
        });

        function smoothScrollTo(target, duration = 1000) {
            const start = window.pageYOffset;
            const distance = target - start;
            let startTime = null;
            function animation(currentTime) {
                if (!startTime) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);

                // easeInOutCubic
                const ease =
                    progress < 0.5
                        ? 4 * progress * progress * progress
                        : 1 - Math.pow(-2 * progress + 2, 3) / 2;

                window.scrollTo(
                    0,
                    start + distance * ease
                );
                if (timeElapsed < duration) {

                    requestAnimationFrame(animation);

                }
            }
            requestAnimationFrame(animation);
        }

    </script>
@endpush