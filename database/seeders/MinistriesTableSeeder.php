<?php

namespace Database\Seeders;

use App\Models\Ministry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MinistriesTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ministries = [
            'Louvor',
            'Ensino',
            'Ação Social',
            'Adolescentes',
            'Intercessão',
        ];

        foreach ($ministries as $name) {
            $leader = User::factory()->create();

            $ministry = Ministry::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => "Ministério de {$name} da igreja.",
                    'leader_id' => $leader->id,
                    'status' => true,
                ]
            );

            $members = User::factory()->count(fake()->numberBetween(3, 6))->create();

            $ministry->members()->attach($members, ['role' => 'membro']);
            $ministry->members()->attach($leader, ['role' => 'lider']);
        }
    }
}
