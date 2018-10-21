<?php

namespace App\Http\Controllers\User;

use App\Comment;
use App\Discounts;
use App\Jdf;
use App\ReservableCenter;
use App\Room;
use App\RoomTiming;
use App\Week;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Morilog\Jalali\JalaliServiceProvider;
use Morilog\Jalali\jDate;
use Morilog\Jalali\jDatetime;

class ReservesController extends Controller
{

    public function index(int $center_id, Request $request)
    {


        $reservable_center = ReservableCenter::find($center_id);

        $center_room_list = Room::where("reservable_center_id", $reservable_center->id)->get();

        $room_timing = DB::table('room_timings')
            ->select('room_timings.*', DB::raw("'n/a' AS operation_status"))
            ->whereIn("room_id", $center_room_list)
            ->get();


        $Comment = Comment::where(['center_id' => $reservable_center->id, 'state' => 1, 'parent_id' => 0])->orderBy('id', 'DESC')->paginate(10);


        $center_discounts = Discounts::where(['center_id' => $reservable_center->id, 'priority' => 0,])->where('capacity', '>', 0)->get();
        $pelato_disconts = Discounts::where('center_id', 0)->where('capacity', '>', 0)->get();
        Session::forget('discount_center_id');
        Session::put('discount_center_id', $reservable_center->id);


        return view('users.reserves.index', compact('center_id', 'center_room_list', 'center_discounts', 'pelato_disconts', 'reservable_center', 'room_timing', 'Comment'));
    }


    public function getTimingRoom(Request $request, $center_id)
    {

        /*get rooms id of center*/
        $center_rooms = Room::where("reservable_center_id", $center_id)->get();
        $center_rooms_id = $center_rooms->pluck('id')->toArray();


        /*get date and convert to gregorianDate*/
        $date = $request->input('date');
        $dateArray = explode('-', $date);
        $date = EnFormat($dateArray[1]);
        $jalaliDate = jDate::forge($date);
        $day = $jalaliDate->getDateTime()->format('d');
        $month = $jalaliDate->getDateTime()->format('m');
        $year = $jalaliDate->getDateTime()->format('Y');
        $jdf = new jdf;
        $gregorianDateArray = $jdf->jalali_to_gregorian($year, $month, $day);
        $gregorianDate = $gregorianDateArray[0] . '/' . $gregorianDateArray[1] . '/' . $gregorianDateArray[2];

        /*get week of date selected*/
        $week_id = Week::where('start_date', '<=', $gregorianDate)->where('end_date', '>=', $gregorianDate)->first()->id;


        /*get number of day in one week in jalali*/
        $numberDayOfWeekGregorian = date('w', time($gregorianDate));
        $day_number_mapper = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 0,
        ];
        $numberDayOfWeekJalalli = $day_number_mapper[$numberDayOfWeekGregorian];


        $room_timing = RoomTiming::whereIn('room_id', $center_rooms_id)
            ->where('week_id', $week_id)
            ->where('day', $numberDayOfWeekJalalli)
            ->where('selled', '0')
            ->pluck('room_id', 'start_hour')->toArray();

        return view('users.reserves.showRoomTiming', compact('room_timing', 'center_rooms', 'gregorianDate'));


    }


    public function checkAllowReserve(Request $request)
    {
        $room_id = $request->input('room_id');
        $date = $request->input('date');
        $hour = $request->input('hour');

        /*get week of date selected*/
        $week_id = Week::where('start_date', '<=', $date)->where('end_date', '>=', $date)->first()->id;


        /*get number of day in one week in jalali*/
        $numberDayOfWeekGregorian = date('w', time($date));
        $day_number_mapper = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 0,
        ];
        $numberDayOfWeekJalalli = $day_number_mapper[$numberDayOfWeekGregorian];


        $room_timing = RoomTiming::where('room_id', $room_id)
            ->where('week_id', $week_id)
            ->where('day', $numberDayOfWeekJalalli)
            ->where('start_hour', $hour)
            ->first();


        if (is_null($room_timing) || $room_timing->selled) {
            return response()->json(false);
        }



        $myReserveTime = (array)Session::pull('sessionRoomTiming');



        if (in_array($room_timing->id,$myReserveTime)) {
         unset( $myReserveTime[$room_timing->id]);
        } else {
            $myReserveTime[$room_timing->id]= $room_timing->id;
        }



        Session::put('sessionRoomTiming',$myReserveTime);
        return response()->json(true);

    }

    public function showReservingList()
    {
        $reserveTiming_id = Session::get('sessionRoomTiming');
        $room_timing = RoomTiming::find($reserveTiming_id);

        return view('users.reserves.ReserveList',compact('room_timing'));
    }

}
