<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = ['user_id','name','address','phone','mobile','price','capacity','google_map_lat','google_map_lon','reserve_active_hour_before'];

  function user(){
    return $this->belongsTo(Event::class);
  }

  function scence(){
    return $this->hasMany(Event::class);
  }
}
