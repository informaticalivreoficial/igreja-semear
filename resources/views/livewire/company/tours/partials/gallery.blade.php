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
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
            </svg>
        </div>

        <div>
            <h2
                class="text-sm font-bold"
                style="color: #051e34;"
            >
                Galeria de Fotos
            </h2>

            <p
                class="text-xs"
                style="color: #87c2c0;"
            >
                Adicione imagens atrativas do passeio.
            </p>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="p-6 space-y-6">

        {{-- UPLOAD --}}
        <div>

            <label
                class="flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed cursor-pointer transition py-10"
                style="border-color: #dbe7ea;"
                onmouseover="this.style.borderColor='#16a3b7'; this.style.backgroundColor='rgba(22,163,183,0.03)'"
                onmouseout="this.style.borderColor='#dbe7ea'; this.style.backgroundColor='transparent'"
            >

                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center"
                    style="background-color: rgba(22,163,183,0.08);"
                >
                    <svg
                        class="w-7 h-7"
                        style="color: #16a3b7;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                    >
                        <path d="M12 16V4"/>
                        <path d="M7 9l5-5 5 5"/>
                        <path d="M20 16.58A5 5 0 0018 7h-1.26A8 8 0 104 16.25"/>
                        <path d="M8 16h8"/>
                    </svg>
                </div>

                <div class="text-center">
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
                        PNG, JPG ou WEBP • múltiplas imagens
                    </p>
                </div>

                <input
                    type="file"
                    wire:model="photos"
                    multiple
                    accept="image/*"
                    class="hidden"
                >

            </label>

            @error('photos.*')
                <p
                    class="text-xs mt-2"
                    style="color: #e53e3e;"
                >
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- LOADING --}}
        <div
            wire:loading.flex
            wire:target="photos"
            class="items-center gap-2 text-sm"
            style="color: #16a3b7;"
        >

            <svg
                class="animate-spin w-4 h-4"
                viewBox="0 0 24 24"
                fill="none"
            >
                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                ></circle>

                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                ></path>
            </svg>

            Enviando imagens...

        </div>

        {{-- PREVIEW NOVAS --}}
        @if ($photos)

            <div class="space-y-3">

                <div class="flex items-center justify-between">

                    <h3
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Novas imagens
                    </h3>

                    <span
                        class="text-xs"
                        style="color: #87c2c0;"
                    >
                        {{ count($photos) }} imagem(ns)
                    </span>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                    @foreach ($photos as $index => $photo)

                        <div
                            class="relative rounded-2xl overflow-hidden border bg-white"
                            style="border-color: #e8e4d8;"
                        >

                            {{-- IMG --}}
                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                class="w-full h-44 object-cover"
                            >

                            {{-- DELETE --}}
                            <button
                                type="button"
                                wire:click="removePhoto({{ $index }})"
                                class="absolute top-2 right-2 w-8 h-8 rounded-xl flex items-center justify-center shadow-md transition"
                                style="background-color: rgba(239,68,68,0.95); color: white;"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M18 6L6 18"/>
                                    <path d="M6 6l12 12"/>
                                </svg>
                            </button>

                            {{-- BADGE --}}
                            <div class="absolute bottom-2 left-2">

                                <span
                                    class="text-[11px] font-bold px-2 py-1 rounded-lg"
                                    style="background-color: rgba(5,30,52,0.9); color: #fff;"
                                >
                                    Nova
                                </span>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

        {{-- IMAGENS SALVAS --}}
        @if ($tour && $tour->images->count())

            <div class="space-y-3">

                <div class="flex items-center justify-between">

                    <h3
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Imagens cadastradas
                    </h3>

                    <span
                        class="text-xs"
                        style="color: #87c2c0;"
                    >
                        {{ $tour->images->count() }} imagem(ns)
                    </span>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                    @foreach ($tour->images as $image)

                        <div
                            class="relative rounded-2xl overflow-hidden border bg-white"
                            style="border-color: #e8e4d8;"
                        >

                            {{-- IMG --}}
                            <img
                                src="{{ $image->url_image }}"
                                class="w-full h-44 object-cover"
                            >

                            {{-- ACTIONS --}}
                            <div class="absolute top-2 right-2 flex items-center gap-2">

                                {{-- COVER --}}
                                @if(!$image->cover)

                                    <button
                                        type="button"
                                        wire:click="setCover({{ $image->id }})"
                                        class="w-8 h-8 rounded-xl flex items-center justify-center shadow-md transition"
                                        style="background-color: rgba(5,30,52,0.92); color: white;"
                                        title="Definir capa"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>

                                @endif

                                {{-- DELETE --}}
                                <button
                                    type="button"
                                    wire:click="deleteImage({{ $image->id }})"
                                    class="w-8 h-8 rounded-xl flex items-center justify-center shadow-md transition"
                                    style="background-color: rgba(239,68,68,0.95); color: white;"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M18 6L6 18"/>
                                        <path d="M6 6l12 12"/>
                                    </svg>
                                </button>

                            </div>

                            {{-- COVER BADGE --}}
                            @if($image->cover)

                                <div class="absolute bottom-2 left-2">

                                    <span
                                        class="text-[11px] font-bold px-2 py-1 rounded-lg"
                                        style="background-color: rgba(35,197,94,0.95); color: #051e34;"
                                    >
                                        Capa
                                    </span>

                                </div>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>

</div>