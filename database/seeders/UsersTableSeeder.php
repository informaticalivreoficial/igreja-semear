<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@semear.com.br')],
            [
                'name' => env('ADMIN_NOME', 'Administrador'),
                'email_verified_at' => now(),
                'password' => bcrypt(env('ADMIN_PASS', 'password')),
                'status' => true,
            ]
        );
        $admin->syncRoles(['super admin']);

        User::factory()->count(20)->create()->each->assignRole('member');

        User::factory()->count(3)->create()->each->assignRole('editor');

        User::factory()->count(2)->create()->each->assignRole('admin');
    }
}
