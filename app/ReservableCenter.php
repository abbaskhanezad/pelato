<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservableCenter extends Model
{
	protected $fillable = ['center_type_id','user_id','name', 'slug','address', 'phone', 'meta', 'description','google_map_lat','google_map_lon','verified','active', 'is_best'];

    protected $casts = [
        'meta' => 'array'
    ];

    function center_type(){
      return $this->belongsTo(CenterType::class);
    }
    function user(){
      return $this->belongsTo(User::class);
    }
    function center_attribute(){
      return $this->belongsToMany(CenterAttribute::class,'center_attribute_reservable_center');
    }

    function room(){
      return $this->hasMany(Room::class);
    }
    function image(){
      return $this->hasOne(Image::class,'owner_id')->where("owner_type","=","1");
    }
	 public function Comment()
    {
        return $this->hasMany('App\Comment');
    }
	   public function Discount()
    {
        return $this->hasMany('App\Discount');
    }
    public function star()
    {
        return $this->hasMany('App\Starrating','center_id','id');
    }
}
