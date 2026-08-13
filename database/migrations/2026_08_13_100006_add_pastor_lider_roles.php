<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $pastor = Role::firstOrCreate(['name' => 'pastor', 'guard_name' => 'web']);
        $lider = Role::firstOrCreate(['name' => 'lider', 'guard_name' => 'web']);

        $pastor->syncPermissions([
            'view dashboard',
            'manage members',
            'manage ministries',
            'manage events',
            'manage offerings',
        ]);

        $lider->syncPermissions([
            'view dashboard',
            'manage members',
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->whereIn('name', ['pastor', 'lider'])->delete();
    }
};
