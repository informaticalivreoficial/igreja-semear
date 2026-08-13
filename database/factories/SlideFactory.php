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
        $titulo = fake()->unique()->words(3, true);

        return [
            'titulo' => ucfirst($titulo),
            'subtitulo' => fake()->optional()->sentence(5),
            'botaolabel' => fake()->randomElement(['Saiba mais', 'Participe', 'Inscreva-se']),
            'imagem' => 'slides/'.Str::random(20).'.jpg',
            'content' => fake()->optional()->paragraphs(2, true),
            'link' => fake()->optional()->url(),
            'target' => fake()->boolean(30),
            'slug' => Str::slug($titulo),
            'categoria' => fake()->optional()->word(),
            'expira' => fake()->optional()->dateTimeBetween('now', '+1 year')?->format('d/m/Y'),
            'status' => fake()->boolean(80),
            'exibir_titulo' => true,
        ];
    }
}
