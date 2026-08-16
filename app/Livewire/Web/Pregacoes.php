<?php

namespace App\Livewire\Web;

use App\Models\YoutubeVideo;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Pregacoes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Url]
    public string $busca = '';

    #[Url]
    public string $categoria = '';

    public function updatedBusca(): void
    {
        $this->resetPage();
    }

    public function updatedCategoria(): void
    {
        $this->resetPage();
    }

    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
        $this->resetPage();
    }

    public function render()
    {
        $query = YoutubeVideo::where('status', true)
            ->where('type', YoutubeVideo::TYPE_PREGACAO);

        if ($this->busca !== '') {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->busca}%")
                    ->orWhere('description', 'like', "%{$this->busca}%");
            });
        }

        if ($this->categoria !== '') {
            $query->where('category', $this->categoria);
        }

        $pregacoes = $query->orderByDesc('publish_at')
            ->orderByDesc('id')
            ->paginate(9);

        $categorias = YoutubeVideo::where('status', true)
            ->where('type', YoutubeVideo::TYPE_PREGACAO)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('livewire.web.pregacoes', [
            'pregacoes' => $pregacoes,
            'categorias' => $categorias,
        ]);
    }
}