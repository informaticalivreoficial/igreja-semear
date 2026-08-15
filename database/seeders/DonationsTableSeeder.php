<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DonationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::orderBy('id')->take(10)->get();

        if ($members->isEmpty()) {
            $members = collect([null]);
        }

        foreach ($members as $member) {
            Donation::factory()->count(fake()->numberBetween(1, 4))->create([
                'member_id' => $member?->id,
            ]);
        }
    }
}