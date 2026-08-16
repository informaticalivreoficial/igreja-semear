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
            MembersFromUsersSeeder::class,
            CatPostsTableSeeder::class,
            PostsTableSeeder::class,
            SlidesTableSeeder::class,
            MinistriesTableSeeder::class,
            EventsTableSeeder::class,
            DonationsTableSeeder::class,
            SitePagesSeeder::class,
            FamiliesTableSeeder::class,
            AnnouncementsTableSeeder::class,
            YoutubeVideosTableSeeder::class,
            YoutubePlaylistsTableSeeder::class,
        ]);
    }
}
