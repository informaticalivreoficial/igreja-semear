<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;

class FamiliesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (Family::exists()) {
            return;
        }

        $families = [
            'Família Silva',
            'Família Santos',
            'Família Oliveira',
            'Família Souza',
            'Família Pereira',
            'Família Lima',
        ];

        foreach ($families as $name) {
            Family::create(['name' => $name]);
        }
    }
}
