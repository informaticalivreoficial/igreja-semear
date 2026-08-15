<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
{
    protected $model = Slide::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => ucfirst($title),
            'subtitle' => fake()->optional()->sentence(5),
            'button_label' => fake()->randomElement(['Saiba mais', 'Participe', 'Inscreva-se']),
            'image' => 'slides/'.Str::random(20).'.jpg',
            'content' => fake()->optional()->paragraphs(2, true),
            'link' => fake()->optional()->url(),
            'target' => fake()->boolean(30),
            'slug' => Str::slug($title),
            'category' => fake()->optional()->word(),
            'expires_at' => fake()->optional()->dateTimeBetween('now', '+1 year')?->format('d/m/Y'),
            'is_active' => fake()->boolean(80),
            'show_title' => true,
        ];
    }
}
