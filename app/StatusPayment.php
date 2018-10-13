<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusPayment extends Model
{
    protected $fillable = ['title'];

    public function orderRooms()
    {
        return $this->hasMany(OrderRoom::class);
    }
}
