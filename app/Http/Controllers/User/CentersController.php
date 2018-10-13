<?php

namespace App\Http\Controllers\User;

use App\CenterType;
use App\Comment;
use App\Discounts;
use App\ReservableCenter;
use App\Room;
use App\Week;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CentersController extends Controller
{
    public function index()
    {
        $reservable_center = ReservableCenter::where("verified", "1")->get();
        $center_type = CenterType::all();

        $center_attributes = \App\CenterAttribute::where('type', 'center')->get();
        $today_date = \Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime(Carbon::now()));
        
        $current_date = date("Y-m-d");
        $current_week = Week::where([
            ["start_date", "<=", $current_date],
            ["end_date", ">=", $current_date],
        ])->first();
        $current_week_id = $current_week->id;
        $reservable_center_not_selled = ReservableCenter::whereHas('room', function ($query) use($current_week_id)  {
            $query->whereHas('room_timing', function ($query)  use($current_week_id) {

                $query->where('week_id','>=',$current_week_id)->where('selled','0');
            });
        })->pluck('id')->toArray();
        return view('users.centers.list', compact('reservable_center', 'center_type', 'center_attributes', 'today_date', 'reservable_center_not_selled'));

    }

    function detailCenter(int $center_id, Request $request, $week = null)
    {
        $reservable_center = ReservableCenter::find($center_id);
        if ($week) {
            $set_week = Week::where("id", $week)->first();

            $current_week = $set_week;

            $current_date = date("Y-m-d");
            $current_weekM6 = Week::where([
                ["start_date", "<=", $current_date],
                ["end_date", ">=", $current_date],
            ])->first();
        } else {
            $current_date = date("Y-m-d");
            $current_weekM6 = $current_week = Week::where([
                ["start_date", "<=", $current_date],
                ["end_date", ">=", $current_date],
            ])->first();
        }


        //If given week id is incorrect , current week will be setted
        if (!isset($set_week->id)) {
            $set_week = $current_week;
        }


        //Determine lingual phrase for set week
        $dif_week = $set_week->id - $current_weekM6->id;
        switch ($dif_week) {
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
                if ($dif_week > 1) {
                    $lingual_set_week = $dif_week . " هفته بعد";
                } else {
                    $edit_enabled = 0;
                    $lingual_set_week = abs($dif_week) . " هفته قبل";
                }
                break;
        }

        $center_room_list = Room::where("reservable_center_id", $reservable_center->id)->select("id")->get();
        $room_timing = DB::table('room_timings')
            ->select('room_timings.*', DB::raw("'n/a' AS operation_status"))
            ->whereIn("room_id", $center_room_list)
            ->where("week_id", $current_week->id)
            ->get();


        $day_mapper = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];
        $Comment = Comment::where(['center_id' => $reservable_center->id, 'state' => 1, 'parent_id' => 0])->orderBy('id', 'DESC')->paginate(10);

        $center_discounts = Discounts::where(['center_id' => $reservable_center->id, 'priority' => 0,])->where('capacity', '>', 0)->get();
        $pelato_disconts = Discounts::where('center_id', 0)->where('capacity', '>', 0)->get();
        Session::forget('discount_center_id');
        Session::put('discount_center_id', $reservable_center->id);


        return view('users.centers.detail', compact('center_discounts', 'pelato_disconts', 'reservable_center', 'day_mapper', 'lingual_set_week', 'current_week', 'set_week', 'room_timing', 'current_weekM6', 'Comment'));
    }

}
