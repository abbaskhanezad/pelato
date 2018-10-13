<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','password','name','family','email','mobile','type','confirm','confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function reservable_center(){
      return $this->hasOne(ReservableCenter::class);
    }

    function order_room(){
      return $this->hasMany(OrderRoom::class);
    }

    function event(){
      return $this->hasMany(Event::class);
    }

	    function image(){
        return $this->hasMany(Image::class,'owner_id')->where("owner_type","=","3");
    }

    public function Comment()
    {
        return $this->hasMany('App\Comment');
    }

}
