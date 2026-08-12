<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Painel Náutico' }}</title>

    <link rel="icon" href="{{$config->getfaveicon()}}" type="image/x-icon">

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        .sidebar-bg { background-color: #051e34; }
        .accent-green { background-color: #23c55e; }
        .accent-yellow { background-color: #fadd37; }
        .text-cream { color: #efebe0; }
        .bg-cream { background-color: #efebe0; }
        .bg-page { background-color: #efebe0; }
        .nav-active { background-color: #fadd37; color: #051e34; }
        .nav-inactive { color: #87c2c0; }
        .nav-inactive:hover { background-color: rgba(255,255,255,0.06); color: #efebe0; }
        .user-card { background-color: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); }
        .badge-online { background-color: rgba(35,197,94,0.12); border: 1px solid rgba(35,197,94,0.3); color: #23c55e; }
        .btn-logout { background-color: rgba(255,255,255,0.06); color: #87c2c0; }
        .btn-logout:hover { background-color: rgba(255,255,255,0.12); color: #efebe0; }
        .topbar-bg { background-color: #ffffff; border-bottom: 1px solid #e8e4d8; }
        .avatar-bg { background-color: #23c55e; color: #051e34; }
        .create-dashed { border: 1.5px dashed #16a3b7; color: #16a3b7; }
        .create-dashed:hover { background-color: rgba(22,163,183,0.08); }
        .section-label { color: #87c2c0; }
        .sidebar-border { border-right: 1px solid rgba(255,255,255,0.07); }
        .logo-dot { background-color: #fadd37; }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

</head>

<body
    x-data="{ sidebar: false }"
    class="bg-page text-gray-800 antialiased"
    style="background-color: #efebe0;"
>

    <div class="flex min-h-screen items-stretch">

        {{-- OVERLAY MOBILE --}}
        <div
            x-show="sidebar"
            x-transition.opacity
            class="fixed inset-0 bg-black/50 z-40 lg:hidden"
            @click="sidebar = false"
        ></div>

        <livewire:company.sidebar class="flex flex-col" style="min-height: 100vh;" />

        {{-- CONTENT --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- TOPBAR --}}
            <header class="topbar-bg h-16 px-4 lg:px-8 flex items-center justify-between shrink-0">

                <div class="flex items-center gap-3">

                    <button
                        class="lg:hidden w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition"
                        @click="sidebar = true"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>

                    <div>
                        <h2 class="text-base lg:text-lg font-extrabold leading-tight" style="color: #051e34;">
                            {{ $title ?? 'Dashboard' }}
                        </h2>
                        <p class="text-xs hidden md:block leading-tight" style="color: #87c2c0;">
                            {{ $bracrhumb ?? 'Gerencie sua operação náutica' }}
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2">

                    <a
                        href="{{ route('web.home') }}"
                        class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-[#0d9488] transition"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="Ir para o site"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 6H18m0 0v4.5M18 6l-7.5 7.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18h12a1 1 0 001-1V10"/>
                        </svg>
                    </a>

                   <livewire:company.notification-bell />

                    @php
                        $company = auth('customer')->user()?->company;
                    @endphp

                    @if($company)
                        <div class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-xl"
                            style="background-color: rgba(34,197,94,.1); color:#16a34a;">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                            <span class="text-xs font-bold">Empresa ativa</span>
                        </div>
                    @else
                        <div class="hidden md:flex items-center gap-1.5 px-3 py-1.5 rounded-xl"
                            style="background-color: rgba(245,158,11,.1); color:#d97706;">
                            <div class="w-1.5 h-1.5 rounded-full bg-yellow-500"></div>
                            <span class="text-xs font-bold">Perfil incompleto</span>
                        </div>
                    @endif                    

                </div>

            </header>

            {{-- PAGE --}}
            <main class="flex-1 p-4 lg:p-8">

                {{ $slot }}

            </main>

        </div>

    </div>
    

    @livewireScripts

    <script>
        // Listener genérico para todos os tipos de SweetAlert
        ['swal', 'swal:error', 'swal:success', 'swal:info', 'swal:warning'].forEach(eventName => {
            window.addEventListener(eventName, (event) => {
                const data = event.detail?.[0] ?? {};

                let defaultIcon = 'info';
                if (eventName === 'swal:error') defaultIcon = 'error';
                if (eventName === 'swal:success') defaultIcon = 'success';
                if (eventName === 'swal:warning') defaultIcon = 'warning';

                Swal.fire({
                    title: data.title ?? 'Aviso',
                    text: data.text ?? '',
                    icon: data.icon ?? defaultIcon,
                    timer: data.timer ?? null,
                    showConfirmButton: data.showConfirmButton ?? true,
                    confirmButtonText: data.confirmButtonText ?? 'OK',
                }).then((result) => {
                    // ADAPTAÇÃO AQUI: Verifica se existe uma URL para redirecionar
                    if (data.redirectUrl) {
                        window.location.href = data.redirectUrl;
                    }
                });
            });
        });


        // Listener para confirmação (precisa de lógica especial)
        window.addEventListener('swal:confirm', (event) => {
            const data = event.detail?.[0] ?? {};

            Swal.fire({
                title: data.title ?? 'Tem certeza?',
                text: data.text ?? '',
                icon: data.icon ?? 'warning',
                showCancelButton: true,
                confirmButtonText: data.confirmButtonText ?? 'Confirmar',
                cancelButtonText: data.cancelButtonText ?? 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed && data.confirmEvent) {
                    Livewire.dispatch(data.confirmEvent, data.confirmParams ?? []);
                }
            });
        });
    </script>

    @stack('scripts') 
</body>

</html>