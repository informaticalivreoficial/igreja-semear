<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();
            $table->string('family_role')->nullable()->comment('chefe, conjuge, filho, outro');

            /** dados pessoais */
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('rg_expedition')->nullable();
            $table->date('birthday')->nullable();
            $table->string('naturalness')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('avatar')->nullable();

            /** vida cristã */
            $table->boolean('baptism')->nullable();
            $table->date('baptism_date')->nullable();

            /** endereço */
            $table->string('postcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            /** contato */
            $table->string('cell_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('additional_email')->nullable();

            /** redes sociais */
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();

            $table->boolean('status')->default(true);
            $table->text('information')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
