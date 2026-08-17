<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->boolean('donations_enabled')->default(true)->after('sitemap_data');
        });
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropColumn('donations_enabled');
        });
    }
};