<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_id');
            $table->string('type')->default('culto')->index();
            $table->string('category')->nullable()->index();
            $table->boolean('is_live')->default(false);
            $table->dateTime('scheduled_at')->nullable();
            $table->boolean('status')->default(true);
            $table->string('cover')->nullable();
            $table->date('publish_at')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('youtube_playlists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_id');
            $table->string('cover')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::table('config', function (Blueprint $table) {
            $table->string('youtube_channel_name')->nullable()->after('youtube');
            $table->dateTime('next_transmission_at')->nullable()->after('youtube_channel_name');
        });
    }

    public function down(): void
    {
        Schema::table('config', function (Blueprint $table) {
            $table->dropColumn(['youtube_channel_name', 'next_transmission_at']);
        });

        Schema::dropIfExists('youtube_playlists');
        Schema::dropIfExists('youtube_videos');
    }
};