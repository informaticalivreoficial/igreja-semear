<?php

namespace Database\Factories;

use App\Models\CatPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'autor' => User::factory(),
            'type' => 'artigo',
            'title' => rtrim($title, '.'),
            'content' => fake()->paragraphs(6, true),
            'slug' => Str::slug($title),
            'tags' => implode(',', fake()->words(4)),
            'views' => fake()->numberBetween(0, 10000),
            'readingTime' => fake()->numberBetween(1, 20),
            'metaDescription' => fake()->optional()->sentence(8),
            'excerpt' => fake()->optional()->sentence(12),
            'category' => CatPost::factory(),
            'cat_pai' => null,
            'comments' => fake()->numberBetween(0, 200),
            'status' => fake()->boolean(80),
            'highlight' => fake()->boolean(20),
            'menu' => fake()->boolean(10),
            'thumb_caption' => fake()->optional()->sentence(4),
            'publish_at' => fake()->dateTimeBetween('-1 year', 'now')->format('d/m/Y'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 1,
            'publish_at' => now()->format('d/m/Y'),
        ]);
    }

    public function type(string $type): static
    {
        return $this->state(fn () => [
            'type' => $type,
        ]);
    }
}
