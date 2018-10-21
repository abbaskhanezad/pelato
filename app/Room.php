<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    const ROOM=2;
    const CENTER=1;

  protected $fillable = ['reservable_center_id','name','price_per_hour','size','sandali','floor_type','wall_type'];

  function reservable_center(){
    return $this->belongsTo(ReservableCenter::class);
  }

  function room_timing(){
    return $this->hasMany(RoomTiming::class);
  }

  function image(){
    return $this->hasMany(Image::class,'owner_id')->where("owner_type","=","2");
  }

    public function tags()
    {
      return $this->belongsToMany(CenterAttribute::class, 'center_attribute_room');
    }
}
