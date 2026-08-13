<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::where('email', env('ADMIN_EMAIL', 'admin@semear.com.br'))->first()
            ?? User::factory()->create();

        Event::factory()->count(6)->create([
            'created_by' => $creator->id,
        ]);
    }
}
