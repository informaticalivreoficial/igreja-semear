<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-tachometer-alt"></i> Painel de Controle</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item active">Início</span>
        </nav>
    </div>

    {{-- Cards de estatísticas --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-forest-100 text-forest-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $membersCount }}</p>
                    <p class="text-sm text-slate-500">Membros</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver membros <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-green-100 text-green-600">
                    <i class="fas fa-newspaper text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $postsCount }}</p>
                    <p class="text-sm text-slate-500">Posts <span class="text-xs text-slate-400">({{ now()->year }}: {{ $postsYearCount }})</span></p>
                </div>
            </div>
            <a href="{{ route('admin.posts.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver posts <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $eventsCount }}</p>
                    <p class="text-sm text-slate-500">Eventos</p>
                </div>
            </div>
            <a href="{{ route('admin.events.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver eventos <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-sky-100 text-sky-600">
                    <i class="fas fa-church text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $ministriesCount }}</p>
                    <p class="text-sm text-slate-500">Ministérios</p>
                </div>
            </div>
            <a href="{{ route('admin.ministries.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver ministérios <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                    <i class="fas fa-hand-holding-heart text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">R$ {{ number_format($donationsYear, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Doações em {{ now()->year }}</p>
                </div>
            </div>
            <a href="{{ route('admin.donations.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver doações <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                    <i class="fas fa-coins text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">R$ {{ number_format($dizimosTotal, 2, ',', '.') }}</p>
                    <p class="text-sm text-slate-500">Dízimos (total)</p>
                </div>
            </div>
            <a href="{{ route('admin.donations.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver doações <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-slate-200 text-slate-600">
                    <i class="fas fa-images text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $slidesCount }}</p>
                    <p class="text-sm text-slate-500">Slides / Banners</p>
                </div>
            </div>
            <a href="{{ route('admin.slides.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver slides <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-forest-800 text-gold-400">
                    <i class="fas fa-blog text-xl"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-3xl font-bold text-slate-800">{{ $newsCount }} <span class="text-base font-semibold text-slate-400">/ {{ $articlesCount }}</span></p>
                    <p class="text-sm text-slate-500">Notícias / Artigos</p>
                </div>
            </div>
            <a href="{{ route('admin.posts.index') }}" wire:navigate
               class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-5 py-2.5 text-xs font-medium text-forest-600 transition hover:bg-forest-50">
                Ver posts <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>

    {{-- Tabelas --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

        <div class="card overflow-hidden">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-fire text-amber-500"></i> Posts mais vistos</h3>
            </div>
            <div class="card-body p-0">
                @if ($topposts->count())
                    <div class="overflow-x-auto">
                        <table class="table table-hover">
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
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" wire:navigate class="font-medium text-forest-600 hover:underline">
                                                {{ $post->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ ucfirst($post->type) }}</span>
                                        </td>
                                        <td class="text-center font-semibold">{{ $post->views }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5">
                        <div class="alert alert-info m-0">Nenhum post cadastrado ainda.</div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check text-green-600"></i> Próximos eventos</h3>
            </div>
            <div class="card-body p-0">
                @if ($upcomingEvents->count())
                    <div class="overflow-x-auto">
                        <table class="table table-hover">
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
                                            <a href="{{ route('admin.events.edit', $event->id) }}" wire:navigate class="font-medium text-forest-600 hover:underline">
                                                {{ $event->title }}
                                            </a>
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
                    </div>
                @else
                    <div class="p-5">
                        <div class="alert alert-info m-0">Nenhum evento futuro cadastrado.</div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
    @if (session('toast'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toast = @js(session('toast'));

                if (window.showToast) {
                    window.showToast(toast.type, toast.message);
                }
            });
        </script>
    @endif
@endpush
