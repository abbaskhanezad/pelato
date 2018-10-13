<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomTimingOrderRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_timing_order_room', function (Blueprint $table) {
          $table->integer('order_room_id')->unsigned()->index();
          $table->foreign('order_room_id')->references('id')->on('order_rooms')->onDelete('no action');

          $table->integer('room_timing_id')->unsigned()->index();
          $table->foreign('room_timing_id')->references('id')->on('room_timings')->onDelete('no action');

          $table->tinyInteger("reserved")->default(0);
          $table->timestamps();

          $table->primary(['order_room_id', 'room_timing_id'],'timing_list_for_order_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_timing_order_room');
    }
}
