<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $primaryKey='wallet_id';

    protected $guarded=[
        'wallet_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'wallet_user_id','wallet_id');
    }
}
