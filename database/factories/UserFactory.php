<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'cpf' => fake()->cpf,
            'rg' => fake()->rg,
            'birthday' => now()->subYears(25)->format('Y-m-d'),
            'cell_phone' => '(12)' . fake()->cellphone,
            'whatsapp' => '(12)' . fake()->cellphone,
            'additional_email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'gender' => fake()->randomElement(['masculino', 'feminino']),
            'civil_status' => fake()->randomElement(['casado', 'separado', 'solteiro', 'divorciado', 'viuvo']),
            'client' => true,
            'status' => 1,            
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
