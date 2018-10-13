<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeToWalletLog extends Model
{
    protected $table ='pointtowallet_log';
    protected $primaryKey ='log_id';
    protected $guarded=['log_id'];


}
