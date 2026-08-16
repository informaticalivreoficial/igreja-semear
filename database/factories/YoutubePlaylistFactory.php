<?php

namespace Database\Factories;

use App\Models\YoutubePlaylist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<YoutubePlaylist>
 */
class YoutubePlaylistFactory extends Factory
{
    protected $model = YoutubePlaylist::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'youtube_id' => 'PL'.str_pad((string) fake()->unique()->numberBetween(100000000, 999999999), 9, '0'),
            'cover' => null,
            'status' => true,
            'order' => 0,
        ];
    }
}