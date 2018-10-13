<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CenterAttributeReservableCenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('center_attribute_reservable_center', function (Blueprint $table) {
            $table->integer('center_attribute_id')->unsigned()->index();
            $table->foreign('center_attribute_id')->references('id')->on('center_attributes')->onDelete('no action');

            $table->integer('reservable_center_id')->unsigned()->index();
            $table->foreign('reservable_center_id')->references('id')->on('reservable_centers')->onDelete('no action');

            $table->primary(['center_attribute_id', 'reservable_center_id'],'attributes_for_center_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('center_attribute_reservable_center');
    }
}
