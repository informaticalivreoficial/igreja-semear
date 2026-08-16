<?php

namespace Database\Seeders;

use App\Models\YoutubeVideo;
use Illuminate\Database\Seeder;

class YoutubeVideosTableSeeder extends Seeder
{
    public function run(): void
    {
        if (YoutubeVideo::count() > 0) {
            return;
        }

        $videos = [
            [
                'title' => 'Culto de Celebração — Domine e Reine',
                'youtube_id' => 'dQw4w9WgXcQ',
                'type' => 'culto',
                'category' => null,
                'is_live' => false,
                'publish_at' => now()->subDays(2)->format('Y-m-d'),
            ],
            [
                'title' => 'Culto de Domingo — A Fé que Agrada a Deus',
                'youtube_id' => 'xfr64zoBTAQ',
                'type' => 'culto',
                'category' => null,
                'is_live' => false,
                'publish_at' => now()->subDays(9)->format('Y-m-d'),
            ],
            [
                'title' => 'Pregação — Andando no Sobrenatural',
                'youtube_id' => 'aqz-KE-bpKQ',
                'type' => 'pregacao',
                'category' => 'Estudos bíblicos',
                'is_live' => false,
                'publish_at' => now()->subDays(16)->format('Y-m-d'),
            ],
            [
                'title' => 'Culto da Família — Casa em Ordem',
                'youtube_id' => 'r-y2NxJk_ng',
                'type' => 'culto',
                'category' => null,
                'is_live' => false,
                'publish_at' => now()->subDays(23)->format('Y-m-d'),
            ],
            [
                'title' => 'Pregação — O Poder da Gratidão',
                'youtube_id' => 'Y9VnJ8Iqm9I',
                'type' => 'pregacao',
                'category' => 'Jovens',
                'is_live' => false,
                'publish_at' => now()->subDays(30)->format('Y-m-d'),
            ],
        ];

        foreach ($videos as $video) {
            YoutubeVideo::create($video);
        }
    }
}