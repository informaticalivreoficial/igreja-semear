<?php

namespace Database\Factories;

use App\Models\Offering;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offering>
 */
class OfferingFactory extends Factory
{
    protected $model = Offering::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['oferta', 'dizimo']),
            'amount' => fake()->randomFloat(2, 5, 1000),
            'offering_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'payment_method' => fake()->randomElement(['pix', 'dinheiro', 'credito', 'debito', 'transferencia']),
            'notes' => fake()->optional()->sentence(8),
            'created_by' => User::factory(),
        ];
    }
}
