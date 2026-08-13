<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
        $baptism = fake()->boolean(60);

        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'code' => strtoupper(Str::random(8)),
            'remember_token' => Str::random(10),

            'last_login_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'last_login_ip' => fake()->ipv4(),

            /** dados pessoais */
            'gender' => fake()->randomElement(['masculino', 'feminino']),
            'cpf' => fake()->cpf(),
            'rg' => fake()->rg(),
            'rg_expedition' => fake()->city().'/'.fake()->stateAbbr(),
            'birthday' => fake()->dateTimeBetween('-60 years', '-18 years')->format('d/m/Y'),
            'naturalness' => fake()->city(),
            'civil_status' => fake()->randomElement(['solteiro', 'casado', 'separado', 'divorciado', 'viuvo']),
            'avatar' => null,

            /** vida cristã */
            'baptism' => $baptism,
            'baptism_date' => $baptism
                ? fake()->dateTimeBetween('-20 years', 'now')->format('d/m/Y')
                : null,

            /** endereço */
            'postcode' => fake()->numerify('#####-###'),
            'street' => fake()->streetName(),
            'number' => (string) fake()->numberBetween(1, 5000),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->citySuffix(),
            'state' => fake()->stateAbbr(),
            'city' => fake()->city(),

            /** contato */
            'cell_phone' => '('.fake()->areaCode().') '.fake()->cellphone(),
            'whatsapp' => '('.fake()->areaCode().') '.fake()->cellphone(),
            'additional_email' => fake()->unique()->safeEmail(),

            /** redes sociais */
            'facebook' => 'https://facebook.com/'.fake()->userName(),
            'linkedin' => 'https://linkedin.com/in/'.fake()->userName(),
            'instagram' => 'https://instagram.com/'.fake()->userName(),

            'status' => true,
            'information' => fake()->optional()->paragraph(),
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
