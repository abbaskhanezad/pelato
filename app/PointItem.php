<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointItem extends Model
{

    protected $table='point_item';
    protected $primaryKey='point_item_id';
    protected $guarded =[
        'point_item_id',
    ];

    public function points()
    {
        return $this->belongsToMany(Point::class,'point_pointitem','point_item_id','point_id');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'pointitemable');
    }




}
