<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Package;
use App\ReservableCenter;
use App\Comment;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use App\CenterAttribute;
use App\CenterType;
use Illuminate\Support\Facades\DB;
use jDateTime;
use jDate;
use App\Week;
use App\Http\Requests\advsearchRequest;
use App\Http\Requests\commentRequest;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

	public function search(){
    	if (isset($_GET['name']) && isset($_GET['address']) && isset($_GET['expert'])) {
			session([
				'searchName' => $_GET['name'],
				'searchExpert' => $_GET['expert'],
				'searchAddress' => $_GET['address']
			]);
			if (isset($_GET["sex"]))
				session(["searchSex"=>$_GET['sex']]);
			else{
				session(['searchSex'=> ""]);
			}
			return redirect(route('search_result'));
		}
    	else{
    		return redirect("/");
		}
	}
	public function searchResult(Request $request){


       // var_dump($center1);
      /*

*/
     // var_dump($request->all());
        $attr=$request->attribute;
        $size=$request->size;
        $allattr=CenterAttribute::pluck('id')->toArray();
       // var_dump(array_intersect($attr, $allattr));


     if($request->name) {

         //var_dump($request->name);
         $reservable_center = ReservableCenter::where("verified","1")->where('name', 'like', "%$request->name%")->get();


    }
    elseif($request->size && count($request->attribute)==0){
$reservable_center = ReservableCenter::whereHas('room', function ($query) use($size) {
    $query->where('size','>=', $size);
})->where("verified","1")->get();

}
elseif ( count($request->attribute)>0){
         /*
         $reservable_center = ReservableCenter::whereHas('center_attribute', function ($query) use($attr) {
             $query->whereIn('id',$attr);
         })->get();
*/

         $reservable_center=array();
         $reservable_centers = ReservableCenter::where("verified","1")->whereHas('room', function ($query) use($size) {
             $query->where('size','>=', $size);
         })->get();
         foreach ($reservable_centers as $rc) {
             $hasattrs=array();
             foreach ($rc->center_attribute as $ca){

                 array_push($hasattrs, $ca->id);
             }

if(count(array_intersect($attr, $hasattrs))==count($attr)){
    array_push($reservable_center, $rc);

}

         }
         $object = json_decode (json_encode ($reservable_center), FALSE);


    }
    elseif ($request->size=="" && count($request->attribute)==0 && $request->name=="" ){
         $reservable_center = ReservableCenter::where("verified","1")->get();
     }

        $center_type = CenterType::all();

        $center_attributes=\App\CenterAttribute::where('type','center')->get();

        //return view('reservable_center.public_listing',compact('reservable_center','center_type'));
        //var_dump($request->size);
        $request_attr=$request->attribute;
        $request_size=$request->size;

        /*     $reservable_center = ReservableCenter::whereHas('center_attribute', function ($query)  use($attr) {
                 $query->whereIn('center_attribute_id',$attr );
             })->get();

             $reservable_center = ReservableCenter::whereHas('center_attribute', function ($query)  use($attr) {
                 $query->where('id',$attr );
             })->toSql();
     */

//var_dump($reservable_center);
//var_dump($attr);
     return view('reservable_center.search_listing',compact('reservable_center','center_type','center_attributes','request_attr','request_size'));

	}

    public function adv_searchResult(advsearchRequest $request)
    {




        $center_type = CenterType::all();
        $allattr = CenterAttribute::pluck('id')->toArray();
        $center_attributes = \App\CenterAttribute::where('type', 'center')->get();
        $request_attr = $request->attribute;
        $request_size = $request->size;
        $request_attr = array();
        $reservable_center=array();
        $request_attr = $request->attribute;
        $name = $request->name;
        $attr = $request->attribute;
        $size = $request->size;
        if($request->mony){
            $price = (int)floor($request->money / 1000);

        }else{
            $price=(int)100000000;
        }
        // var_dump($price);

       $tarikh=$request->rooz;
       $mablagh=$request->money;
       $saat=$request->time;
        $time = substr($request->time, 0, 2);
        $time = (int)$time;

        $azsaat=$request->time;
        $tasaat=$request->endtime;
        $endtime = substr($request->endtime, 0, 2);
        $endtime = (int)$endtime;

        if($endtime<=$time){
            flash_message('زمان شروع باید کمتر از زمان پایان باشد','warning');

            return redirect()->back();
        }

        // var_dump($time);
        $date = jDateTime::createCarbonFromFormat('Y-m-d', $request->rooz)->format('Y-m-d');
        //var_dump($date);
        // $day=jddayofweek($date,0);
        $day = date('w', strtotime($date));
        $day = $day + 1;
        if ($day >= 7) {
            $day = $day - 7;
        }
        //  var_dump($day);

        $week = Week::where([
            ["start_date", "<=", $date],
            ["end_date", ">=", $date],
        ])->first();
        $week_id = $week->id;
        //var_dump($week->id);


        if ($request->name == "" && count($request_attr) == 0) {


            /*   SQL CODE
                    $reservable_center = DB::select("select * from reservable_centers
            where verified = 1 and exists (select * from rooms
             where rooms.reservable_center_id = reservable_centers.id   and exists (select * from room_timings
             where room_timings.room_id = rooms.id and week_id = '$week_id' and size>='$size' and room_timings.price<='$price' and start_hour='$time' and selled='0' and day='$day'  ))");

            */

            $reservable_center = ReservableCenter::where("verified", "1")->whereHas('room', function ($q) use ($price, $week_id, $time, $size, $price, $day) {
                $q->whereHas('room_timing', function ($q) use ($week_id, $time, $size, $price, $day) {
                    $q->where('week_id', '=', $week_id)
                        ->where('size', '>=', $size)
                        ->where('price', '<=', $price)
                        ->where('start_hour', '=', $time)
                        ->where('day', '=', $day)
                        ->where('selled', '=', 0);
                });
            })->get();

           // var_dump('aa');
        }


        if ($request->name <> "" && count($request_attr) == 0) {


            /*   SQL CODE
                    $reservable_center = DB::select("select * from reservable_centers
            where verified = 1 and exists (select * from rooms
             where rooms.reservable_center_id = reservable_centers.id   and exists (select * from room_timings
             where room_timings.room_id = rooms.id and week_id = '$week_id' and size>='$size' and room_timings.price<='$price' and start_hour='$time' and selled='0' and day='$day'  ))");

            */

            $reservable_center = ReservableCenter::where("verified", "1")->where('name', 'like', "%$name%")->whereHas('room', function ($q) use ($price, $week_id, $time, $size, $price, $day) {
                $q->whereHas('room_timing', function ($q) use ($week_id, $time, $size, $price, $day) {
                    $q->where('week_id', '=', $week_id)
                        ->where('size', '>=', $size)
                        ->where('price', '<=', $price)
                        ->where('start_hour', '=', $time)
                        ->where('day', '=', $day)
                        ->where('selled', '=', 0);
                });
            })->get();
         //   var_dump('bb');

        }


        if ($request->name <> "" && count($request_attr) > 0) {


            /*   SQL CODE
                    $reservable_center = DB::select("select * from reservable_centers
            where verified = 1 and exists (select * from rooms
             where rooms.reservable_center_id = reservable_centers.id   and exists (select * from room_timings
             where room_timings.room_id = rooms.id and week_id = '$week_id' and size>='$size' and room_timings.price<='$price' and start_hour='$time' and selled='0' and day='$day'  ))");

            */

          $reservable_centers = ReservableCenter::where("verified", "1")->where('name', 'like', "%$name%")->whereHas('room', function ($q) use ($price, $week_id, $time, $size, $price, $day) {
                $q->whereHas('room_timing', function ($q) use ($week_id, $time, $size, $price, $day) {
                    $q->where('week_id', '=', $week_id)
                        ->where('size', '>=', $size)
                        ->where('price', '<=', $price)
                        ->where('start_hour', '=', $time)
                        ->where('day', '=', $day)
                        ->where('selled', '=', 0);
                });
            })->get();

          /*  $reservable_centers = ReservableCenter::where("verified","1")->whereHas('room', function ($query) use($size) {
                $query->where('size','>=', $size);
            })->get();*/



            foreach ($reservable_centers as $rc) {
                $hasattrs=array();
                foreach ($rc->center_attribute as $ca){

                    array_push($hasattrs, $ca->id);
                }

                if(count(array_intersect($attr, $hasattrs))==count($attr)){
                    array_push($reservable_center, $rc);

                }

            }


            $object = json_decode (json_encode ($reservable_center), FALSE);


                var_dump('cc');


        }

        if ($request->name =="" && count($request_attr) > 0) {


            /*   SQL CODE
                    $reservable_center = DB::select("select * from reservable_centers
            where verified = 1 and exists (select * from rooms
             where rooms.reservable_center_id = reservable_centers.id   and exists (select * from room_timings
             where room_timings.room_id = rooms.id and week_id = '$week_id' and size>='$size' and room_timings.price<='$price' and start_hour='$time' and selled='0' and day='$day'  ))");

            */

            $reservable_centers = ReservableCenter::where("verified", "1")->whereHas('room', function ($q) use ($price, $week_id, $time, $size, $price, $day) {
                $q->whereHas('room_timing', function ($q) use ($week_id, $time, $size, $price, $day) {
                    $q->where('week_id', '=', $week_id)
                        ->where('size', '>=', $size)
                        ->where('price', '<=', $price)
                        ->where('start_hour', '=', $time)
                        ->where('day', '=', $day)
                        ->where('selled', '=', 0);
                });
            })->get();

            /*  $reservable_centers = ReservableCenter::where("verified","1")->whereHas('room', function ($query) use($size) {
                  $query->where('size','>=', $size);
              })->get();*/



            foreach ($reservable_centers as $rc) {
                $hasattrs=array();
                foreach ($rc->center_attribute as $ca){

                    array_push($hasattrs, $ca->id);
                }

                if(count(array_intersect($attr, $hasattrs))==count($attr)){
                    array_push($reservable_center, $rc);

                }

            }


            $object = json_decode (json_encode ($reservable_center), FALSE);


          //  var_dump('dd');


        }

//var_dump($reservable_center);

        $start_hour=$time;
        $end_hour=$endtime;
           $saatdarkhasti=array();
        for($i=$start_hour;$i<$end_hour;$i++){
            array_push($saatdarkhasti,$i);
        }
      //  var_dump($saatdarkhasti);
        //$baze=$end_hour-$start_hour;
        $final=array();
        $hours=array();
 foreach ($reservable_center as $rc){
     foreach ($rc->room as $rcr){
         foreach ($rcr->room_timing as $rcrt){
             $cnt=0;
            if($rcrt->week_id==$week_id && $rcrt->selled==0 && $rcrt->day==$day && $rcrt->price<=$price && $rcrt->size >=$size ){
                array_push($hours,$rcrt->start_hour);
            }



             //}


         }

         if(count(array_intersect($saatdarkhasti, $hours))==count($saatdarkhasti)){
             array_push($final, $rcr->reservable_center);

         }
         $hours=array();

       //  var_dump($rcr->reservable_center->name);
        // var_dump($hours);


     }
 }

//var_dump(count(array_unique($final)));
        $final=array_unique($final);
      /*  $object = json_decode (json_encode ($final), FALSE);
        foreach ($object as $ob){
            var_dump($ob->name);
        }

      */
$reservable_center=$final;



          return view('reservable_center.advsearch_listing', compact('reservable_center', 'center_type', 'center_attributes', 'request_attr', 'request_size','tarikh','mablagh','name','azsaat','tasaat'));
    }



