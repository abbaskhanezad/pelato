<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table ='points';
    protected $primaryKey='point_id';
    protected $guarded=[
        'point_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'point_user_id','point_id');
    }


    public function pointItems()
    {
        return $this->belongsToMany(PointItem::class,'point_pointitem','point_id','point_item_id');
    }


}
