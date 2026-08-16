<?php

namespace Database\Seeders;

use App\Models\YoutubePlaylist;
use Illuminate\Database\Seeder;

class YoutubePlaylistsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (YoutubePlaylist::count() > 0) {
            return;
        }

        $playlists = [
            ['title' => 'Cultos Online', 'youtube_id' => 'PL4o29bINVT4GqUy6JfGH1HmFQo4bKZlQP'],
            ['title' => 'Pregações', 'youtube_id' => 'PL4o29bINVT4GqUy6JfGH1HmFQo4bKZlQQ'],
        ];

        foreach ($playlists as $playlist) {
            YoutubePlaylist::create($playlist);
        }
    }
}