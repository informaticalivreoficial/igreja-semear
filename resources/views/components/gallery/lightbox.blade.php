<div
    x-data="gallery()"
    @gallery:open.window="open($event.detail.images, $event.detail.index)"
>
    <div
        x-show="opened"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-[9999] bg-black/95"
    >
        {{-- Fechar --}}
        <button
            @click="close()"
            class="absolute top-6 right-6 z-50 text-white hover:text-gray-300"
        >
            <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>
        {{-- Anterior --}}
        <button
            @click="prev()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-50 rounded-full bg-white/10 p-3 text-white backdrop-blur hover:bg-white/20"
        >
            ←
        </button>
        {{-- Próxima --}}
        <button
            @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-50 rounded-full bg-white/10 p-3 text-white backdrop-blur hover:bg-white/20"
        >
            →
        </button>
        {{-- Imagem --}}
        <div class="flex h-screen flex-col">
            <div class="flex-1 flex items-center justify-center p-6">
                <img
                    :src="images[current]"
                    class="max-h-[82vh] max-w-[90vw] rounded-xl object-contain"
                >
            </div>
            {{-- Contador --}}
            <div class="pb-3 text-center text-white">
                <span x-text="current+1"></span>
                /
                <span x-text="images.length"></span>
            </div>
            {{-- Miniaturas --}}
            <div
                class="pb-8 px-6 overflow-x-auto"
            >
                <div class="flex gap-3 justify-center min-w-max">
                    <template x-for="(image,index) in images">
                        <img
                            :src="image"
                            @click="current=index"
                            class="h-16 w-24 cursor-pointer rounded-lg object-cover transition"
                            :class="current==index
                                ? 'ring-4 ring-blue-500 scale-105'
                                : 'opacity-60 hover:opacity-100'"
                        >
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>