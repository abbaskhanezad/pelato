<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomReserveRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\ReservableCenter;
use App\Room;
use App\Week;
use App\RoomTiming;
use App\Comment;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Image;
use App\Http\Requests\profileRequest;
use App\Discounts;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\discountRequest;
use App\OrderRoom;
use App\StatusPayment;
use SoapClient;
use App\CenterorderRoom;
class CenterOwnerController extends Controller
{

    public function get_discount_form()
    {

        $center_id=ReservableCenter::where('user_id',Auth::user()->id)->first();
        $center_id=$center_id->id;
        $Discounts=Discounts::where('center_id',$center_id)->get()->toArray();
        return View('centerOwner.discount.index',['Discounts'=>$Discounts]);
    }
    public function discounts(discountRequest $request)
    {
        if(!empty($request->get('discounts_name')) && !empty($request->get('discounts_value'))&& !empty($request->get('capacity')) )
        {
            $center_id=ReservableCenter::where('user_id',Auth::user()->id)->first();
            $center_id=$center_id->id;


            $discount=new Discounts($request->all());
            $discount->center_id=$center_id;
            $discount->save();
        }

        if($request->has('Discounts'))
        {
            // DB::table('setting')->where('option_name','Discounts')->update(['option_value'=>'Active']);
        }
        else
        {
            //  DB::table('setting')->where('option_name','Discounts')->update(['option_value'=>'InActive']);
        }
        flash_message('کد تخفیف با موفقیت اضافه شد','success');
        return redirect()->back();
    }
    public function del_discounts($id)
    {
        DB::table('discounts')->where('id',$id)->delete();
        flash_message('کد تخفیف با موفقیت حذف شد','success');

        return redirect()->back();
    }



    public function selectday()
    {
        $week=Week::all();
        $current_date = date("Y-m-d");
        $current_week = Week::where([
            ["start_date","<=",$current_date],
            ["end_date",">=",$current_date],
        ])->first();
        $current_week_id = $current_week->id;
        return view('centerOwner.selectday',compact('week','current_week','current_week_id'));
    }


    public function reservesetdaytime(Request $request)
    {



        if ($request->isMethod('post')) {
            $day_id=$request->dayid;
            $week_id=$request->weekid;
            Session::put('dayid', $day_id);
            Session::put('weekid', $week_id);
            // dd(Session::get('dayid'));
        }
        if ($request->isMethod('get'))
        {
            $day_id=Session::get('dayid');
            $week_id=Session::get('weekid');


        }


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

            //dd('1',Session::get('dayid'),$week_id);

            return redirect()->back();
        }

        $edit_enabled = 1;


        //Set Week which will be schedules
        $set_week = Week::where("id",$week_id)->first();

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
        $userid=Auth::user()->id;
        $center=ReservableCenter::where('user_id',$userid)->first();

        /* if($center->id == null){
           $center = ReservableCenter::where("user_id",Auth::user()->id)->first();
           $is_admin = false;
         }else{
           $is_admin = true;
         }*/
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



Session::set('reservefromowner','yes');



