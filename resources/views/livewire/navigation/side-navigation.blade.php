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
                                <p>Membros <span class="badge badge-info right">{{ $membersCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.time') }}" class="nav-link {{ Route::is('admin.users.time') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Equipe <span class="badge badge-info right">{{ $equipeCount }}</span></p>
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
                                <p>Listar Todos <span class="badge badge-info right">{{ $postsCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.categories.index') }}" class="nav-link {{ Route::is('admin.posts.categories.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.create') }}" class="nav-link {{ Route::is('admin.posts.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Slides --}}
                <li class="nav-item {{ Route::is('admin.slides.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.slides.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Slides <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.slides.index') }}" class="nav-link {{ Route::is('admin.slides.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Todos <span class="badge badge-info right">{{ $slidesCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.slides.create') }}" class="nav-link {{ Route::is('admin.slides.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Ministérios --}}
                <li class="nav-item {{ Route::is('admin.ministries.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.ministries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hands-helping"></i>
                        <p>Ministérios <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.ministries.index') }}" class="nav-link {{ Route::is('admin.ministries.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Todos <span class="badge badge-info right">{{ $ministriesCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ministries.create') }}" class="nav-link {{ Route::is('admin.ministries.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Eventos --}}
                <li class="nav-item {{ Route::is('admin.events.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.events.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Eventos <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.events.index') }}" class="nav-link {{ Route::is('admin.events.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Todos <span class="badge badge-info right">{{ $eventsCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.events.create') }}" class="nav-link {{ Route::is('admin.events.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Novo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Ofertas --}}
                <li class="nav-item {{ Route::is('admin.offerings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('admin.offerings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-heart"></i>
                        <p>Ofertas <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.offerings.index') }}" class="nav-link {{ Route::is('admin.offerings.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Todas <span class="badge badge-info right">{{ $offeringsCount }}</span></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.offerings.create') }}" class="nav-link {{ Route::is('admin.offerings.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar Nova</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @if (auth()->user()?->isSuperAdmin())
                    {{-- Cargos & Permissões --}}
                    <li class="nav-item {{ Route::is(['admin.roles', 'admin.permissions']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Route::is(['admin.roles', 'admin.permissions']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Acessos <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles') }}" class="nav-link {{ Route::is('admin.roles') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cargos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions') }}" class="nav-link {{ Route::is('admin.permissions') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permissões</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

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

            </ul>
        </nav>

    </div>

</aside>
