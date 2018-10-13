<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRoom extends Model
{
  protected $fillable = ['user_id','whole_price','paid','mellat_pay_ref_id','has_not_reserved_hour', 'status_payment_id','discount_id','pelato_discount'];

  function room_timing(){
    return $this->belongsToMany(RoomTiming::class,'room_timing_order_room');
  }

  function user(){
    return $this->belongsTo(User::class);
  }

 	public function statusPayment ()
	{
		return $this->belongsTo(StatusPayment::class);
	}


}
