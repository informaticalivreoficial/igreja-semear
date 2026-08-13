<?php

namespace Database\Factories;

use App\Models\Ministry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Ministry>
 */
class MinistryFactory extends Factory
{
    protected $model = Ministry::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->optional()->paragraph(),
            'cover' => null,
            'color' => fake()->hexColor(),
            'leader_id' => User::factory(),
            'status' => fake()->boolean(80),
        ];
    }
}
