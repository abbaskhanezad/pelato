<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{

  function room_timing(){
    return $this->hasMany(RoomTiming::class);
  }
}
