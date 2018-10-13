<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusPaymentIdToOrderRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// Schema::table('order_rooms', function (Blueprint $table) {
		// 	$table->unsignedInteger('status_payment_id')->default(1)->after('user_id');
		// 	$table->foreign('status_payment_id')->references('id')->on('status_payments')->onDelete('no action');
		// });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('order_rooms', function (Blueprint $table) {
			$table->dropColumn('status_payment_id');
		});
    }
}
