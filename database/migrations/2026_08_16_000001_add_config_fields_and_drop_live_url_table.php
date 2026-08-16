<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->string('telegram')->nullable()->after('whatsapp');
            $table->string('display_address')->nullable()->after('city');
            $table->text('terms_conditions')->nullable()->after('privacy_policy');
            $table->text('cookies_preference')->nullable()->after('terms_conditions');
            $table->dropColumn('live_url');
        });
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->string('live_url')->nullable()->after('maps_google');
            $table->dropColumn(['telegram', 'display_address', 'terms_conditions', 'cookies_preference']);
        });
    }
};
