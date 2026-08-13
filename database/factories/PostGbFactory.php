<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostGb;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PostGb>
 */
class PostGbFactory extends Factory
{
    protected $model = PostGb::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_img' => fake()->numberBetween(0, 10),
            'post' => Post::factory(),
            'path' => 'posts/'.Str::random(20).'.jpg',
            'cover' => fake()->boolean(30),
        ];
    }

    public function forPost(Post $post): static
    {
        return $this->state(fn () => [
            'post' => $post->id,
        ]);
    }
}
