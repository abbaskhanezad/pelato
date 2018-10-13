<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table='comments';
	public $timestamps = false;
	protected $fillable=['name','email','comment','center_id','state','time','parent_id','user_id'];

	public function center()
	{
		return $this->hasOne('App\ReservableCenter','id','center_id');
	}

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
