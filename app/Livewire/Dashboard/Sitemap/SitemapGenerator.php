<?php

namespace App\Livewire\Dashboard\Sitemap;

use Livewire\Component;
use App\Services\Sitemap\SitemapService;
use App\Traits\WithToastr;

class SitemapGenerator extends Component
{
    use WithToastr;
    
    public $totalUrls = 0;
    public $lastGenerated = null;

    public function mount()
    {
        $this->loadInfo();
    }

    public function loadInfo()
    {
        if (file_exists(public_path('sitemap.xml'))) {
            $this->lastGenerated = date('d/m/Y H:i:s', filemtime(public_path('sitemap.xml')));
            
            // Conta URLs no sitemap
            $xml = simplexml_load_file(public_path('sitemap.xml'));
            $this->totalUrls = count($xml->url);
        }
    }

    public function generate()
    {
        try {
            app(SitemapService::class)->generateFile();
            $this->loadInfo();
            $this->toastSuccess('Sitemap gerado com sucesso!');
        } catch (\Exception $e) {
            $this->toastError('Erro ao gerar sitemap: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dashboard.sitemap.sitemap-generator');
    }
}
