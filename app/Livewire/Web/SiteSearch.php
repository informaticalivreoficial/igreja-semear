<?php

namespace App\Livewire\Web;

use App\Models\Post;
use Livewire\Component;

class SiteSearch extends Component
{
    public string $term = '';

    public function updatedTerm()
    {
        $this->term = trim($this->term);
    }

    public function getResultsProperty()
    {
        $term = $this->term;

        if (mb_strlen($term) < 2) {
            return collect();
        }

        return Post::whereIn('type', ['artigo', 'noticia'])
            ->postson()
            ->with(['categoriaObject'])
            ->where(function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%")
                    ->orWhere('content', 'LIKE', "%{$term}%");
            })
            ->orderByDesc('publish_at')
            ->limit(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.web.site-search');
    }
}
