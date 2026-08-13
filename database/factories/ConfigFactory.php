<?php

namespace Database\Factories;

use App\Models\Config;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Config>
 */
class ConfigFactory extends Factory
{
    protected $model = Config::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Igreja '.fake()->city();

        return [
            'app_name' => $name,
            'social_name' => fake()->company(),
            'alias_name' => Str::slug($name),
            'slug' => Str::slug($name),
            'status' => true,
            'init_date' => fake()->dateTimeBetween('-30 years', '-1 year')->format('Y-m-d'),
            'cnpj' => fake()->cnpj(),
            'domain' => 'https://'.fake()->domainName(),
            'subdomain' => 'https://'.Str::slug($name).'.'.fake()->domainName(),
            'template' => 'default',

            'logo' => null,
            'logo_admin' => null,
            'logo_footer' => null,
            'favicon' => null,
            'metaimg' => null,
            'imgheader' => null,
            'watermark' => null,

            'phone' => '('.fake()->areaCode().') '.fake()->phone(),
            'cell_phone' => '('.fake()->areaCode().') '.fake()->cellphone(),
            'whatsapp' => '('.fake()->areaCode().') '.fake()->cellphone(),
            'email' => fake()->unique()->safeEmail(),
            'additional_email' => fake()->unique()->safeEmail(),

            'zipcode' => fake()->numerify('#####-###'),
            'street' => fake()->streetName(),
            'number' => (string) fake()->numberBetween(1, 5000),
            'complement' => fake()->optional()->secondaryAddress(),
            'neighborhood' => fake()->citySuffix(),
            'state' => fake()->stateAbbr(),
            'city' => fake()->city(),

            'facebook' => 'https://facebook.com/'.fake()->userName(),
            'twitter' => 'https://twitter.com/'.fake()->userName(),
            'youtube' => 'https://youtube.com/@'.fake()->userName(),
            'instagram' => 'https://instagram.com/'.fake()->userName(),
            'linkedin' => 'https://linkedin.com/in/'.fake()->userName(),

            'information' => fake()->paragraph(),
            'privacy_policy' => fake()->paragraphs(3, true),
            'maps_google' => fake()->optional()->url(),
            'metatags' => implode(',', fake()->words(5)),
            'analytics_id' => 'G-'.strtoupper(Str::random(6)),
            'rss' => '/rss',
            'rss_data' => now()->format('Y-m-d'),
            'sitemap' => '/sitemap.xml',
            'sitemap_data' => now()->format('Y-m-d'),
        ];
    }
}
