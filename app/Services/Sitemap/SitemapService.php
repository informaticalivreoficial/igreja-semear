<?php

namespace App\Services\Sitemap;

use App\Models\Post;
use Carbon\Carbon;

class SitemapService
{
    public function build(): string
    {
        $base = url('/');

        $items = [
            [$base.'/', Carbon::now()->toDateString(), 'daily', '1.0'],
            [$base.'/pagina/sobre-a-igreja', null, 'monthly', '0.8'],
            [$base.'/ministerios', null, 'monthly', '0.8'],
            [$base.'/pagina/cultos-e-horarios', null, 'weekly', '0.8'],
            [$base.'/pagina/pregacoes', null, 'monthly', '0.6'],
            [$base.'/pagina/galeria-de-fotos', null, 'monthly', '0.5'],
            [$base.'/pagina/localizacao', null, 'monthly', '0.6'],
            [$base.'/pagina/doacoes', null, 'monthly', '0.6'],
            [$base.'/eventos', null, 'weekly', '0.7'],
            [$base.'/blog', null, 'daily', '0.9'],
            [$base.'/noticias', null, 'daily', '0.9'],
            [$base.'/pedido-de-oracao', null, 'monthly', '0.6'],
            [$base.'/cultos-online', null, 'daily', '0.7'],
            [$base.'/pregacoes', null, 'daily', '0.7'],
            [$base.'/atendimento', null, 'monthly', '0.5'],
            [$base.'/politica-de-privacidade', null, 'yearly', '0.3'],
        ];

        $posts = Post::where('status', 1)
            ->whereIn('type', ['artigo', 'noticia'])
            ->get();

        foreach ($posts as $post) {
            $route = $post->type === 'noticia' ? 'web.noticia' : 'web.blog.artigo';
            $items[] = [
                route($route, ['slug' => $post->slug]),
                optional($post->publish_at)->toDateString(),
                $post->type === 'noticia' ? 'daily' : 'weekly',
                '0.7',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($items as [$loc, $lastmod, $freq, $priority]) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$loc}</loc>\n";
            if ($lastmod) {
                $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$freq}</changefreq>\n";
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    public function generateFile(): string
    {
        $xml = $this->build();

        file_put_contents(public_path('sitemap.xml'), $xml);

        return $xml;
    }
}