<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $members = DB::table('users')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id')
                    ->where('model_has_roles.model_type', '=', 'App\\Models\\User');
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'member')
            ->select('users.*')
            ->get();

        foreach ($members as $user) {
            if (DB::table('members')->where('user_id', $user->id)->exists()) {
                continue;
            }

            DB::table('members')->insert([
                'user_id' => $user->id,
                'name' => $user->name,
                'gender' => $user->gender,
                'cpf' => $user->cpf,
                'rg' => $user->rg,
                'rg_expedition' => $user->rg_expedition,
                'birthday' => $user->birthday,
                'naturalness' => $user->naturalness,
                'civil_status' => $user->civil_status,
                'avatar' => $user->avatar,
                'baptism' => $user->baptism,
                'baptism_date' => $user->baptism_date,
                'postcode' => $user->postcode,
                'street' => $user->street,
                'number' => $user->number,
                'complement' => $user->complement,
                'neighborhood' => $user->neighborhood,
                'state' => $user->state,
                'city' => $user->city,
                'cell_phone' => $user->cell_phone,
                'whatsapp' => $user->whatsapp,
                'email' => $user->email,
                'additional_email' => $user->additional_email,
                'facebook' => $user->facebook,
                'linkedin' => $user->linkedin,
                'instagram' => $user->instagram,
                'status' => $user->status,
                'information' => $user->information,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('members')->whereNotNull('user_id')->delete();
    }
};
