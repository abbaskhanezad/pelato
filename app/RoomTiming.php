<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTiming extends Model
{

  protected $fillable = ['room_id','week_id','day','start_hour','price','selled'];

  function week(){
    return $this->belongsTo(Week::class);
  }
  function room(){
    return $this->belongsTo(Room::class);
  }
  function order_room(){
    return $this->belongsToMany(OrderRoom::class,'room_timing_order_room');
  }

    function centerorder_room(){
        return $this->belongsToMany(CenterorderRoom::class,'croom_timing_order_room');
    }
  static function timing_sync($result_to_save){
    \DB::beginTransaction();
    $transaction = 1;
    foreach ($result_to_save as $sync) {
        switch($sync->operation_status){
          case "insert":
          $transaction *= \DB::table('room_timings')->insert([
            "week_id" => $sync->week_id,
            "room_id" => $sync->room_id,
            "day" => $sync->day,
            "start_hour" => $sync->start_hour,
            "price" => $sync->price,
            "selled" => 0,
          ]);
          break;

          case "update":
          $transaction *= \DB::table('room_timings')->where("id",$sync->id)->update([
            "price" => $sync->price,
          ]);
          break;

          case "delete":
          $transaction *= \DB::table('room_timings')->where("id",$sync->id)->delete();
          break;

        }
    }
    if($transaction){
      \DB::commit();
      return true;
    }else{
      \DB::rollBack();
      return false;
    }
  }
}
