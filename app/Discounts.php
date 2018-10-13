<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $table='discounts';
    public $timestamps = false;
    protected $fillable=['discounts_name','discounts_value','center_id','capacity','priority'];

    public function center()
    {
        return $this->hasOne('App\ReservableCenter','id','center_id');
    }
}
