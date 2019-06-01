<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->DateTime('dateNaisse')->nullable();
            $table->string('sexe')->nullable();
            $table->string('status')->nullable();
            $table->string('role');
            $table->string('email')->unique();
            $table->string('userName')->unique();
            $table->string('password');
            $table->integer('service_id')->unsigned();
            $table->integer('horaire_id')->unsigned();
            $table->rememberToken();
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
