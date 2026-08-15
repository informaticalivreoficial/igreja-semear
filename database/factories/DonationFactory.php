<?php

namespace Database\Factories;

use App\Enums\DonationStatusEnum;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donation>
 */
class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['offering', 'tithe', 'donation', 'other']),
            'amount' => fake()->randomFloat(2, 5, 1000),
            'status' => DonationStatusEnum::Paid->value,
            'is_anonymous' => fake()->boolean(10),
            'source' => 'manual',
            'payment_method' => fake()->randomElement(['pix', 'dinheiro', 'credito', 'debito', 'transferencia']),
            'description' => fake()->optional()->sentence(8),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}