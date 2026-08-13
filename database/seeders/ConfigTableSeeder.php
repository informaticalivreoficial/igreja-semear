<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::updateOrCreate(
            ['id' => 1],
            [
                'app_name' => env('APP_NAME', 'Semear'),
                'social_name' => env('CLIENT_SOCIAL_FACEBOOK_PAGE', 'Semear'),
                'alias_name' => 'Semear',
                'slug' => 'semear',
                'status' => true,
                'init_date' => now()->subYears(10)->format('Y-m-d'),
                'template' => 'default',

                'email' => 'teste@teste.com.br',
                'additional_email' => 'contato@semear.com.br',

                'zipcode' => '11680000',
                'city' => 'Ubatuba',
                'state' => 'SP',
                'street' => 'Rua da Igreja',
                'number' => '100',

                'phone' => '(11) 1111-1111',
                'cell_phone' => '(11) 11111-1111',
                'whatsapp' => '(11) 11111-1111',

                'facebook' => 'https://facebook.com/'.env('CLIENT_SOCIAL_FACEBOOK_PAGE', 'semear'),
                'instagram' => 'https://instagram.com/'.env('CLIENT_SOCIAL_INSTAGRAM_PAGE', 'semear'),
                'youtube' => 'https://youtube.com/'.env('CLIENT_SOCIAL_YOUTUBE_PAGE', 'SemearUbatuba'),

                'rss' => '/rss',
                'sitemap' => '/sitemap.xml',
                'rss_data' => now()->format('Y-m-d'),
                'sitemap_data' => now()->format('Y-m-d'),
            ]
        );
    }
}
