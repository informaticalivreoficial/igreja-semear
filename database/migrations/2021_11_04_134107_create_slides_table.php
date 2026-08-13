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
            $table->string('titulo');
            $table->string('subtitulo')->nullable();
            $table->string('botaolabel')->nullable();
            $table->string('imagem')->nullable();
            $table->text('content')->nullable();
            $table->string('link')->nullable();
            $table->boolean('target')->default(false);
            $table->string('slug')->nullable();
            $table->string('categoria')->nullable();
            $table->date('expira')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('exibir_titulo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
