<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\ReservableCenter;
use App\RoomTiming;
use App\Week;
use App\Room;
use App\OrderRoom;



class TimingController extends Controller
{
    function index(Request $request,ReservableCenter $center){
      if($center->id == null){
        $center = ReservableCenter::where("user_id",Auth::user()->id)->first();
        $is_admin = false;
      }else{
        $is_admin = true;
      }
      //User has not any reservable center
      if($center == null){
        return view('errors.reservable_center_not_found');
      }
      $center_room_list = Room::where("reservable_center_id",$center->id)->select("id")->get();

      //Getting Current Week
      $current_date = date("Y-m-d");
      $current_week = Week::where([
        ["start_date","<=",$current_date],
        ["end_date",">=",$current_date],
      ])->first();
      $current_week_id = $current_week->id;

	  $cond = '';
        if(isset($center_room_list))
            $cond =  'AND room_id in ('. implode(",", $center_room_list->pluck("id")->toArray()) .')';


      //\DB::enableQueryLog();
      $weeks = Week::
      //leftJoin("room_timings","weeks.id","=","room_timings.week_id")
      leftJoin("room_timings",function($join) use($center_room_list){
        $join->on("room_timings.week_id","=","weeks.id")
        ->whereIn("room_timings.room_id",$center_room_list);
      })
      ->select(\DB::raw('weeks.*,
          COUNT(room_timings.id) AS reservable_count,
          (SELECT COUNT(room_timings.id) FROM room_timings WHERE room_timings.week_id = weeks.id AND room_timings.selled = 1 ' . $cond . ') AS reserved_count,
          (SELECT SUM(room_timings.price) FROM room_timings WHERE room_timings.week_id = weeks.id AND room_timings.selled = 1 ' . $cond . ') AS reserved_prices
        '))
      ->groupBy("weeks.id")
      ->havingRaw("COUNT(room_timings.id) > 0 OR weeks.id >=".$current_week_id)
      ->get();

      return view('timing.index',compact('center','is_admin','weeks','current_week_id'));
    }
    function set(ReservableCenter $center, Request $request, $week){

      $edit_enabled = 1;

      if(isset($request->result_to_save)){
        $result_to_save = json_decode($request->result_to_save);
        if(RoomTiming::timing_sync($result_to_save)){
          flash_message("زمانبندی ثبت شد","success");
          /*
          if($center == null){
            return redirect("timing");
          }else{
            return redirect("timing/center/".$center->id);
          }*/
        }else{
          flash_message("بروز رسانی با مشکل مواجه شد.","danger");
        }
      }

      //Set Week which will be schedules
      $set_week = Week::where("id",$week)->first();

      //Getting Current Week
      $current_date = date("Y-m-d");
      $current_week = Week::where([
        ["start_date","<=",$current_date],
        ["end_date",">=",$current_date],
      ])->first();

      //If given week id is incorrect , current week will be setted
      if(!isset($set_week->id)){
        $set_week = $current_week;
      }

      //Determine lingual phrase for set week
      $dif_week = $set_week->id - $current_week->id;
      switch($dif_week){
        case 0:
        $lingual_set_week = "هفته جاری";
        break;

        case 1:
        $lingual_set_week = "هفته بعد";
        break;

        case -1:
        $lingual_set_week = "هفته قبل";
        $edit_enabled = 0;
        break;

        default:
        if($dif_week>1){
          $lingual_set_week = $dif_week." هفته بعد";
        }else{
          $edit_enabled = 0;
          $lingual_set_week = abs($dif_week)." هفته قبل";
        }
        break;
      }

      //Get Center which we want to set time for its rooms
      if($center->id == null){
        $center = ReservableCenter::where("user_id",Auth::user()->id)->first();
        $is_admin = false;
      }else{
        $is_admin = true;
      }
      $center_room_list = Room::where("reservable_center_id",$center->id)->select("id")->get();
      $room_timing = RoomTiming::whereIn("room_id",$center_room_list)
            ->where("week_id","=",$set_week->id)
            ->select('room_timings.*',\DB::raw("'n/a' AS operation_status"))
            ->get();


      $i=0;
      foreach ($room_timing as $rt) {
        if($rt->order_room()->count()){
          $room_timing[$i]->order_room = $rt->order_room[0];
        }
        $i++;
      }

      $day_mapper = ["شنبه","یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنج شنبه","جمعه"];

      return view('timing.set',compact('day_mapper','center','is_admin','lingual_set_week','set_week','room_timing','edit_enabled'));
    }
    function ajax_order_view(OrderRoom $order){
      //My Codes
      $ids = [];
      foreach($order->room_timing as $o){
        $ids [] = $o->id;
      }

      $timing_list = RoomTiming::whereIn("id",$ids)->orderBy("room_id","ASC")->orderBy("day","ASC")->orderBy("start_hour","ASC")->get();

      $active_room = 0;
      $active_day = -1;
      $timing_list_to_show = [] ;
      $full_price = 0;
      $room_mapper = [];

      foreach($timing_list as $tl){
        $full_price += $tl->price;
        //Make Current Room working on
        if($tl->room_id != $active_room){
          $active_room = $tl->room_id;
          $room_mapper [$tl->room->id]=["name" => $tl->room->name,"count"=>0];
        }
        //Make Current Day working on
        if($tl->day != $active_day){
          $active_day = $tl->day;
          $timing_list_to_show[$active_room][$active_day][] = ["start_hour"=>$tl->start_hour , "end_hour" => ($tl->start_hour+1)];
          $room_mapper[$active_room]["count"]++;
        }else{
          if(isset($timing_list_to_show[$active_room][$active_day])){
            $previous_index = count($timing_list_to_show[$active_room][$active_day]);
          }else{
            $previous_index = 0;
          }
          if($previous_index > 0 ){
            $previous = end($timing_list_to_show[$active_room][$active_day]);
            if($previous["end_hour"] == $tl->start_hour){
              $timing_list_to_show[$active_room][$active_day][($previous_index-1)]["end_hour"] = ($tl->start_hour+1);
            }else{
              $timing_list_to_show[$active_room][$active_day][] = ["start_hour"=>$tl->start_hour , "end_hour" => ($tl->start_hour+1)];
              $room_mapper[$active_room]["count"]++;
            }
          }else{
            $timing_list_to_show[$active_room][$active_day][] = ["start_hour"=>$tl->start_hour , "end_hour" => ($tl->start_hour+1)];
            $room_mapper[$active_room]["count"]++;
          }
        }
      }

      $day_mapper = ["شنبه","یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنج شنبه","جمعه"];

      return view('timing.ajax_order_view',compact('order','timing_list_to_show','full_price','room_mapper','day_mapper'));
    }
}
