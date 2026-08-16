<div x-data="{ videoModal: false, playlistModal: false }" x-cloak
    @open-video-modal.window="videoModal = true; setTimeout(initYoutubeFlatpickr, 60)"
    @close-video-modal.window="videoModal = false"
    @open-playlist-modal.window="playlistModal = true; setTimeout(initYoutubeFlatpickr, 60)"
    @close-playlist-modal.window="playlistModal = false">

    @section('title', $title)

    <div class="content-header">
        <h1><i class="fab fa-youtube"></i> YouTube</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">YouTube</span>
        </nav>
    </div>

    <div x-data="{
            tab: @entangle('activeTab'),
            init() {
                if (!this.tab) this.tab = 'videos';
            }
        }" class="w-full">

        <!-- Abas -->
        <div class="mb-6 flex flex-wrap gap-1 border-b-2 border-forest-100">
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'videos' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'videos'">
                <i class="fas fa-video mr-1.5"></i> Vídeos
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'playlists' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'playlists'">
                <i class="fas fa-list mr-1.5"></i> Playlists
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'canal' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'canal'">
                <i class="fab fa-youtube mr-1.5"></i> Canal
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'configuracoes' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'configuracoes'">
                <i class="fas fa-sliders-h mr-1.5"></i> Configurações
            </button>
        </div>

        <!-- Aba Vídeos -->
        <div x-show="tab === 'videos'" x-cloak x-transition>
            <div class="card">
                <div class="card-header">
                    <div class="flex flex-1 flex-wrap items-center gap-2">
                        <input type="text"
                            wire:model.live.debounce.500ms="search"
                            class="form-control form-control-sm min-w-40 flex-1"
                            placeholder="Pesquisar vídeo">

                        <select wire:model.live="typeFilter" class="form-control form-control-sm w-40">
                            <option value="">Todos os tipos</option>
                            <option value="culto">Culto</option>
                            <option value="pregacao">Pregação</option>
                        </select>

                        <select wire:model.live="categoryFilter" class="form-control form-control-sm w-44">
                            <option value="">Todas as categorias</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn btn-sm btn-primary shrink-0" wire:click="openVideoForm()">
                        <i class="fas fa-plus"></i> Novo Vídeo
                    </button>
                </div>

                <div class="card-body p-0 sm:p-5">
                    @if ($videos->count())
                        <div class="overflow-x-auto">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Thumb</th>
                                        <th>Título</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Ao Vivo</th>
                                        <th class="text-center">Data</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $video)
                                    <tr class="{{ $video->status ? '' : 'bg-amber-50/70' }}">
                                        <td class="text-center">
                                            <img src="{{ $video->thumbnail() }}" alt="{{ $video->title }}"
                                                class="h-10 w-16 rounded object-cover">
                                        </td>
                                        <td>
                                            <span class="font-medium text-slate-800">{{ $video->title }}</span>
                                            @if ($video->is_live)
                                                <span class="badge badge-danger ml-1"><i class="fas fa-circle text-red-100 mr-1"></i> AO VIVO</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $video->type === 'culto' ? 'Culto' : 'Pregação' }}</span>
                                        </td>
                                        <td class="text-center">{{ $video->category ?? '—' }}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-xs {{ $video->is_live ? 'btn-danger' : 'btn-default' }}"
                                                title="{{ $video->is_live ? 'Tirar do ar' : 'Colocar ao vivo' }}"
                                                wire:click="toggleVideoLive({{ $video->id }})">
                                                <i class="fas fa-broadcast-tower"></i>
                                            </button>
                                        </td>
                                        <td class="text-center whitespace-nowrap">{{ $video->publish_at?->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <x-forms.switch-toggle
                                                wire:key="safe-switch-video-{{ $video->id }}"
                                                wire:click="toggleVideoStatus({{ $video->id }})"
                                                :checked="$video->status"
                                                size="sm"
                                                color="green"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a target="_blank" title="Ver no YouTube" href="{{ $video->watchUrl() }}"
                                                    class="btn btn-xs btn-default"><i class="fab fa-youtube"></i></a>
                                                <button type="button" class="btn btn-xs btn-default"
                                                    title="Editar Vídeo"
                                                    wire:click="openVideoForm({{ $video->id }})">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger"
                                                    title="Excluir Vídeo"
                                                    wire:click="setDeleteVideoId({{ $video->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($videos->hasMorePages())
                            <div class="mt-4 text-center">
                                <button wire:click="loadMore" class="btn btn-primary">
                                    <i class="fas fa-spinner mr-2"></i> Carregar mais
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Aba Playlists -->
        <div x-show="tab === 'playlists'" x-cloak x-transition>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Playlists do canal</h5>
                    <button type="button" class="btn btn-sm btn-primary shrink-0" wire:click="openPlaylistForm()">
                        <i class="fas fa-plus"></i> Nova Playlist
                    </button>
                </div>

                <div class="card-body p-0 sm:p-5">
                    @if ($playlists->count())
                        <div class="overflow-x-auto">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Capa</th>
                                        <th>Título</th>
                                        <th>ID</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($playlists as $playlist)
                                    <tr class="{{ $playlist->status ? '' : 'bg-amber-50/70' }}">
                                        <td class="text-center">
                                            <img src="{{ $playlist->thumbnail() }}" alt="{{ $playlist->title }}"
                                                class="h-10 w-16 rounded object-cover">
                                        </td>
                                        <td class="text-slate-800">{{ $playlist->title }}</td>
                                        <td class="font-mono text-xs">{{ $playlist->youtube_id }}</td>
                                        <td class="text-center">
                                            <x-forms.switch-toggle
                                                wire:key="safe-switch-playlist-{{ $playlist->id }}"
                                                wire:click="togglePlaylistStatus({{ $playlist->id }})"
                                                :checked="$playlist->status"
                                                size="sm"
                                                color="green"
                                            />
                                        </td>
                                        <td class="text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a target="_blank" title="Ver no YouTube" href="{{ $playlist->watchUrl() }}"
                                                    class="btn btn-xs btn-default"><i class="fab fa-youtube"></i></a>
                                                <button type="button" class="btn btn-xs btn-default"
                                                    title="Editar Playlist"
                                                    wire:click="openPlaylistForm({{ $playlist->id }})">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger"
                                                    title="Excluir Playlist"
                                                    wire:click="setDeletePlaylistId({{ $playlist->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info p-3">
                            Nenhuma playlist cadastrada.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Aba Canal -->
        <div x-show="tab === 'canal'" x-cloak x-transition>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fab fa-youtube mr-1.5"></i> Canal oficial no YouTube</h5>
                </div>
                <div class="card-body text-slate-600">
                    <form wire:submit.prevent="saveChannel" autocomplete="off">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                            <div class="form-group">
                                <label class="labelforms"><b>Nome do canal</b></label>
                                <input type="text" class="form-control" placeholder="Ex.: Comunidade Cristã Semear"
                                    wire:model="youtubeChannelName">
                                @error('youtubeChannelName')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>URL do canal</b></label>
                                <input type="url" class="form-control"
                                    placeholder="https://www.youtube.com/@canal"
                                    wire:model="youtubeChannel">
                                @error('youtubeChannel')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 rounded-lg border border-forest-100 bg-forest-50/60 p-3 text-sm">
                            <i class="fas fa-info-circle text-forest-600 mr-1.5"></i>
                            A URL do canal é usada nos botões de acesso (home, cultos online e pregações) e no rodapé do site.
                        </div>

                        <div class="flex justify-end pb-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Salvar Canal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Aba Configurações -->
        <div x-show="tab === 'configuracoes'" x-cloak x-transition>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-sliders-h mr-1.5"></i> Configurações de transmissão</h5>
                </div>
                <div class="card-body text-slate-600">
                    <form wire:submit.prevent="saveConfig" autocomplete="off">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                            <div class="form-group">
                                <label class="labelforms"><b>Próxima transmissão</b></label>
                                <input type="text"
                                    class="form-control @error('nextTransmissionAt') is-invalid @enderror"
                                    placeholder="dd/mm/aaaa hh:mm"
                                    wire:model="nextTransmissionAt"
                                    x-init="initYoutubeFlatpickr()"
                                    data-youtube-flatpickr>
                                @error('nextTransmissionAt')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Deixe em branco para não exibir aviso de próxima transmissão na página "Cultos Online".
                                </small>
                            </div>
                        </div>

                        <div class="flex justify-end pb-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Vídeo -->
    <div x-show="videoModal" x-cloak
        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/60 p-4"
        x-transition.opacity>
        <div class="w-full max-w-2xl overflow-hidden rounded-xl bg-white shadow-2xl"
            @click.outside="videoModal = false">
            <div class="flex items-center justify-between border-b border-slate-200 bg-forest-50/60 px-5 py-4">
                <h5 class="mb-0 text-lg font-semibold text-forest-800">
                    <i class="fas fa-video mr-2"></i>{{ $video?->id ? 'Editar Vídeo' : 'Novo Vídeo' }}
                </h5>
                <button type="button" class="text-slate-400 transition hover:text-slate-700" @click="videoModal = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveVideo" class="max-h-[75vh] overflow-y-auto p-5">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <div class="form-group md:col-span-2">
                        <label class="labelforms"><b>Título</b></label>
                        <input type="text" class="form-control @error('videoTitle') is-invalid @enderror"
                            placeholder="Título do vídeo" wire:model="videoTitle">
                        @error('videoTitle')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>ID ou link do YouTube</b></label>
                        <input type="text" class="form-control @error('videoYoutubeId') is-invalid @enderror"
                            placeholder="dQw4w9WgXcQ ou https://youtu.be/..." wire:model="videoYoutubeId">
                        @error('videoYoutubeId')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Tipo</b></label>
                        <select class="form-control" wire:model="videoType">
                            <option value="culto">Culto</option>
                            <option value="pregacao">Pregação</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Categoria</b></label>
                        <div class="flex gap-2">
                            <input type="text" class="form-control" placeholder="Ex.: Estudos bíblicos"
                                wire:model="videoCategory" list="youtubeCategories">
                            <datalist id="youtubeCategories">
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Publicado em</b></label>
                        <input type="date" class="form-control" wire:model="videoPublishAt">
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Agendada para</b> <span class="text-xs text-slate-400">(opcional)</span></label>
                        <input type="text" class="form-control" placeholder="dd/mm/aaaa hh:mm"
                            wire:model="videoScheduledAt" x-init="initYoutubeFlatpickr()"
                            data-youtube-flatpickr>
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Capa</b></label>
                        <input type="file" accept="image/*" class="block w-full text-sm text-slate-500
                            file:mr-4 file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2
                            file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
                            wire:model="videoCover">
                        @error('videoCover')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                        @if ($videoCover instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                            <img src="{{ $videoCover->temporaryUrl() }}" alt="Pré-visualização"
                                class="mt-2 w-full rounded-lg border border-slate-200 object-cover" style="max-height: 140px;">
                        @elseif ($existingVideoCover)
                            <img src="{{ asset('storage/'.$existingVideoCover) }}" alt="Capa atual"
                                class="mt-2 rounded-lg border border-slate-200 object-cover" style="max-height: 140px;">
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Status</b></label>
                        <div class="space-y-2 pt-1">
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="checkbox" wire:model="videoStatus"
                                    class="h-4 w-4 rounded border-slate-300 text-forest-600 focus:ring-forest-500">
                                <span class="text-sm text-slate-600">Publicado no site</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="checkbox" wire:model="videoIsLive"
                                    class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-red-600"><i class="fas fa-circle mr-1"></i>Transmissão ao vivo agora</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>Descrição</b></label>
                    <textarea rows="3" class="form-control" placeholder="Descrição do vídeo"
                        wire:model="videoDescription"></textarea>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" class="btn btn-default" @click="videoModal = false">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check mr-2"></i>{{ $video?->id ? 'Atualizar Vídeo' : 'Cadastrar Vídeo' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Playlist -->
    <div x-show="playlistModal" x-cloak
        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/60 p-4"
        x-transition.opacity>
        <div class="w-full max-w-2xl overflow-hidden rounded-xl bg-white shadow-2xl"
            @click.outside="playlistModal = false">
            <div class="flex items-center justify-between border-b border-slate-200 bg-forest-50/60 px-5 py-4">
                <h5 class="mb-0 text-lg font-semibold text-forest-800">
                    <i class="fas fa-list mr-2"></i>{{ $playlist?->id ? 'Editar Playlist' : 'Nova Playlist' }}
                </h5>
                <button type="button" class="text-slate-400 transition hover:text-slate-700" @click="playlistModal = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="savePlaylist" class="max-h-[75vh] overflow-y-auto p-5">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                    <div class="form-group">
                        <label class="labelforms"><b>Título</b></label>
                        <input type="text" class="form-control @error('playlistTitle') is-invalid @enderror"
                            placeholder="Título da playlist" wire:model="playlistTitle">
                        @error('playlistTitle')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>ID ou link da playlist</b></label>
                        <input type="text" class="form-control @error('playlistYoutubeId') is-invalid @enderror"
                            placeholder="PL4o29bINVT4G..." wire:model="playlistYoutubeId">
                        @error('playlistYoutubeId')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Capa</b></label>
                        <input type="file" accept="image/*" class="block w-full text-sm text-slate-500
                            file:mr-4 file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2
                            file:text-sm file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
                            wire:model="playlistCover">
                        @error('playlistCover')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                        @if ($playlistCover instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                            <img src="{{ $playlistCover->temporaryUrl() }}" alt="Pré-visualização"
                                class="mt-2 w-full rounded-lg border border-slate-200 object-cover" style="max-height: 140px;">
                        @elseif ($existingPlaylistCover)
                            <img src="{{ asset('storage/'.$existingPlaylistCover) }}" alt="Capa atual"
                                class="mt-2 rounded-lg border border-slate-200 object-cover" style="max-height: 140px;">
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Status</b></label>
                        <label class="flex cursor-pointer items-center gap-2 pt-1">
                            <input type="checkbox" wire:model="playlistStatus"
                                class="h-4 w-4 rounded border-slate-300 text-forest-600 focus:ring-forest-500">
                            <span class="text-sm text-slate-600">Ativa</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>Descrição</b></label>
                    <textarea rows="3" class="form-control" placeholder="Descrição da playlist"
                        wire:model="playlistDescription"></textarea>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" class="btn btn-default" @click="playlistModal = false">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check mr-2"></i>{{ $playlist?->id ? 'Atualizar Playlist' : 'Cadastrar Playlist' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function initYoutubeFlatpickr() {
                document.querySelectorAll('[data-youtube-flatpickr]').forEach(input => {
                    if (input._flatpickr) input._flatpickr.destroy();

                    input._flatpickr = flatpickr(input, {
                        enableTime: true,
                        time_24hr: true,
                        dateFormat: 'd/m/Y H:i',
                        allowInput: true,
                        minuteIncrement: 5,
                        defaultDate: input.value || null,
                        onChange: function (selectedDates, dateStr) {
                            input.dispatchEvent(new Event('input'));
                        },
                        locale: {
                            firstDayOfWeek: 1,
                            weekdays: {
                                shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                                longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
                            },
                            months: {
                                shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                            },
                            today: 'Hoje',
                            clear: 'Limpar',
                        },
                    });
                });
            }

            document.addEventListener('livewire:navigated', initYoutubeFlatpickr);
        </script>
    @endpush
</div>