<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\JalaliServiceProvider;
use Morilog\Jalali\jDate;

class WalletLog extends Model
{

    protected $table='wallet_log';
    protected $primaryKey = 'wallet_log_id';
    protected $guarded=[
        'wallet_log_id'
    ];


    const POINT = 1;
    const MONEY = 2;

    const DECREMENT =0;
    const INCREMENT =1;


    public static function getMethodWalletCreate()
    {
        return [
            self::POINT =>'تبدیل امتیاز',
            self::MONEY =>'واریز وجه'
        ];
    }


    public static function getWalletOperation()
    {
        return [
            self::DECREMENT =>'-',
            self::INCREMENT =>'+'
        ];
    }

//    public function getCreatedAtAttribute($value)
//    {
//        $date = jalali_datetime($value);
//        return $date;
//    }


}
