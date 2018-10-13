<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
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
            $table->string('username',40);
            $table->string('password',150);
            $table->string('name',80)->nullable();
            $table->string('family',80)->nullable();
            $table->string('email',90)->nullable();
            $table->string('mobile',15);
            $table->tinyInteger('type');
            $table->tinyInteger('confirm');
            $table->string('remember_token',100)->nullable();
            $table->string('confirmation_code',5)->nullable();
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
