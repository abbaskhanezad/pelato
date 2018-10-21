<?php

namespace App\Http\Controllers;

use App\Week;
use Illuminate\Http\Request;
use App\StatusPayment;
use Illuminate\Support\Facades\Auth;
use App\RoomTiming;
use App\OrderRoom;
use App\ReservableCenter;
use App\Room;
use DB;
use SoapClient;
use phpDocumentor\Reflection\Types\This;
use Larabookir\Gateway\MELLAT\MELLAT;
use App\User;
use Illuminate\Support\Facades\Session;
use App\Discounts;
use App\CenterorderRoom;





class OrderController extends Controller
{
    function set(Request $request)
    {
        $order_list_stringify = $request->order_list;
      //  dd($order_list_stringify);
        //Get Timing List and package it to show and validate
        $ids = [];
        foreach (json_decode($order_list_stringify) as $order_list) {
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

    if (\auth()->user()->type == 4 || \auth()->user()->type == 3)
        {
            $status_payments = StatusPayment::all();
            return view('order.custom-reserve',  compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper', 'status_payments'));
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
           return view('order.centercustom-reserve',  compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper', 'status_payments'));



       }else{
           Session::put('full_price',$full_price);

           return view('order.set', compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper'));

       }


        }

	  Session::put('full_price',$full_price);

return view('order.set', compact('timing_list_to_show', 'full_price', 'order_list_stringify', 'room_mapper', 'day_mapper'));
}

    function pay(Request $request)
    {
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

        if(Session::has('discounts')){
			$whole_price=$whole_price-($whole_price*Session::get('discounts')/100);
		}



        try {
            if(Session::has('pelato_discount')){
               // dd(Session::get('pelato_discount'));
                $pelato_discount=Session::get('pelato_discount');
                Session::forget('pelato_discount');

            }else{
                $pelato_discount=0;
            }

            if(Session::has('discount_id')){
                // dd(Session::get('pelato_discount'));

                $discount_id=Session::get('discount_id');
                Session::forget('discount_id');

            }else{
                $discount_id=0;
            }


            $order_room = new OrderRoom(
                [
                    "user_id" => Auth::user()->id,
                    "whole_price" => $whole_price,
                    "paid" => 0,
                    "pelato_discount"=>$pelato_discount,
                    "discount_id"=>$discount_id,
                    "mellat_pay_ref_id" => "",
                    "has_not_reserved_hour" => $has_not_reserved_hour,
                ]
            );
            $order_room->save();
            $inserted_id = $order_room->id;
            $order_room->room_timing()->attach($room_timing);

            $gateway = \Gateway::mellat();
            $gateway = \Gateway::setCallback('/order/payback/' . $inserted_id);
            $gateway->price(($whole_price * 10000))->ready();


            return $gateway->redirect();
        } catch (Exception $e) {
            flash_message("شروع روند پرداخت با مشکل مواجه شد.", "danger");
            return back();
        }
    }

    function payback(Request $request, OrderRoom $order)
    {


       try {
            $gateway = \Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId =$gateway->refId();
            $cardNumber = $gateway->cardNumber();


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
		
            foreach ($order->room_timing as $rt) {
                $rt->update(["selled" => 1]);
            }

            $order->update([
                "paid" => 1,
                "has_not_reserved_hour" => $has_not_reserved_hour,
                "mellat_pay_ref_id" => $gateway->trackingCode(),
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

            //hm add
            // send sms
            // turn off the WSDL cache


        $roomG = Room::find($order->room_timing[0]->room_id);



            $message1 = "برای" ." ". $roomG->reservable_center->name ." ". "توسط " ." ". $order->user->name ." ".
                $order->user->mobile
                ." ".
                "رزرو ثبت شد"." ";


            $day_mapper = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];

           $message="";
            foreach ($timing_list_to_show as $room_key => $room) {
                $message.= $room_mapper[$room_key]["name"]." ";
                foreach ($room as $day_key => $day) {
                    $message.=$day_mapper[$day_key]." ";
                    foreach ($day as $hour) {
                        $message.=$hour["start_hour"] .'-'. $hour["end_hour"]." ";
                    }

                }

            }


            $message2 = $order->user->name
               ." ".
               "عزیز. رزرو شما در"
               ." ".
               $roomG->reservable_center->name
                   ."،"
               ." ".
               $message
               ." ".
               $roomG->reservable_center->address
                   ." "
               ."با موفقیت ثبت شد"
               ." "."pelato.ir";
           ;

           $this->sendSMS($order->user->mobile, $message2);

        $message.=' '."pelato.ir";


           


        $this->sendSMS($roomG->reservable_center->user->mobile,$message1 . $message);




               if(Session::has('discount_id')){
			   $dis_id=Session::get('discount_id');
			   $discount=Discounts::where('id',$dis_id)->first();
			   $cap=$discount->capacity;
			   $cap=$cap-1;
               $discount->update(["capacity" => $cap]);
			   Session::forget('discount_id');

		   }




            //end hm add
            return view('order.payback.success', compact('timing_list_to_show', 'full_price', 'room_mapper', 'day_mapper'));

        } catch (\Exception $e) {
            flash_message("پرداخت انجام نشد.", "danger");
            foreach ($order->room_timing as $rt) {
                $rt->update(["selled" => 0]);
            }
            $order->room_timing()->detach();
            $order->delete();
            return view('order.payback.not_success');
        }
    }

    function sendSMS($number, $message)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
            $user = "axsazi";
            $pass = "66251674";
            $fromNum = "+98100020400";
            $toNum = $number;
            $messageContent = $message;
            $op = "send";
            //If you want to send in the future  ==> $time = '2016-07-30' //$time = '2016-07-30 12:50:50'

            $time = '';

            $client->SendSMS($fromNum, $toNum, $messageContent, $user, $pass, $time, $op);

        } catch (SoapFault $ex) {
            //echo $ex->faultstring;
        }

    }

    function archive()
    {
        $orders = OrderRoom::where('user_id', \Auth::user()->id)->where('paid', 1)->get();
        /*foreach ($orders as $c => $o)
        {
            $orders_detail = DB::table('room_timing_order_room')->where('order_room_id', $o->id)->where('reserved', 1)->get();
            foreach ($orders_detail as $cc => $oo)
            {
                $orders_detail2 = RoomTiming::where('id', $oo->room_timing_id)->where('selled', 1)->get();
                $room_detail = Room::where('id', $orders_detail2[$cc]->room_id)->get();
                $li_detail = "اتاق" . $room_detail[$cc]->name . " برای روز " . day_inText($orders_detail2[$cc]->day) . " ساعت ". $orders_detail2[$cc]->start_hour . "به قیمت " . $orders_detail2[$cc]->price . "رزرو شد.";
            }
            $orders[$c]->new_dimension = $orders_detail;
        }*/
        return view('order.archive', compact('orders'));
    }


	function archivefromuser($id)
    {

        var_dump($id);
        $user=User::where('id',$id)->get();
       // var_dump($user_id);
        $orders = OrderRoom::where('user_id', $id)->where('paid', 1)->get();
        $count = OrderRoom::where('user_id', $id)->where('paid', 1)->count();


        return view('order.archive', compact('orders'));
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
        return view('order.archive_detail', compact('timing_list_to_show', 'full_price', 'room_mapper', 'day_mapper', 'rs'));
    }

    function myarchive_detail(CenterorderRoom $order)
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
        return view('order.archive_detail', compact('timing_list_to_show', 'full_price', 'room_mapper', 'day_mapper', 'rs'));
    }

    function all()
    {
            if (auth()->user()->can('view', OrderRoom::class))
        {
			
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
            return view('order.archive_all', compact('orders', 'statusPayments'));
        }
        else
        {
            return redirect()->route('homepage');
        }
    }

    public function updateStatusPayment(OrderRoom $order, Request $request)
    {
		  $this->validate($request, [
            'status_payment_id' => 'required|exists:status_payments,id'
        ]);

        if($request->status_payment_id == '4')
        {
            $orders =  OrderRoom::findOrFail($order->id)->room_timing()->get();
            foreach($orders as $orderDone)
            {
                $orderDone->update([
                    "selled" => false
                ]);
            }
			$order->delete();

			if (!$request->ajax())
			return redirect()->back();
        }

        $order->update([
            'status_payment_id' => $request->status_payment_id
        ]);
    }


    public function customReserve(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|string',
            'mobile' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'status_payment' => 'required|exists:status_payments,id'
        ]);
        $user = User::whereMobile($request->mobile)->first();
        if (!$user) {
            $password = $new_password = rand(11, 99) .rand(11, 99) . rand(11, 99);
           // $message = 'کاربر عزیز سایت پلاتو رمز عبور شما: ' . $password;
		   $message=' کاربر عزیز سایت پلاتو،نام کاربری شما '.
		   $request->mobile
		   .'  و رمز عبور شما:'
		    . $password
			.'می باشد';
            $this->sendSMS($request->mobile, $message);
            $user = User::create([
				 'username' => $request->mobile,
                'mobile' => $request->mobile,
                'name' => $request->user_name,
				'type'=>1,
				'confirm'=>1,
                'password' => bcrypt($password)
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
        $order_room = new OrderRoom(
            [
                "user_id" => $user->id,
                "whole_price" => $whole_price,
                "paid" => 1,
                "mellat_pay_ref_id" => "",
                "has_not_reserved_hour" => $has_not_reserved_hour,
                "status_payment_id" => $request->status_payment
            ]
        );
        $order_room->save();
        $inserted_id = $order_room->id;
        $order_room->room_timing()->attach($room_timing);

        //My Codes
        $order = OrderRoom::whereId($inserted_id)->first();
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
                $timing_list_to_show[$active_room][$active_day][] = ["week_id" => $tl->week_id,"day" => $tl->day,"start_hour" => $tl->start_hour, "end_hour" => ($tl->start_hour + 1)];
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
                    $mytime=$timing_list_to_show[$room_key][$day_key];
                    $date=Week::find($mytime[0]["week_id"]);
                    $t=date('Y-m-d',strtotime($date->start_date. ' + '.$mytime[0]["day"].' days'));
                    $jdf=new \App\Libraries\Jdf();
                    $array =  explode('-', $t);
                   // dd($array);
                   $finaldate=$jdf->gregorian_to_jalali($array[0],$array[1],$array[2],'-');

                   $message.=" مورخ".$finaldate. "\n";
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

        $this->sendSMS($order->user->mobile, $message2);

        $message.=' '."pelato.ir";

        $this->sendSMS($roomG->reservable_center->user->mobile,$message1 . $message);

        return redirect()->back()->with(['message' => 'عملیات با موفقیت انجام شد']);

    }


    public function centercustomReserve(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|string',
            'mobile' => 'required|numeric',
            'price' => 'required|numeric|min:0',
            'status_payment' => 'required|exists:status_payments,id'
        ]);
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
        $order_room->save();
        $inserted_id = $order_room->id;
        // dd($room_timing);
        $order_room->room_timing()->attach($room_timing);

        //My Codes
        $order = CenterorderRoom::whereId($inserted_id)->first();
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

        return redirect()->back()->with(['message' => 'عملیات با موفقیت انجام شد']);

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
        return view('order.specific_archive_all', compact('orders', 'statusPayments','center'));


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
        return view('order.myspecific_archive_all', compact('orders', 'statusPayments','center'));


    }


}
