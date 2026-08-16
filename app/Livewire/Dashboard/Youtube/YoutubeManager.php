<?php

namespace App\Livewire\Dashboard\Youtube;

use App\Models\Config;
use App\Models\YoutubePlaylist;
use App\Models\YoutubeVideo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class YoutubeManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $activeTab = 'videos';

    protected $paginationTheme = 'tailwind';

    public int $perPage = 25;

    public string $search = '';

    public string $typeFilter = '';

    public string $categoryFilter = '';

    // Vídeo form
    public $video = null;

    public string $videoTitle = '';

    public ?string $videoDescription = '';

    public string $videoYoutubeId = '';

    public string $videoType = YoutubeVideo::TYPE_CULTO;

    public ?string $videoCategory = '';

    public bool $videoIsLive = false;

    public ?string $videoScheduledAt = '';

    public bool $videoStatus = true;

    public ?string $videoPublishAt = '';

    public $videoCover = null;

    public ?string $existingVideoCover = '';

    // Playlist form
    public $playlist = null;

    public string $playlistTitle = '';

    public ?string $playlistDescription = '';

    public string $playlistYoutubeId = '';

    public bool $playlistStatus = true;

    public $playlistCover = null;

    public ?string $existingPlaylistCover = '';

    // Configurações
    public string $youtubeChannel = '';

    public ?string $youtubeChannelName = '';

    public ?string $nextTransmissionAt = '';

    public array $categories = [];

    public string $categoryInput = '';

    protected $queryString = ['activeTab' => ['as' => 'tab'], 'search'];

    public function mount(): void
    {
        $config = Config::find(1);
        $this->youtubeChannel = $config?->youtube ?? '';
        $this->youtubeChannelName = $config?->youtube_channel_name ?? '';
        $this->nextTransmissionAt = $config?->next_transmission_at
            ? $config->next_transmission_at->format('d/m/Y H:i')
            : '';
        $this->categories = $this->existingCategories();
    }

    protected function existingCategories(): array
    {
        return YoutubeVideo::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->values()
            ->toArray();
    }

    protected function rules(): array
    {
        return [
            'videoTitle' => ['required', 'string', 'max:255'],
            'videoYoutubeId' => ['required', 'string', 'max:60'],
            'videoDescription' => ['nullable', 'string'],
            'videoCategory' => ['nullable', 'string', 'max:100'],
            'videoCover' => ['nullable', 'image', 'max:4096'],
        ];
    }

    protected function messages(): array
    {
        return [
            'videoTitle.required' => 'O título é obrigatório.',
            'videoYoutubeId.required' => 'O ID ou link do YouTube é obrigatório.',
            'videoCover.image' => 'A capa deve ser uma imagem.',
            'videoCover.max' => 'A capa deve ter no máximo 4MB.',
        ];
    }

    public function updatedVideoIsLive(): void
    {
        if ($this->videoIsLive) {
            $this->videoStatus = true;
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function addCategory(): void
    {
        $this->categoryInput = trim($this->categoryInput);
        if ($this->categoryInput !== '' && ! in_array($this->categoryInput, $this->categories, true)) {
            $this->categories[] = $this->categoryInput;
        }
        $this->videoCategory = $this->categoryInput;
        $this->categoryInput = '';
    }

    public function removeCategory(string $category): void
    {
        $this->categories = array_values(array_filter(
            $this->categories,
            fn ($c) => $c !== $category
        ));
        if ($this->videoCategory === $category) {
            $this->videoCategory = '';
        }
    }

    public function openVideoForm($id = null): void
    {
        $this->resetErrorBag();
        $this->videoCover = null;
        $this->existingVideoCover = '';

        if ($id) {
            $video = YoutubeVideo::findOrFail($id);
            $this->video = $video;
            $this->videoTitle = $video->title;
            $this->videoDescription = $video->description;
            $this->videoYoutubeId = $video->youtube_id;
            $this->videoType = $video->type;
            $this->videoCategory = $video->category ?? '';
            $this->videoIsLive = (bool) $video->is_live;
            $this->videoScheduledAt = $video->scheduled_at ? $video->scheduled_at->format('d/m/Y H:i') : '';
            $this->videoStatus = (bool) $video->status;
            $this->videoPublishAt = $video->publish_at ? $video->publish_at->format('Y-m-d') : now()->format('Y-m-d');
            $this->existingVideoCover = $video->cover;
        } else {
            $this->video = null;
            $this->videoTitle = '';
            $this->videoDescription = '';
            $this->videoYoutubeId = '';
            $this->videoType = YoutubeVideo::TYPE_CULTO;
            $this->videoCategory = '';
            $this->videoIsLive = false;
            $this->videoScheduledAt = '';
            $this->videoStatus = true;
            $this->videoPublishAt = now()->format('Y-m-d');
        }

        $this->dispatch('open-video-modal');
    }

    public function saveVideo(): void
    {
        $this->validate();

        $data = [
            'title' => $this->videoTitle,
            'description' => $this->videoDescription,
            'youtube_id' => $this->normalizeYoutubeId($this->videoYoutubeId),
            'type' => $this->videoType,
            'category' => $this->videoCategory !== '' ? $this->videoCategory : null,
            'is_live' => $this->videoIsLive,
            'scheduled_at' => $this->videoScheduledAt !== ''
                ? Carbon::createFromFormat('d/m/Y H:i', $this->videoScheduledAt)
                : null,
            'status' => $this->videoStatus,
            'publish_at' => $this->parseVideoPublishDate($this->videoPublishAt),
        ];

        $video = $this->video ?? new YoutubeVideo();

        if (! $this->video) {
            $data['created_by'] = auth()->id();
        }

        if ($this->videoCover) {
            $data['cover'] = $this->storeCoverWebp($this->videoCover, 'videos');
            if ($video->cover && $video->cover !== $data['cover']) {
                $this->deleteCover($video->cover);
            }
        }

        $video->fill($data);
        $video->save();

        if ($this->videoIsLive) {
            YoutubeVideo::where('id', '!=', $video->id)->where('is_live', true)->update(['is_live' => false]);
        }

        $this->videoCover = null;
        $this->existingVideoCover = $video->cover;

        $this->dispatch('close-video-modal');
        $this->dispatch('swal', [
            'title' => $this->video ? 'Atualizado!' : 'Cadastrado!',
            'text' => $this->video ? 'O vídeo foi atualizado.' : 'O vídeo foi cadastrado.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);

        $this->reset('video');
        $this->categories = $this->existingCategories();
    }

    public function toggleVideoLive($id): void
    {
        $video = YoutubeVideo::findOrFail($id);
        $video->is_live = ! $video->is_live;
        if ($video->is_live) {
            $video->status = true;
            YoutubeVideo::where('id', '!=', $video->id)->update(['is_live' => false]);
        }
        $video->save();
    }

    public function toggleVideoStatus($id): void
    {
        $video = YoutubeVideo::findOrFail($id);
        $video->status = ! $video->status;
        $video->save();
    }

    public function setDeleteVideoId($id): void
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir vídeo?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteVideo',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteVideo')]
    public function deleteVideo($id): void
    {
        $video = YoutubeVideo::findOrFail($id);
        if ($video->cover) {
            $this->deleteCover($video->cover);
        }
        $video->delete();
        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'O vídeo foi removido.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function openPlaylistForm($id = null): void
    {
        $this->resetErrorBag();
        $this->playlistCover = null;
        $this->existingPlaylistCover = '';

        if ($id) {
            $playlist = YoutubePlaylist::findOrFail($id);
            $this->playlist = $playlist;
            $this->playlistTitle = $playlist->title;
            $this->playlistDescription = $playlist->description;
            $this->playlistYoutubeId = $playlist->youtube_id;
            $this->playlistStatus = (bool) $playlist->status;
            $this->existingPlaylistCover = $playlist->cover;
        } else {
            $this->playlist = null;
            $this->playlistTitle = '';
            $this->playlistDescription = '';
            $this->playlistYoutubeId = '';
            $this->playlistStatus = true;
        }

        $this->dispatch('open-playlist-modal');
    }

    public function savePlaylist(): void
    {
        $this->validate([
            'playlistTitle' => ['required', 'string', 'max:255'],
            'playlistYoutubeId' => ['required', 'string', 'max:60'],
            'playlistCover' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = [
            'title' => $this->playlistTitle,
            'description' => $this->playlistDescription,
            'youtube_id' => $this->normalizeYoutubeId($this->playlistYoutubeId),
            'status' => $this->playlistStatus,
        ];

        $playlist = $this->playlist ?? new YoutubePlaylist();

        if ($this->playlistCover) {
            $data['cover'] = $this->storeCoverWebp($this->playlistCover, 'playlists');
            if ($playlist->cover && $playlist->cover !== $data['cover']) {
                $this->deleteCover($playlist->cover);
            }
        }

        $playlist->fill($data);
        $playlist->save();

        $this->playlistCover = null;
        $this->existingPlaylistCover = $playlist->cover;

        $this->dispatch('close-playlist-modal');
        $this->dispatch('swal', [
            'title' => $this->playlist ? 'Atualizada!' : 'Cadastrada!',
            'text' => $this->playlist ? 'A playlist foi atualizada.' : 'A playlist foi cadastrada.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);

        $this->reset('playlist');
    }

    public function togglePlaylistStatus($id): void
    {
        $playlist = YoutubePlaylist::findOrFail($id);
        $playlist->status = ! $playlist->status;
        $playlist->save();
    }

    public function setDeletePlaylistId($id): void
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir playlist?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deletePlaylist',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deletePlaylist')]
    public function deletePlaylist($id): void
    {
        $playlist = YoutubePlaylist::findOrFail($id);
        if ($playlist->cover) {
            $this->deleteCover($playlist->cover);
        }
        $playlist->delete();
        $this->dispatch('swal', [
            'title' => 'Excluída!',
            'text' => 'A playlist foi removida.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function saveChannel(): void
    {
        $this->validate([
            'youtubeChannel' => ['nullable', 'url'],
            'youtubeChannelName' => ['nullable', 'string', 'max:255'],
        ]);

        Config::where('id', 1)->update([
            'youtube' => $this->youtubeChannel,
            'youtube_channel_name' => $this->youtubeChannelName,
        ]);

        $this->dispatch('swal', [
            'title' => 'Salvo!',
            'text' => 'Canal atualizado com sucesso.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function saveConfig(): void
    {
        $this->validate([
            'nextTransmissionAt' => ['nullable', 'string'],
        ]);

        Config::where('id', 1)->update([
            'next_transmission_at' => $this->nextTransmissionAt !== ''
                ? Carbon::createFromFormat('d/m/Y H:i', $this->nextTransmissionAt)
                : null,
        ]);

        $this->dispatch('swal', [
            'title' => 'Salvo!',
            'text' => 'Configurações atualizadas.',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    protected function normalizeYoutubeId(string $value): string
    {
        $value = trim($value);
        if (preg_match('/(?:v=|youtu\.be\/|embed\/|shorts\/)([\w-]{11})/', $value, $m)) {
            return $m[1];
        }
        if (preg_match('/^([\w-]{11})$/', $value)) {
            return $value;
        }
        if (preg_match('/(?:list=)([\w-]+)/', $value, $m)) {
            return $m[1];
        }

        return $value;
    }

    protected function parseVideoPublishDate(?string $value): ?Carbon
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        foreach (['d/m/Y', 'Y-m-d'] as $format) {
            try {
                return Carbon::createFromFormat('!'.$format, $value);
            } catch (\Throwable) {
                // tenta o próximo formato
            }
        }

        return null;
    }

    protected function storeCoverWebp($file, string $folder): string
    {
        $path = $file->store('youtube/'.$folder, 'public');

        return $path;
    }

    protected function deleteCover(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function render()
    {
        $title = 'YouTube';

        $videos = YoutubeVideo::with('creator')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'LIKE', "%{$this->search}%")
                        ->orWhere('youtube_id', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->typeFilter !== '', function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->categoryFilter !== '', function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('is_live', 'desc')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        $playlists = YoutubePlaylist::orderBy('order')->orderByDesc('id')->get();

        $config = Config::find(1);

        return view('livewire.dashboard.youtube.youtube-manager', [
            'title' => $title,
            'videos' => $videos,
            'playlists' => $playlists,
            'config' => $config,
        ]);
    }
}