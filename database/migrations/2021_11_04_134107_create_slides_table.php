<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('button_label')->nullable();
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->string('link')->nullable();
            $table->boolean('target')->default(false);
            $table->string('slug')->nullable();
            $table->string('category')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('show_title')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
