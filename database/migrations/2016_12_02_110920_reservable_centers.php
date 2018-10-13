<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReservableCenters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservable_centers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('center_type_id')->unsigned();
            $table->foreign('center_type_id')->references('id')->on('center_types');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name',200);
            $table->string('address',1000);
            $table->text('description')->nullable();
            $table->string('google_map_lat',20)->nullable();
            $table->string('google_map_lon',20)->nullable();
            $table->tinyInteger('verified')->default(0);
            $table->tinyInteger('active')->default(0);

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
        Schema::dropIfExists('reservable_centers');
    }
}
