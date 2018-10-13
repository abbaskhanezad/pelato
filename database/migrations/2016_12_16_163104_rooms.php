<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('reservable_center_id')->unsigned();
            $table->foreign('reservable_center_id')->references('id')->on('reservable_centers');

            $table->string('name',100);
            $table->string('price_per_hour',5);
            $table->tinyInteger('size')->default(0);
            $table->string('floor_type',200);
            $table->string('wall_type',200);
            
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
        Schema::dropIfExists('rooms');
    }
}
