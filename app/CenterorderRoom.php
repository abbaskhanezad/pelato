<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterorderRoom extends Model
{
  protected $fillable = ['user_id','center_id','status_payment_id','whole_price','paid'];

  function room_timing(){
    return $this->belongsToMany(RoomTiming::class,'croom_timing_order_room');
  }

  function user(){
    return $this->belongsTo(User::class);
  }

 	public function statusPayment ()
	{
		return $this->belongsTo(StatusPayment::class);
	}


}
