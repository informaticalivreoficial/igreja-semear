<?php

namespace App\Livewire\Dashboard\Posts;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public int $perPage = 25;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    protected $updatesQueryString = ['search'];

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public string $filterType = '';

    public string $filterAutor = '';

    public Collection $autores;

    public function mount()
    {
        $this->autores = User::role(['editor', 'admin'])->orderBy('name')->get();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset('search', 'filterType', 'filterAutor');
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function render()
    {
        $title = 'Lista de Posts';

        $posts = Post::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'LIKE', "%{$this->search}%")
                        ->orWhere('content', 'LIKE', "%{$this->search}%")
                        ->orWhere('slug', 'LIKE', "%{$this->search}%");
                });
            })
            ->when($this->filterType !== '', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterAutor !== '', function ($query) {
                $query->where('autor', $this->filterAutor);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.dashboard.posts.posts', [
            'title' => $title,
            'posts' => $posts,
        ]);
    }

    public function toggleStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = ! $post->status;
        $post->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Post?',
            'text' => 'Essa ação não pode ser desfeita.',
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deletePost',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deletePost')]
    public function deletePost($id): void
    {
        $post = Post::findOrFail($id);

        $post->delete();

        $this->dispatch('swal', [
            'title' => 'Excluído!',
            'text' => 'O Post foi removido!',
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }
}
