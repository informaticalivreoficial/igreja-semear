<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('code')->nullable();
            $table->rememberToken();  

            $table->dateTime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->string('gender')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('rg_expedition')->nullable();
            $table->date('birthday')->nullable();
            $table->string('naturalness')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('avatar')->nullable();  

            $table->boolean('baptism')->nullable();  
            $table->date('baptism_date')->nullable();          

            /** address */
            $table->string('postcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            /** contact */
            $table->string('cell_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('additional_email')->nullable();
            $table->string('email')->unique();

            /** Socials */
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();

            /** access */
            $table->boolean('superadmin')->nullable();
            $table->boolean('admin')->nullable();
            $table->boolean('client')->nullable();
            $table->boolean('editor')->nullable();            

            $table->integer('status')->default('0');
            $table->text('information')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
