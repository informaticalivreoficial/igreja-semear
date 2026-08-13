<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-tachometer-alt mr-2"></i> Painel de Controle</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Início</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $membersCount }}</h3>
                    <p>Membros</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">Ver membros <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $postsCount }}</h3>
                    <p>Posts ({{ now()->year }}: {{ $postsYearCount }})</p>
                </div>
                <div class="icon"><i class="fas fa-newspaper"></i></div>
                <a href="{{ route('admin.posts.index') }}" class="small-box-footer">Ver posts <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $eventsCount }}</h3>
                    <p>Eventos</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <a href="{{ route('admin.events.index') }}" class="small-box-footer">Ver eventos <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $ministriesCount }}</h3>
                    <p>Ministérios</p>
                </div>
                <div class="icon"><i class="fas fa-church"></i></div>
                <a href="{{ route('admin.ministries.index') }}" class="small-box-footer">Ver ministérios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>R$ {{ number_format($offeringsYear, 2, ',', '.') }}</h3>
                    <p>Ofertas em {{ now()->year }}</p>
                </div>
                <div class="icon"><i class="fas fa-hand-holding-heart"></i></div>
                <a href="{{ route('admin.offerings.index') }}" class="small-box-footer">Ver ofertas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>R$ {{ number_format($dizimosTotal, 2, ',', '.') }}</h3>
                    <p>Dízimos (total)</p>
                </div>
                <div class="icon"><i class="fas fa-coins"></i></div>
                <a href="{{ route('admin.offerings.index') }}" class="small-box-footer">Ver ofertas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $slidesCount }}</h3>
                    <p>Slides / Banners</p>
                </div>
                <div class="icon"><i class="fas fa-images"></i></div>
                <a href="{{ route('admin.slides.index') }}" class="small-box-footer">Ver slides <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $newsCount }} <small style="font-size: 14px;">/ {{ $articlesCount }}</small></h3>
                    <p>Notícias / Artigos</p>
                </div>
                <div class="icon"><i class="fas fa-blog"></i></div>
                <a href="{{ route('admin.posts.index') }}" class="small-box-footer">Ver posts <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-fire mr-2"></i> Posts mais vistos</h3>
                </div>
                <div class="card-body p-0">
                    @if ($topposts->count())
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topposts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.posts.edit', $post->id) }}">{{ $post->title }}</a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ ucfirst($post->type) }}</span>
                                        </td>
                                        <td class="text-center">{{ $post->views }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-3">
                            <div class="alert alert-info m-0">Nenhum post cadastrado ainda.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i> Próximos eventos</h3>
                </div>
                <div class="card-body p-0">
                    @if ($upcomingEvents->count())
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th class="text-center">Data</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcomingEvents as $event)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.events.edit', $event->id) }}">{{ $event->title }}</a>
                                        </td>
                                        <td class="text-center">{{ $event->start_at?->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            @if ($event->status)
                                                <span class="badge badge-success">Ativo</span>
                                            @else
                                                <span class="badge badge-secondary">Inativo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-3">
                            <div class="alert alert-info m-0">Nenhum evento futuro cadastrado.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
