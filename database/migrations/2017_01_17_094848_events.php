<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');

            $table->string("name",400);
            $table->string("address",1000);
            $table->string("phone",45)->nullable();
            $table->string("mobile",45)->nullable();
            $table->string("price",5);
            $table->tinyInteger("capacity");
            $table->string("google_map_lat",20)->nullable();
            $table->string("google_map_lon",20)->nullable();
            $table->tinyInteger("reserve_active_hour_before")->default(1);

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
        Schema::dropIfExists('events');
    }
}
