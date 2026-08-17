<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->boolean('maintenance_mode')->default(false)->after('donations_enabled');
            $table->text('maintenance_message')->nullable()->after('maintenance_mode');
            $table->timestamp('maintenance_until')->nullable()->after('maintenance_message');
        });
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropColumn(['maintenance_mode', 'maintenance_message', 'maintenance_until']);
        });
    }
};