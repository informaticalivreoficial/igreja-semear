<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->string('live_url')->nullable()->after('maps_google');
        });
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropColumn('live_url');
        });
    }
};