        return view('centerOwner.reserve',compact('day_id','week_id','day_mapper','center','is_admin','lingual_set_week','set_week','room_timing','edit_enabled'));

    }

    public function abbas(Request $request)
    {
        if ($request->isMethod('post')) {
            $times=$request->result_to_save;

            Session::put('times', $times);
            // dd(Session::get('dayid'));
        }
        if ($request->isMethod('get'))
        {
            $times=Session::get('times');


        }
       //$times=$request->result_to_save;
        //dd($times);
        $order_list_stringify=$times;
        $times=json_decode($times);
     $final=array();
    foreach ($times as $tm) {
        if ($tm->operation_status=='delete') {
            array_push($final, $tm);
        }
    }
        if(count($final)==0){
            flash_message('هیچ زمانی برای رزرو انتخاب نشده است ','danger');
            return redirect()->back();
        }

        //dd($final);
        $final=json_encode($final);
        $ids = [];
        foreach (json_decode($final) as $order_list) {
            $ids[] = $order_list->id;
        }

        $timing_list = RoomTiming::whereIn("id", $ids)->orderBy("room_id", "ASC")->orderBy("day", "ASC")->orderBy("start_hour", "ASC")->get();

        $active_room = 0;
        $active_day = -1;
        $timing_list_to_show = [];
        $full_price = 0;
        $room_mapper = [];

        foreach ($timing_list as $tl) {
            $full_price += $tl->price;
            //Make Current Room working on
            if ($tl->room_id != $active_room) {
                $active_room = $tl->room_id;
                $room_mapper [$tl->room->id] = ["name" => $tl->room->name, "count" => 0];
            }
            //Make Current Day working on
            if ($tl->day != $active_day) {
                $active_day = $tl->day;
                $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                $room_mapper[$active_room]["count"]++;
            } else {
                if (isset($timing_list_to_show[$active_room][$active_day])) {
                    $previous_index = count($timing_list_to_show[$active_room][$active_day]);
                } else {
                    $previous_index = 0;
                }
                if ($previous_index > 0) {
                    $previous = end($timing_list_to_show[$active_room][$active_day]);
                    if ($previous["end_hour"] == $tl->start_hour) {
                        $timing_list_to_show[$active_room][$active_day][($previous_index - 1)]["end_hour"] = ($tl->start_hour + 1);
                    } else {
                        $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                        $room_mapper[$active_room]["count"]++;
                    }
                } else {
                    $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                    $room_mapper[$active_room]["count"]++;
                }
            }
        }
        $day_mapper = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];

        if (\auth()->user()->type == 4 || \auth()->user()->type == 3) {
            $status_payments = StatusPayment::all();
            return view('centerOwner.order.custom-reserve', compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper', 'status_payments'));


        }

        if (\auth()->user()->type == 2)
        {
            //  dd( $timing_list[0]->room->reservable_center->id,\auth()->user()->reservable_center->id);
            //dd(\auth()->user()->reservable_center->id);
            //$status_payments = StatusPayment::all();
            //return view('order.custom-reserve',  compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper', 'status_payments'));
            if($timing_list[0]->room->reservable_center->id==\auth()->user()->reservable_center->id){

                //makazdar baraye markaze khodesh rezerv mikone
                $status_payments = StatusPayment::all();
                return view('centerOwner.order.centercustom-reserve',  compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper', 'status_payments'));



            }else{
                Session::put('full_price',$full_price);

                return view('centerOwner.order.set', compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper'));

            }


        }


        }







    public function setdaytime(Request $request)
    {
        // dd($request->all());




        if ($request->isMethod('post')) {
            $day_id=$request->dayid;
            $week_id=$request->weekid;
            Session::put('dayid', $day_id);
            Session::put('weekid', $week_id);
            // dd(Session::get('dayid'));
        }
        if ($request->isMethod('get'))
        {
            $day_id=Session::get('dayid');
            $week_id=Session::get('weekid');


        }


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

            //dd('1',Session::get('dayid'),$week_id);

            return redirect()->back();
        }

        $edit_enabled = 1;


        //Set Week which will be schedules
        $set_week = Week::where("id",$week_id)->first();

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
        $userid=Auth::user()->id;
        $center=ReservableCenter::where('user_id',$userid)->first();

        /* if($center->id == null){
           $center = ReservableCenter::where("user_id",Auth::user()->id)->first();
           $is_admin = false;
         }else{
           $is_admin = true;
         }*/
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







        return view('centerOwner.settime',compact('day_id','week_id','day_mapper','center','is_admin','lingual_set_week','set_week','room_timing','edit_enabled'));

    }

    public function profile()
    {
        //  dd(Auth()->user()->id);
        $user=User::find(Auth()->user()->id);
        Session::put('userid',  $user);
        return View('centerOwner.Profile',['model'=>$user]);

    }
    public function update(profileRequest $request)
    {
        //  $doctor=Doctor::find($id);
        //  $doctor->update($request->all());
        // dd(session()->get('userid')->id);

        $user=User::find(session()->get('userid')->id);

        $user->update(['name'=>$request->name,'family'=>$request->family,'mobile'=>$request->mobile,'email'=>$request->email]);
        flash_message('عملیات با موفقیت انجام شد','success');
        return redirect()->back();

    }

    public function index()
    {

        $user_id=Auth::user()->id;
        $reservable_center = ReservableCenter::where("user_id",Auth::user()->id)->first();
        $center_id=$reservable_center->id;
        $commentcount=Comment::where(['center_id'=>$reservable_center->id,'state'=>1])->count();
        $timecount=RoomTiming::whereHas('room',function ($q) use($center_id){
            $q->whereHas('reservable_center',function ($q) use($center_id){

                $q->where('id',$center_id);
            } );


        })->where('selled',1)->count();
        $income=(RoomTiming::whereHas('room',function ($q) use($center_id){
                    $q->whereHas('reservable_center',function ($q) use($center_id){

                        $q->where('id',$center_id);
                    } );


                })->where('selled',1)->sum('price')*1000)*0.9;


        return view('centerOwner.index',compact('commentcount','timecount','income','reservable_center'));

    }



    public function login(Request $request)
    {
        // dd($request->all());
        //  $user = User::all()->where('username' , '=' , $request->username)->where('password',$request->password)->first();

        if (Auth::attempt(array('username' => $request->username, 'password' => $request->password,'type'=>2))) {

            return redirect('centerowner/panel');
        }

        if (Auth::attempt(array('username' => $request->username, 'password' => $request->password,'type'=>1))) {

            return redirect('users/index');
        }
        flash_message('کاربری با این مشخصات وجود ندارد','danger');
        return redirect()->back();
    }


    public function show(){

        $reservable_center = ReservableCenter::where("user_id",Auth::user()->id)->first();

        return view('centerOwner.center_index',compact('reservable_center'));

    }


    function timing(Request $request,ReservableCenter $center){
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
        // var_dump($current_week_id);


        //$orders = OrderRoom::with('room_timing', 'statusPayment')->where('paid', 1)->orderBy('id', 'desc')->latest('id')->get();

        /*
               $orderRoom=OrderRoom::whereHas('room_timing' , function($query) use($current_week_id){
                   $query->whereWeekId($current_week_id);
               })->where([
                   ['status_payment_id',1],
                   ['paid',1]
               ])->get();

             $online=RoomTiming::whereHas('order_room',function ($query){
                   $query->where([
                           ['status_payment_id',1],
                           ['paid',1]  ]);
               })->whereHas('room',function ($query){
                   $query->where(
                       ['resevable_center_id',1]);
               })->where('week_id',$current_week_id)->get();


               $cart=RoomTiming::whereHas('order_room',function ($query){
                   $query->where([
                       ['status_payment_id',2],
                       ['paid',1]  ]);
               })->where('week_id',$current_week_id)->get();

               $hozuri=RoomTiming::whereHas('order_room',function ($query){
                   $query->where([
                       ['status_payment_id',3],
                       ['paid',1]  ]);
               })->where('week_id',$current_week_id)->get();

       */


        return view('centerOwner.centertiming',compact('center','is_admin','weeks','current_week_id'));
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

        return view('centerOwner.timingset',compact('day_mapper','center','is_admin','lingual_set_week','set_week','room_timing','edit_enabled'));
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



    function room_list(Room $room , Request $request){
        return view('centerOwner/image.index',compact('room'));

    }

    function room_add(Room $room,Request $request){
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if (!$validator->fails()) {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'images'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = md5(time()).'.'.$extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                \FolkloreImage::make($destinationPath.'/'.$fileName,array(
                    'width' => 800,
                ))->save($destinationPath.'/'.$fileName);
                // sending back with message

                Image::create([
                    'owner_id' => $room->id,
                    'owner_type' => 2,
                    "picture" => $fileName
                ]);
                flash_message("عکس با موفقیت آپلود شد",'success');
            }else {
                // sending back with error message.
                flash_message("آپلود عکس با مششکل مواجه شد",'danger');
            }
        }
        return view('centerOwner/image.index',compact('room'));
    }


    function room_delete(Room $room, Image $image){
        \File::delete('images/'.$image->picture);
        $state = $image->delete();
        if($state){
            flash_message("عکس با موفقیت حذف شد.","success");
        }else{
            flash_message("حذف عکس با مشکل مواجه شد.","danger");
        }
        return redirect('/centerowner/image/room/'.$room->id.'/list');

    }

    function reservable_center_poster(Request $request){

        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('/centerowner/dashboard')->withInput()->withErrors($validator);
        }else{
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'images'; // upload path
                $destinationThumbnailPath = 'images_thumb'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = md5(time()).'.'.$extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                \FolkloreImage::make($destinationPath.'/'.$fileName,array(
                    'width' => 800,
                ))->save($destinationPath.'/'.$fileName);
                \FolkloreImage::make($destinationPath.'/'.$fileName,array(
                    'width' => 300,
                    'height' => 300,
                    'crop' => true,
                ))->save($destinationThumbnailPath.'/'.$fileName);
                // sending back with message

                $reservable_center = ReservableCenter::where("user_id","=",Auth::user()->id)->first();
                if(isset($reservable_center->image->picture)){
                    \File::delete('images/'.$reservable_center->image->picture);
                    \File::delete('images_thumb/'.$reservable_center->image->picture);
                    $reservable_center->image->update(['picture' => $fileName]);
                }else{
                    Image::create([
                        'owner_id' => $reservable_center->id,
                        'owner_type' => 1,
                        "picture" => $fileName
                    ]);
                }
                flash_message("عکس با موفقیت آپلود شد",'success');
                return redirect('/centerowner/dashboard');
            }else {
                // sending back with error message.
                flash_message("آپلود عکس با مششکل مواجه شد",'danger');
                return redirect('/centerowner/dashboard');
            }
        }
    }





    public function specific_orders()
    {
        $center = ReservableCenter::where("user_id",Auth::user()->id)->first();


        $orders = OrderRoom::with('room_timing', 'statusPayment')->where('paid', 1)->orderBy('id', 'desc')->latest('id')->get();
        // $whole = $orders->sum('whole_price');
        // var_dump($whole*1000);
        $newData = collect();
        foreach ($orders as $order)
        {
            foreach ($order->room_timing()->get() as $roomTiming)
            {
                $room_id =  $roomTiming->room_id;
                $time = collect($order)->merge(['room_id' => $room_id]);
                $time->forget(['room_timing', 'status_payment' ]);
                $newData->push($time);
            }

        }
        $orders = $newData->unique('id')->toArray();



        $statusPayments = StatusPayment::all()->pluck('title', 'id');
        return view('centerOwner.specific_archive_all', compact('orders', 'statusPayments','center'));

    }




    public function myspecific_orders()
    {
        $center = ReservableCenter::where("user_id",Auth::user()->id)->first();


        $orders = CenterorderRoom::with('room_timing', 'statusPayment')->where('paid', 1)->orderBy('id', 'desc')->latest('id')->get();
        // $whole = $orders->sum('whole_price');
        // var_dump($whole*1000);
        $newData = collect();
        foreach ($orders as $order)
        {
            foreach ($order->room_timing()->get() as $roomTiming)
            {
                $room_id =  $roomTiming->room_id;
                $time = collect($order)->merge(['room_id' => $room_id]);
                $time->forget(['room_timing', 'status_payment' ]);
                $newData->push($time);
            }

        }
        $orders = $newData->unique('id')->toArray();



        $statusPayments = StatusPayment::all()->pluck('title', 'id');
        return view('centerOwner.myspecific_archive_all', compact('orders', 'statusPayments','center'));

    }



    function archive_detail(OrderRoom $order)
    {
        //My Codes
        $has_not_reserved_hour = 0;
        $syncData = [];
        $ids = [];
        foreach ($order->room_timing as $o) {
            $ids [] = $o->id;

            if ($o->selled) {
                $has_not_reserved_hour = 1;
                $syncData[$o->id] = ['reserved' => 2];
            } else {
                $syncData[$o->id] = ['reserved' => 1];
            }
        }

        $order->room_timing()->sync($syncData);
        $timing_list = RoomTiming::whereIn("id", $ids)->orderBy("room_id", "ASC")->orderBy("day", "ASC")->orderBy("start_hour", "ASC")->get();

        $active_room = 0;
        $active_day = -1;
        $timing_list_to_show = [];
        $full_price = 0;
        $room_mapper = [];

        $rs = Room::where("id", $timing_list[0]->room_id)->first();
        $rs = ReservableCenter::where("id", $rs->reservable_center_id)->first();

        foreach ($timing_list as $tl) {
            $full_price += $tl->price;
            //Make Current Room working on
            if ($tl->room_id != $active_room) {
                $active_room = $tl->room_id;
                $room_mapper [$tl->room->id] = ["name" => $tl->room->name, "count" => 0];
            }
            //Make Current Day working on
            if ($tl->day != $active_day) {
                $active_day = $tl->day;
                $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                $room_mapper[$active_room]["count"]++;
            } else {
                if (isset($timing_list_to_show[$active_room][$active_day])) {
                    $previous_index = count($timing_list_to_show[$active_room][$active_day]);
                } else {
                    $previous_index = 0;
                }
                if ($previous_index > 0) {
                    $previous = end($timing_list_to_show[$active_room][$active_day]);
                    if ($previous["end_hour"] == $tl->start_hour) {
                        $timing_list_to_show[$active_room][$active_day][($previous_index - 1)]["end_hour"] = ($tl->start_hour + 1);
                    } else {
                        $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                        $room_mapper[$active_room]["count"]++;
                    }
                } else {
                    $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                    $room_mapper[$active_room]["count"]++;
                }
            }
        }
        // $full_price = $order->whole_price;
        $day_mapper = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];
        return view('centerOwner.archive_detail', compact('timing_list_to_show', 'full_price', 'room_mapper', 'day_mapper', 'rs'));
    }


    public function showresetform()
    {
        return view('centerOwner.resetpass');
}

    public function reset2()
    {
        return view('auth.passwords.reset');

    }

    function reset(Request $request)
    {
        $user = User::where("mobile", $request->phone)->first();
        if($user)
        {
            $mbl = $user->mobile;
            // $new_password = rand(11, 99) . str_random(3) . rand(11, 99);
            //$user->password = Hash::make($new_password); // Hash::make()
            // $user->update();
            $new_password = rand(11, 99) . rand(11, 99) . rand(11, 99);
            Session::set('sms',$new_password);
            Session::set('mobile',$mbl);
            // turn off the WSDL cache
            ini_set("soap.wsdl_cache_enabled", "0");
            /*
            try {
                $client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
                $user = "axsazi";
                $pass = "66251674";
                $fromNum = "+98100020400";
                $toNum = $mbl;
                $messageContent = 'کاربر عزیز سایت پلاتو کد تغییر رمز عبور شما: '.$new_password;
                $op  = "send";
                //If you want to send in the future  ==> $time = '2016-07-30' //$time = '2016-07-30 12:50:50'

                $time = '';

                $client->SendSMS($fromNum,$toNum,$messageContent,$user,$pass,$time,$op);
            }
            catch (SoapFault $ex) {
                //echo $ex->faultstring;
            }


*/

            $client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
            $user = "axsazi";
            $pass = "66251674";
            $fromNum = "+98100020400";
            $toNum = array($mbl);
            //$messageContent = 'کاربر عزیز سایت پلاتو کد تغییر رمز عبور شما: '.$new_password;

            $pattern_code = "121";
            $input_data = array(
                "activate-code" => $new_password,

            );
            $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);






            // flash_message("بازیابی با موفقیت صورت گرفت.رمز جدید را برایتان به صورت پیامکی ارسال کردیم.","success");
        }
        else
        {
            flash_message("شماره تلفن وارد شده صحیح نیست.","danger");
            return redirect()->back();
        }
        flash_message("با استفاده از کد پیامکی دریافتی اقدام به تغییر رمز عبور خود نمایید","success");
        return view('centerOwner.changepass');
    }

    public function changepassword(changepassRequest $request){

        $mob=Session::get('mobile');
        $user=User::where('mobile',$mob)->orWhere('username',$mob)->first();
        $conf=Session::get('sms');
        //dd($conf);
        if($conf!=$request->code){
            flash_message('کد وارد شده با ارسالی مطابقت ندارد','danger');
            return redirect()->back();
        }
        if($user){

            $new_password = $request->password;
            $user->password = Hash::make($new_password); // Hash::make()
            $user->update();
            flash_message('رمز عبور با موقیت تغییر یافت','success');
            return redirect('/centerlogin');
        }




    }


    public function selectreserve()
    {
        $week=Week::all();
        $current_date = date("Y-m-d");
        $current_week = Week::where([
            ["start_date","<=",$current_date],
            ["end_date",">=",$current_date],
        ])->first();
        $current_week_id = $current_week->id;
        return view('centerOwner.selectreserveday',compact('week','current_week','current_week_id'));
    }

    public function reservecenter(CustomReserveRequest $request)
    {


        $usertype=$request->usertype;
        $user = User::whereMobile($request->mobile)->first();
        if (!$user) {
            $password = $new_password = rand(11, 99) .rand(11, 99) . rand(11, 99);
            // $message = 'کاربر عزیز سایت پلاتو رمز عبور شما: ' . $password;
            $message=' کاربر عزیز سایت پلاتو،نام کاربری شما '.
                $request->mobile
                .'  و رمز عبور شما:'
                . $password
                .'می باشد';
            // $this->sendSMS($request->mobile, $message);
            $user = User::create([
                'username' => $request->mobile,
                'mobile' => $request->mobile,
                'name' => $request->user_name,
                'type'=>1,
                'confirm'=>1,
                'password' => bcrypt( $request->mobile)
            ]);
        }
        $order_list_stringify = $request->final_order_list;
        //Get Timing List and package it to show and validate
        $ids = [];
        foreach (json_decode($order_list_stringify) as $order_list) {
            $ids[] = $order_list->id;
        }
        $final_timing_list = RoomTiming::whereIn("id", $ids)->orderBy("room_id", "ASC")->get();

        $whole_price = 0;
        $has_not_reserved_hour = 0;
        $room_timing = [];
        foreach ($final_timing_list as $ftl) {
            if ($ftl->selled == 0) {
                $whole_price += $ftl->price;
            } else {
                $has_not_reserved_hour = 1;
            }
            $room_timing[] = $ftl->id;
        }

// ($request->price)/1000
        if($usertype==0){
            $order_room = new CenterorderRoom(
                [
                    "user_id" => $user->id,
                    "center_id"=> \auth()->user()->reservable_center->id,
                    // "whole_price" => $whole_price,
                    "whole_price" => $request->price/1000,
                    "paid" => 1,
                    "status_payment_id" => $request->status_payment
                ]
            );
        }else{
            $order_room = new OrderRoom(
                [
                    "user_id" => $user->id,
                    "center_id"=> \auth()->user()->reservable_center->id,
                    // "whole_price" => $whole_price,
                    "whole_price" => $request->price/1000,
                    "paid" => 1,
                    "status_payment_id" => $request->status_payment
                ]
            );
        }

        $order_room->save();
        $inserted_id = $order_room->id;
        // dd($room_timing);
        $order_room->room_timing()->attach($room_timing);

        //My Codes
        if($usertype==0) {

            $order = CenterorderRoom::whereId($inserted_id)->first();
        }else{
            $order = OrderRoom::whereId($inserted_id)->first();

        }
        $has_not_reserved_hour = 0;
        $syncData = [];
        $ids = [];
        foreach ($order->room_timing as $o) {
            $ids [] = $o->id;

            if ($o->selled) {
                $has_not_reserved_hour = 1;
                $syncData[$o->id] = ['reserved' => 2];
            } else {
                $syncData[$o->id] = ['reserved' => 1];
            }
        }

        $order->room_timing()->sync($syncData);
        foreach ($order->room_timing as $rt) {
            $rt->update(["selled" => 1]);
        }

        $order->update([
            "paid" => 1,
            "has_not_reserved_hour" => $has_not_reserved_hour,
            "mellat_pay_ref_id" => '',
        ]);

        $timing_list = RoomTiming::whereIn("id", $ids)->orderBy("room_id", "ASC")->orderBy("day", "ASC")->orderBy("start_hour", "ASC")->get();

        $active_room = 0;
        $active_day = -1;
        $timing_list_to_show = [];
        $full_price = 0;
        $room_mapper = [];

        foreach ($timing_list as $tl) {
            $full_price += $tl->price;
            //Make Current Room working on
            if ($tl->room_id != $active_room) {
                $active_room = $tl->room_id;
                $room_mapper [$tl->room->id] = ["name" => $tl->room->name, "count" => 0];
            }
            //Make Current Day working on
            if ($tl->day != $active_day) {
                $active_day = $tl->day;
                $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                $room_mapper[$active_room]["count"]++;
            } else {
                if (isset($timing_list_to_show[$active_room][$active_day])) {
                    $previous_index = count($timing_list_to_show[$active_room][$active_day]);
                } else {
                    $previous_index = 0;
                }
                if ($previous_index > 0) {
                    $previous = end($timing_list_to_show[$active_room][$active_day]);
                    if ($previous["end_hour"] == $tl->start_hour) {
                        $timing_list_to_show[$active_room][$active_day][($previous_index - 1)]["end_hour"] = ($tl->start_hour + 1);
                    } else {
                        $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                        $room_mapper[$active_room]["count"]++;
                    }
                } else {
                    $timing_list_to_show[$active_room][$active_day][] = ["start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
                    $room_mapper[$active_room]["count"]++;
                }
            }
        }

        $roomG = Room::find($order->room_timing[0]->room_id);


        if ($request->status_payment == 3) {
            $message1 = "برای" . " " . $roomG->reservable_center->name . " " . "توسط " . " " . $order->user->name . " " .
                $order->user->mobile
                . " " .
                "رزرو ثبت شد" . "\n".
                "(هزینه حضوری دریافت گردد)";
        }

        if ($request->status_payment == 2) {
            $message1 = "برای" . " " . $roomG->reservable_center->name . " " . "توسط " . " " . $order->user->name . " " .
                $order->user->mobile
                . " " .
                "رزرو ثبت شد" . " ";
        }


        $day_mapper = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];

        $message = "";
        foreach ($timing_list_to_show as $room_key => $room) {
            $message .= $room_mapper[$room_key]["name"] . " ";
            foreach ($room as $day_key => $day) {
                $message .= $day_mapper[$day_key] . " ";
                foreach ($day as $hour) {
                    $message .= $hour["start_hour"] . '-' . $hour["end_hour"] . " ";
                }

            }
        }

        if ($request->status_payment == 2) {
            $message2 = $order->user->name
                . " " .
                "عزیز. رزرو شما در"
                . " " .
                $roomG->reservable_center->name
                . " " .
                $message
                . " " .
                $roomG->reservable_center->address . " "
                . "با موفقیت ثبت شد" . "\n".
                "هزینه پرداختی شما مبلغ". " ".
                $whole_price * 1000 . " " . "تومان می باشد" . "\n".
                "لطفا از طریق لینک زیر هزینه خود را پرداخت کنید" . "\n"
                ."pelato.ir/pay/" . "\n"
                . " " . "pelato.ir";
        }

        if ($request->status_payment == 3) {
            $message2 = $order->user->name
                . " " .
                "عزیز. رزرو شما در"
                . " " .
                $roomG->reservable_center->name
                . " " .
                $message
                . " " .
                $roomG->reservable_center->address . " "
                . "با موفقیت ثبت شد" . "\n".
                "لطفا مبلغ " . " "
                . $whole_price * 1000 .
                " تومان به مرکز مورد نظر تحویل دهید" . "\n" .
                "pelato.ir";
        }

        // $this->sendSMS($order->user->mobile, $message2);

        $message.=' '."pelato.ir";

        // $this->sendSMS($roomG->reservable_center->user->mobile,$message1 . $message);
        flash_message('رزرو با موفقیت انجام شد','success');
        return redirect('/centerowner/reserve/setdaytime');

    }

}