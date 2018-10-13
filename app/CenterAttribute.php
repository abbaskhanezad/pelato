<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterAttribute extends Model
{
  protected $fillable = ['name', 'type'];


  function reservable_center(){
    return $this->belongsToMany(ReservableCenter::class,'center_attribute_reservable_center');
  }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'center_attribute_room');
    }

}
