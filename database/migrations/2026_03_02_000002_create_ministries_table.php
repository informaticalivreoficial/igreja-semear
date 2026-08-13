<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->boolean('status')->default(false);

            $table->timestamps();

            $table->foreign('leader_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('ministry_member', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ministry_id');
            $table->unsignedBigInteger('user_id');
            $table->string('role')->nullable();

            $table->timestamps();

            $table->unique(['ministry_id', 'user_id']);
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ministry_member');
        Schema::dropIfExists('ministries');
    }
};
