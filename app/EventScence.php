<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventScence extends Model
{
  protected $fillable = ['start_datetime','duration'];

  function event(){
    return $this->belongsTo(Event::class);
  }
}
