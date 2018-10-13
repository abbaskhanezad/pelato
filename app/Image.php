<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = ['owner_id','owner_type','picture'];


  function reservable_center(){
    return $this->belongsTo(ReservableCenter::class,'owner_id')->where("owner_type","=","1");
  }
  function room(){
    return $this->belongsTo(Room::class,'owner_id')->where("owner_type","=","2");
  }
  function event(){
    return $this->belongsTo(ReservableCenter::class,'owner_id')->where("owner_type","=","3");
  }
function user(){
	return $this->belongsTo(User::class,'owner_id')->where("owner_type","=","3");
}
}
