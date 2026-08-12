<aside class="main-sidebar sidebar-light-teal elevation-4">

    <a class="pt-3 d-flex justify-content-center cursor-pointer">
        <img src="{{ $config->getlogoadmin() }}" alt="{{ $config->app_name }}"
            class="brand-image elevation-3 h-12 w-auto">
    </a>

    <div class="sidebar mt-3">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Painel de Controle</p>
                    </a>
                </li>

                {{-- Configurações --}}
                <li class="nav-item {{ Route::is(['admin.settings', 'admin.sitemap.generator']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is(['admin.settings', 'admin.sitemap.generator']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Configurações <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="nav-link {{ Route::is('admin.settings') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sistema</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sitemap.generator') }}" class="nav-link {{ Route::is('admin.sitemap.generator') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mapa do Site</p>
                            </a>
                        </li>
                    </ul>
                </li>     

                {{-- Embarcações --}}
                <li class="nav-item">
                    <a href="{{ route('admin.companies.index') }}" class="nav-link {{ Route::is('admin.companies.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-industry"></i>
                        <p>Empresas <span class="badge badge-info right">{{ $companiesCount }}</span></p>
                    </a>
                </li>

                {{-- Embarcações --}}
                <li class="nav-item">
                    <a href="{{ route('admin.vessels.index') }}" class="nav-link {{ Route::is('admin.vessels.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ship"></i>
                        <p>Embarcações <span class="badge badge-info right">{{ $vesselsCount }}</span></p>
                    </a>
                </li>

                {{-- Passeios --}}
                <li class="nav-item">
                    <a href="{{ route('admin.tours.index') }}" class="nav-link {{ Route::is('admin.tours.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hiking"></i>
                        <p>Passeios <span class="badge badge-info right">{{ $toursCount }}</span></p>
                    </a>
                </li>

                {{-- Reservas --}}
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ Route::is('admin.bookings.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Reservas <span class="badge badge-info right">{{ $bookingsCount }}</span></p>
                    </a>
                </li>

                {{-- Financeiro --}}
                <li class="nav-item">
                    <a href="{{ route('admin.withdrawals.index') }}" class="nav-link {{ Route::is('admin.withdrawals.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>Financeiro </p>
                    </a>
                </li>

                {{-- Usuários --}}
                <li class="nav-item {{ Route::is('admin.users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuários <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gerentes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.time') }}" class="nav-link {{ Route::is('admin.users.time') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Time</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link {{ Route::is('admin.users.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Posts --}}
                <li class="nav-item {{ Route::is('admin.posts.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-pencil-alt"></i>
                        <p>Posts <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.index') }}" class="nav-link {{ Route::is('admin.posts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Todos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.categories.index') }}" class="nav-link {{ Route::is('admin.posts.categories.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.lixeira') }}" class="nav-link {{ Route::is('admin.posts.lixeira') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lixeira</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Relatórios --}}
                <li class="nav-item {{ Route::is('admin.posts.reports') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.posts.reports') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Relatórios <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.reports') }}" class="nav-link {{ Route::is('admin.posts.reports') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Relatório de Posts</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </div>

</aside>
