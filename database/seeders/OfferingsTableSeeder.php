<?php

namespace Database\Seeders;

use App\Models\Offering;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferingsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::where('email', env('ADMIN_EMAIL', 'admin@semear.com.br'))->first()
            ?? User::factory()->create();

        $members = User::whereHas('roles', fn ($q) => $q->where('name', 'member'))
            ->limit(10)
            ->get();

        if ($members->isEmpty()) {
            $members = User::factory()->count(10)->create();
        }

        foreach ($members as $member) {
            Offering::factory()->count(fake()->numberBetween(1, 4))->create([
                'user_id' => $member->id,
                'created_by' => $creator->id,
            ]);
        }
    }
}