/*

 $rc= $reservable_centers = ReservableCenter::where("verified","1")->whereHas('room', function ($query) use($price ,$week_id) {
            $query->where('price_per_hour','<=', $price)
        })->get();



 */

    public function comment(commentRequest $request)
    {
        if($request->has('center_id'))
        {
            $center_id = $request->get('center_id');
            if (ReservableCenter::find($center_id))
            {
                $Comment=new Comment($request->all());
                $Comment->state=0;
                $Comment->time=time();
                $Comment->name=Auth::user()->name;
                $Comment->user_id=Auth::user()->id;
                $Comment->email=Auth::user()->email;
                //dd($Comment);
                $Comment->save();
                flash_message('نظر شما با موفقیت ثبت شد. پس از تایید در سایت نمایش داد خواهد شد','success');

                return redirect()->back()->with('create','ok');
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    public function abbas(){
$weekid=146;
        $reservable_center = ReservableCenter::whereHas('room', function ($query) use($weekid)  {
            $query->whereHas('room_timing', function ($query)  use($weekid) {

                $query->where('week_id','>=',$weekid)->where('selled',0);
            });
        })->get();
        $datetime = date("Y-m-d");
        $day_num = date('w', strtotime($datetime));
        $day_num=$day_num+1;
        if($day_num>=7){
            $day_num=$day_num-7;
        }
      dd($day_num);
}


    public function kh(){
        $a = ReservableCenter::with('star')->get()->sortBy(function($stars)
        {
            return $stars->star->count();
        })->reverse();
        $a = User::with('order_room')->get()->sortBy(function($stars)
        {
            return $stars->order_room->count();
        })->reverse();

        //$a = User::withCount('order_room')->get();
       foreach ($a as $b){
           echo $b->name;
           echo '/';
           echo $b->order_room->count();
           echo '<br>';
       }
    }


}


