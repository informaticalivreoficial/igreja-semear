<?php

namespace App\Livewire\Web;

use App\Models\Config;
use App\Models\YoutubeVideo;
use Livewire\Component;
use Livewire\WithPagination;

class CultosOnline extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 9;

    public function loadMore()
    {
        $this->perPage += 9;
    }

    public function render()
    {
        $config = Config::find(1);

        $aoVivo = YoutubeVideo::where('status', true)
            ->where('is_live', true)
            ->orderByDesc('id')
            ->first();

        $ultimosCultos = YoutubeVideo::where('status', true)
            ->where('type', YoutubeVideo::TYPE_CULTO)
            ->orderByDesc('publish_at')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        $proximaTransmissao = $config?->next_transmission_at;

        return view('livewire.web.cultos-online', [
            'config' => $config,
            'aoVivo' => $aoVivo,
            'ultimosCultos' => $ultimosCultos,
            'proximaTransmissao' => $proximaTransmissao,
        ]);
    }
}