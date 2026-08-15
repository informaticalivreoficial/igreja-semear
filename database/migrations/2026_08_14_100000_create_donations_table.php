<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('church_id')->nullable()->index();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->index();
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending')->index();
            $table->unsignedBigInteger('payment_id')->nullable()->index();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
