<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembersFromUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('member')->get();

        foreach ($users as $user) {
            if (Member::where('user_id', $user->id)->exists()) {
                continue;
            }

            Member::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'gender' => $user->gender,
                'cpf' => $user->cpf,
                'rg' => $user->rg,
                'birthday' => $user->birthday?->format('d/m/Y'),
                'naturalness' => $user->naturalness,
                'civil_status' => $user->civil_status,
                'baptism' => $user->baptism,
                'baptism_date' => $user->baptism_date?->format('d/m/Y'),
                'cell_phone' => $user->cell_phone,
                'whatsapp' => $user->whatsapp,
                'email' => $user->email,
                'status' => $user->status,
            ]);
        }
    }
}