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

    const USER_ROLE = 1;
    const CANTER_OWNER = 2;
    const ADMIN_ROLE = 3;
    const SUPPORT_ROLE = 4;

    const CONFIRMED = 1;
    const UNCONFIRMED = 0;

    protected $fillable = [
        'username','password','name','family','email','mobile','parent_id','type','confirm','confirmation_code'
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

    public static function getCountOrder($user_id)
    {
        return OrderRoom::where('user_id',$user_id)->count();
    }


    public function wallet()
    {
        return $this->hasOne(Wallet::class,'wallet_user_id','id');
    }

    public function points()
    {
        return $this->hasMany(Point::class,'point_user_id');
    }

    public function child()
    {
        return $this->hasMany(User::class,'parent_id','id');
    }


    public function parent()
    {
        return $this->belongsTo(User::class,'parent_id','id');
    }


    public function getUserFullNameAttribute()
    {
        $fullName = $this->attributes['name'].' '.$this->attributes['family'];
        return $fullName;
    }

}
