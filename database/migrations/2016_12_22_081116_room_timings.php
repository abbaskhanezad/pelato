<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomTimings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_timings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('rooms')->onUpdate('no action')->onDelete('no action');

            $table->integer('week_id')->unsigned()->index();
            $table->foreign('week_id')->references('id')->on('weeks')->onUpdate('no action')->onDelete('no action');

            $table->tinyInteger("day");
            $table->tinyInteger("start_hour");
            $table->string("price","5");
            $table->tinyInteger("selled")->default(0);


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
        Schema::dropIfExists('room_timings');
    }
}
