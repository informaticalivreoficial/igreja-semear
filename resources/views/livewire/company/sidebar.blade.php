<div>
    <aside
        class="sidebar-bg sidebar-border
            fixed lg:sticky
            top-0 left-0
            z-50
            w-64
            h-screen
            flex flex-col
            transform transition-transform duration-300
            lg:translate-x-0"
        :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
    >

        {{-- LOGO --}}
        <div class="h-16 px-5 flex items-center justify-between" style="border-bottom: 1px solid rgba(255,255,255,0.07);">

            <div class="flex items-center gap-2.5">

                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background-color: #fff;">
                    @if (auth('customer')->user()->company?->logo)
                        <img
                            src="{{ auth('customer')->user()->company->getLogoUrl() }}"
                            alt="{{ auth('customer')->user()->company->alias_name ?? 'Náutico' }}"
                            class="w-full h-full object-cover"
                        >
                    @else
                        <svg class="w-4 h-4" style="color: #051e34;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 2a4 4 0 100 8 4 4 0 000-8zM12 10v12M4.93 14.93A10 10 0 0012 22a10 10 0 007.07-7.07M4 18h16"/>
                        </svg>
                    @endif                    
                </div>

                <div>
                    <p class="text-sm font-extrabold leading-none" style="color: #efebe0;">{{ auth('customer')->user()->company->alias_name ?? 'Náutico' }}</p>
                    <p class="text-[11px] leading-none mt-0.5" style="color: #87c2c0;">Painel da Empresa</p>
                </div>

            </div>

            <button
                class="lg:hidden w-7 h-7 flex items-center justify-center rounded-lg"
                style="color: #87c2c0;"
                @click="sidebar = false"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>

        </div>

        {{-- USER --}}
        <div class="px-4 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">

            <div class="user-card flex items-center gap-3 px-3 py-2.5 rounded-xl">
                <div class="avatar-bg w-9 h-9 rounded-xl flex items-center justify-center font-extrabold text-sm shrink-0 overflow-hidden">
                    @if(auth('customer')->user()->avatar)
                        <img
                            src="{{ auth('customer')->user()->url_avatar }}"
                            alt="{{ auth('customer')->user()->name }}"
                            class="w-full h-full object-cover"
                        >
                    @else
                        {{ strtoupper(substr(auth('customer')->user()->name, 0, 1)) }}
                    @endif
                </div>                   
                <div class="overflow-hidden">
                    <a href="{{ route('company.company.users.edit', [auth('customer')->user()->id]) }}">
                        <p class="font-bold text-sm truncate leading-tight" style="color: #efebe0;">
                            {{ auth('customer')->user()->name }}
                        </p>
                        <p class="text-xs truncate leading-tight" style="color: #87c2c0;">
                            {{ auth('customer')->user()->email }}
                        </p>
                    </a>
                </div>  
            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto scrollbar-hide">

            <p class="section-label text-[10px] font-bold uppercase tracking-widest px-3 pb-2">Menu</p>

            
            <a    href="{{ route('company.dashboard') }}"
                @class([
                    'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                    'nav-active' => request()->routeIs('company.dashboard'),
                    'nav-inactive' => !request()->routeIs('company.dashboard'),
                ])
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            @if(auth('customer')->check() && auth('customer')->user()->company?->exists())
                
            <a        href="{{ route('company.company.edit', auth('customer')->user()->company->uuid) }}"
                    @class([
                        'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                        'nav-active' => request()->routeIs('company.company.edit'),
                        'nav-inactive' => !request()->routeIs('company.company.edit'),
                    ])
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Minha Empresa
                </a>
            @else
                
            <a        href="{{ route('company.company.create') }}"
                    class="create-dashed flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Criar Empresa
                </a>
            @endif

            @if (auth('customer')->user()->company?->exists())
                <a    href="{{ route('company.vessels.index') }}"
                    @class([
                        'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                        'nav-active' => request()->routeIs('company.vessels.*'),
                        'nav-inactive' => !request()->routeIs('company.vessels.*'),
                    ])
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 20a2 2 0 002 2h16a2 2 0 002-2M3 12l9-9 9 9M5 12v6h14v-6"/></svg>
                    Embarcações
                </a>

                
                <a    href="{{ route('company.tours.index') }}"
                    @class([
                        'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                        'nav-active' => request()->routeIs('company.tours.*'),
                        'nav-inactive' => !request()->routeIs('company.tours.*'),
                    ])
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/><path d="M3 21h18"/></svg>
                    Passeios
                </a>

                
                <a    href="{{ route('company.bookings.index') }}"
                    @class([
                        'flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                        'nav-active' => request()->routeIs('company.bookings.*'),
                        'nav-inactive' => !request()->routeIs('company.bookings.*'),
                    ])
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Reservas
                </a>

                {{-- FINANCEIRO COM SUBMENU --}}
                <div x-data="{ open: {{ request()->routeIs('company.finance.*') ? 'true' : 'false' }} }">

                    <button
                        @click="open = !open"
                        @class([
                            'w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-bold transition',
                            'nav-active' => request()->routeIs('company.finance.*'),
                            'nav-inactive' => !request()->routeIs('company.finance.*'),
                        ])
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-4h2v4zm0-6h-2V7h2v4z"/>
                        </svg>
                        <span class="flex-1 text-left">Financeiro</span>
                        <svg
                            class="w-3.5 h-3.5 shrink-0 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                        >
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="mt-0.5 ml-3 pl-4 space-y-0.5"
                        style="border-left: 2px solid rgba(135,194,192,0.3);"
                    >
                        
                        <a    href="{{ route('company.finance.index') }}"
                            @class([
                                'flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition',
                                'nav-active' => request()->routeIs('company.finance.index'),
                                'nav-inactive' => !request()->routeIs('company.finance.index'),
                            ])
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Detalhes da conta
                        </a>

                        <a    href="{{ route('company.finance.drawals') }}"
                            @class([
                                'flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition',
                                'nav-active' => request()->routeIs('company.finance.drawals'),
                                'nav-inactive' => !request()->routeIs('company.finance.drawals'),
                            ])
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 21h18M3 10h18M3 6l9-3 9 3M4 10v11M8 10v11M12 10v11M16 10v11M20 10v11"/>
                            </svg>
                            Saques
                        </a>
                        
                        <a    href="{{ route('company.finance.banks') }}"
                            @class([
                                'flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition',
                                'nav-active' => request()->routeIs('company.finance.banks'),
                                'nav-inactive' => !request()->routeIs('company.finance.banks'),
                            ])
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 21h18M3 10h18M3 6l9-3 9 3M4 10v11M8 10v11M12 10v11M16 10v11M20 10v11"/>
                            </svg>
                            Meus Bancos
                        </a>

                        
                        <a    href="{{ route('company.finance.reports.index') }}"
                            @class([
                                'flex items-center gap-2.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition',
                                'nav-active' => request()->routeIs('company.finance.reports'),
                                'nav-inactive' => !request()->routeIs('company.finance.reports'),
                            ])
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Relatórios
                        </a>

                        
                        <a    href="#"
                            @class([
                                'flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold transition',
                                'nav-active' => request()->routeIs('company.finance.contracts'),
                                'nav-inactive' => !request()->routeIs('company.finance.contracts'),
                            ])
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Contratos
                        </a>

                    </div>
                </div>
            @endif            

        </nav>

        {{-- LOGOUT --}}
        <div class="p-3" style="border-top: 1px solid rgba(255,255,255,0.07);">

            <button
                type="button"
                wire:click="logout"
                class="btn-logout w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-sm font-bold transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sair
            </button>

        </div>

    </aside>
</div>
