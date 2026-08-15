@php
    if (!empty(auth()->user()->avatar) && Storage::exists(auth()->user()->avatar)) {
        $cover = Storage::url(auth()->user()->avatar);
    } else {
        if (auth()->user()->gender == 'masculino') {
            $cover = asset('theme/images/avatar5.png');
        } elseif (auth()->user()->gender == 'feminino') {
            $cover = asset('theme/images/avatar3.png');
        } else {
            $cover = asset('theme/images/avatar3.png');
        }
    }
@endphp

<header class="sticky top-0 z-20 flex h-16 shrink-0 items-center justify-between gap-4 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">

    {{-- LADO ESQUERDO --}}
    <div class="flex items-center gap-3">
        <button
            type="button"
            @click="toggleSidebar()"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-forest-50 hover:text-forest-700"
            title="Alternar menu"
        >
            <i class="fas fa-bars"></i>
        </button>

        <div class="hidden items-center gap-2 text-sm text-slate-400 md:flex">
            <i class="fas fa-seedling text-gold-500"></i>
            <span class="font-medium text-slate-500">Administração</span>
        </div>
    </div>

    {{-- LADO DIREITO --}}
    <div class="flex items-center gap-1.5">

        {{-- Ver Site --}}
        <a
            href="{{ route('web.home') }}"
            target="_blank"
            title="Ver Site"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-forest-50 hover:text-forest-700"
        >
            <i class="fas fa-desktop"></i>
        </a>

        {{-- Notificações --}}
        <livewire:components.notifications-dropdown />

        {{-- Fullscreen --}}
        <button
            type="button"
            @click="toggleFullscreen()"
            title="Tela cheia"
            class="hidden h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-forest-50 hover:text-forest-700 sm:flex"
        >
            <i class="fas fa-expand-arrows-alt"></i>
        </button>

        {{-- Usuário --}}
        <div
            x-data="{ open: false }"
            class="relative ml-1"
        >
            <button
                @click="open = !open"
                class="flex items-center gap-2 rounded-xl p-1 pr-1 transition hover:bg-forest-50 sm:pr-3"
            >
                <img
                    src="{{ $cover }}"
                    alt="{{ auth()->user()->name }}"
                    class="h-9 w-9 rounded-full object-cover ring-2 ring-gold-300"
                >
                <span class="hidden text-sm font-medium text-slate-700 lg:block">
                    {{ \App\Helpers\Renato::getPrimeiroNome(auth()->user()->name) }}
                </span>
                <i class="fas fa-chevron-down hidden text-[10px] text-slate-400 sm:block"></i>
            </button>

            {{-- Dropdown --}}
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-3 w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl z-50"
                style="display:none;"
            >

                {{-- Header --}}
                <div class="border-b border-slate-100 bg-gradient-to-r from-forest-900 to-forest-700 px-4 py-4">
                    <div class="flex items-center gap-3">
                        <img
                            src="{{ $cover }}"
                            alt="{{ auth()->user()->name }}"
                            class="h-12 w-12 rounded-full object-cover ring-2 ring-gold-400"
                        >
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-white">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs text-slate-300">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Menu --}}
                <div class="py-2">
                    <a
                        href="{{ route('admin.users.edit', auth()->user()->id) }}"
                        wire:navigate
                        @click="open = false"
                        class="flex items-center gap-3 px-5 py-3 text-sm text-slate-700 transition hover:bg-forest-50"
                    >
                        <i class="fas fa-user w-5 text-forest-500"></i>
                        <span>Meu Perfil</span>
                    </a>

                    <button
                        type="button"
                        @click="$dispatch('open-support-modal'); open = false"
                        class="flex w-full items-center gap-3 px-5 py-3 text-left text-sm text-slate-700 transition hover:bg-forest-50"
                    >
                        <i class="fas fa-life-ring w-5 text-gold-600"></i>
                        <span>Ajuda & Suporte</span>
                    </button>
                </div>

                {{-- Footer --}}
                <div class="border-t border-slate-100 p-2">
                    @auth
                        <livewire:auth.button-logout />
                    @endauth
                </div>

            </div>
        </div>

    </div>

</header>
