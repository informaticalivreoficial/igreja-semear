<aside
    class="fixed inset-y-0 left-0 z-40 flex w-60 flex-col
           bg-gradient-to-b from-forest-900 to-forest-800
           shadow-2xl transition-all duration-300
           -translate-x-full lg:translate-x-0"
    :class="{
        'translate-x-0': mobileOpen,
        '-translate-x-full lg:translate-x-0': !mobileOpen,
        'lg:w-20': collapsed,
        'lg:w-60': !collapsed,
    }"
>

    {{-- Logo --}}
    <div
        class="flex h-16 shrink-0 items-center gap-3 border-b border-white/10 px-4"
        :class="collapsed ? 'lg:justify-center lg:px-2' : 'lg:justify-start'"
    >
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-500/15 ring-1 ring-gold-500/30">
            <i class="fas fa-seedling text-gold-500"></i>
        </div>
        <div class="min-w-0" :class="collapsed ? 'lg:hidden' : ''">
            <p class="truncate text-sm font-bold text-white">{{ $config->app_name ?? 'Comunidade Cristã Semear' }}</p>
            <p class="truncate text-[11px] uppercase tracking-widest text-gold-500/80">Administração</p>
        </div>
    </div>

    {{-- Navegação --}}
    <nav class="sidebar-scroll flex-1 overflow-y-auto overflow-x-hidden px-2.5 py-3">
        <ul class="space-y-0.5">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" wire:navigate @click="closeMobile()"
                   class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                          {{ Route::is('admin.dashboard') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.dashboard') ? 'text-gold-400' : 'text-slate-400' }} fas fa-tachometer-alt"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Painel de Controle</span>
                </a>
            </li>

            {{-- Usuários --}}
            <li x-data="{ open: @js(Route::is('admin.users.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.users.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.users.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-users"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Usuários</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.users.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.users.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.users.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Membros</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $membersCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.time') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.users.time') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Equipe</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $equipeCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.users.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-user-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Novo</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Posts --}}
            <li x-data="{ open: @js(Route::is('admin.posts.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.posts.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.posts.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-pencil-alt"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Posts</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.posts.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.posts.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Todos</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $postsCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.categories.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.posts.categories.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-tags text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.posts.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Novo</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Slides --}}
            <li x-data="{ open: @js(Route::is('admin.slides.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.slides.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.slides.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-images"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Slides</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.slides.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.slides.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.slides.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Todos</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $slidesCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.slides.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.slides.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Novo</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Ministérios --}}
            <li x-data="{ open: @js(Route::is('admin.ministries.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.ministries.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.ministries.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-hands-helping"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Ministérios</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.ministries.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.ministries.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.ministries.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Todos</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $ministriesCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ministries.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.ministries.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Novo</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Eventos --}}
            <li x-data="{ open: @js(Route::is('admin.events.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.events.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.events.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-calendar-alt"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Eventos</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.events.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.events.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.events.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Todos</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $eventsCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.events.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Novo</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Doações --}}
            <li x-data="{ open: @js(Route::is('admin.donations.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.donations.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.donations.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-money-bill-wave"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Doações</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.donations.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.donations.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.donations.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Todas</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $donationsCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.donations.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.donations.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Manual</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Famílias --}}
            <li x-data="{ open: @js(Route::is('admin.families.index')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.families.index') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.families.index') ? 'text-gold-400' : 'text-slate-400' }} fas fa-people-roof"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Famílias</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.families.index') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.families.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.families.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Famílias</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $familiesCount }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Inscrições --}}
            <li>
                <a href="{{ route('admin.registrations.index') }}" wire:navigate @click="closeMobile()"
                   class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                          {{ Route::is('admin.registrations.index') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.registrations.index') ? 'text-gold-400' : 'text-slate-400' }} fas fa-calendar-check"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Inscrições</span>
                    @if($pendingRegistrationsCount > 0)
                        <span class="ml-auto rounded-full bg-amber-500/20 px-2 py-0.5 text-[11px] font-bold text-amber-300" :class="collapsed ? 'lg:hidden' : ''">{{ $pendingRegistrationsCount }}</span>
                    @endif
                </a>
            </li>

            {{-- Pedidos de oração --}}
            <li>
                <a href="{{ route('admin.prayers.index') }}" wire:navigate @click="closeMobile()"
                   class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                          {{ Route::is('admin.prayers.index') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.prayers.index') ? 'text-gold-400' : 'text-slate-400' }} fas fa-praying-hands"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Pedidos de oração</span>
                    @if($pendingPrayersCount > 0)
                        <span class="ml-auto rounded-full bg-amber-500/20 px-2 py-0.5 text-[11px] font-bold text-amber-300" :class="collapsed ? 'lg:hidden' : ''">{{ $pendingPrayersCount }}</span>
                    @endif
                </a>
            </li>

            {{-- Avisos --}}
            <li x-data="{ open: @js(Route::is('admin.announcements.*')) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is('admin.announcements.*') ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is('admin.announcements.*') ? 'text-gold-400' : 'text-slate-400' }} fas fa-bullhorn"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Avisos</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is('admin.announcements.*') ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.announcements.index') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.announcements.index') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-circle text-[5px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Listar Avisos</span>
                            <span class="ml-auto rounded-full bg-white/10 px-2 py-0.5 text-[11px] font-semibold text-slate-300" :class="collapsed ? 'lg:hidden' : ''">{{ $announcementsCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcements.create') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.announcements.create') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-plus text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Cadastrar Aviso</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if (auth()->user()?->isSuperAdmin())
                {{-- Cargos & Permissões --}}
                <li x-data="{ open: @js(Route::is(['admin.roles', 'admin.permissions'])) }">
                    <button type="button" @click="collapsed ? collapsed = false : open = !open"
                            class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                                   {{ Route::is(['admin.roles', 'admin.permissions']) ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <i class="w-5 text-center text-base {{ Route::is(['admin.roles', 'admin.permissions']) ? 'text-gold-400' : 'text-slate-400' }} fas fa-user-shield"></i>
                        <span :class="collapsed ? 'lg:hidden' : ''">Acessos</span>
                        <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is(['admin.roles', 'admin.permissions']) ? 'text-gold-400' : 'text-slate-500' }}"
                           :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                    </button>
                    <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                        <li>
                            <a href="{{ route('admin.roles') }}" wire:navigate @click="closeMobile()"
                               class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                      {{ Route::is('admin.roles') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                                <i class="fas fa-shield-alt text-[11px]"></i>
                                <span :class="collapsed ? 'lg:hidden' : ''">Cargos</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.permissions') }}" wire:navigate @click="closeMobile()"
                               class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                      {{ Route::is('admin.permissions') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                                <i class="fas fa-key text-[11px]"></i>
                                <span :class="collapsed ? 'lg:hidden' : ''">Permissões</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- Configurações --}}
            <li x-data="{ open: @js(Route::is(['admin.settings', 'admin.sitemap.generator'])) }">
                <button type="button" @click="collapsed ? collapsed = false : open = !open"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition
                               {{ Route::is(['admin.settings', 'admin.sitemap.generator']) ? 'bg-gold-500/15 text-gold-400' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="w-5 text-center text-base {{ Route::is(['admin.settings', 'admin.sitemap.generator']) ? 'text-gold-400' : 'text-slate-400' }} fas fa-cog"></i>
                    <span :class="collapsed ? 'lg:hidden' : ''">Configurações</span>
                    <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform duration-200 {{ Route::is(['admin.settings', 'admin.sitemap.generator']) ? 'text-gold-400' : 'text-slate-500' }}"
                       :class="collapsed ? 'lg:hidden' : ''" x-show="open" x-cloak></i>
                </button>
                <ul x-show="open" class="mt-0.5 space-y-0.5 border-l border-white/10 pl-2.5" x-cloak>
                    <li>
                        <a href="{{ route('admin.settings') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.settings') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-sliders-h text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Sistema</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sitemap.generator') }}" wire:navigate @click="closeMobile()"
                           class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm transition
                                  {{ Route::is('admin.sitemap.generator') ? 'text-gold-400' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-sitemap text-[11px]"></i>
                            <span :class="collapsed ? 'lg:hidden' : ''">Mapa do Site</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

    {{-- Rodapé do sidebar --}}
    <div class="shrink-0 border-t border-white/10 px-4 py-3" :class="collapsed ? 'lg:px-2 lg:text-center' : ''">
        <p class="text-[11px] text-slate-500" :class="collapsed ? 'lg:hidden' : ''">
            © {{ date('Y') }} {{ $config->app_name ?? 'Semear' }}
        </p>
        <i class="fas fa-seedling text-slate-600 lg:hidden" :class="collapsed ? '' : 'lg:hidden'"></i>
    </div>

</aside>
