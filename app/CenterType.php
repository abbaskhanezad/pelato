<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterType extends Model
{
    protected $fillable = ['name'];

    function reservable_center(){
      return $this->hasMany(ReservableCenter::class);
    }
}
