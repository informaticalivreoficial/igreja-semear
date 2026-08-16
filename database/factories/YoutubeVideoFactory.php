<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\YoutubeVideo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<YoutubeVideo>
 */
class YoutubeVideoFactory extends Factory
{
    protected $model = YoutubeVideo::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'youtube_id' => str_pad((string) fake()->unique()->numberBetween(100000000, 999999999), 11, '0'),
            'type' => fake()->randomElement([YoutubeVideo::TYPE_CULTO, YoutubeVideo::TYPE_PREGACAO]),
            'category' => fake()->randomElement(['Culto de domingo', 'Estudos bíblicos', 'Jovens', 'Mulheres', 'Homens']),
            'is_live' => false,
            'scheduled_at' => null,
            'status' => true,
            'cover' => null,
            'publish_at' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'order' => 0,
            'created_by' => User::factory(),
        ];
    }

    public function live(): static
    {
        return $this->state(fn () => ['is_live' => true]);
    }

    public function culto(): static
    {
        return $this->state(fn () => ['type' => YoutubeVideo::TYPE_CULTO]);
    }

    public function pregacao(): static
    {
        return $this->state(fn () => ['type' => YoutubeVideo::TYPE_PREGACAO]);
    }
}