<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsTableSeeder::class,
            ConfigTableSeeder::class,
            UsersTableSeeder::class,
            CatPostsTableSeeder::class,
            PostsTableSeeder::class,
            SlidesTableSeeder::class,
            MinistriesTableSeeder::class,
            EventsTableSeeder::class,
            OfferingsTableSeeder::class,
        ]);
    }
}
