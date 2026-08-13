<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);
        $start = fake()->dateTimeBetween('now', '+6 months');

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'type' => fake()->randomElement(['evento', 'culto', 'campanha', 'reuniao']),
            'description' => fake()->optional()->paragraphs(3, true),
            'cover' => null,
            'location' => fake()->optional()->address(),
            'start_at' => $start,
            'end_at' => fake()->optional(0.5)->dateTimeBetween($start, (clone $start)->modify('+3 days')),
            'status' => fake()->boolean(80),
            'created_by' => User::factory(),
        ];
    }
}
