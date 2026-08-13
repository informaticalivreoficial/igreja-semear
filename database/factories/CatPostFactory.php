<?php

namespace Database\Factories;

use App\Models\CatPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CatPost>
 */
class CatPostFactory extends Factory
{
    protected $model = CatPost::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => ucfirst($title),
            'type' => fake()->randomElement(['artigo', 'noticia', 'pagina']),
            'content' => fake()->optional()->paragraphs(3, true),
            'slug' => Str::slug($title),
            'tags' => implode(',', fake()->words(4)),
            'views' => fake()->numberBetween(0, 5000),
            'status' => fake()->boolean(80),
            'id_pai' => null,
        ];
    }

    public function child(?int $parentId = null): static
    {
        return $this->state(fn () => [
            'id_pai' => $parentId,
        ]);
    }
}
