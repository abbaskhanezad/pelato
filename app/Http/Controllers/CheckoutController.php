<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkout;
 use App\ReservableCenter;
use App\Week;
use App\User;
use jDateTime;
use jDate;
use SoapClient;
class CheckoutController extends Controller
{
   

    public function tasvie($centerid,$weekid,$amount)
    {
      if(auth()->user()->type==3){
          $checkout = new Checkout();
          $checkout->week_id=$weekid;
          $checkout->center_id=$centerid;
          $checkout->checkouted=1;
          $checkout->save();

          flash_message("تسویه حساب با موفقیت ثبت شد.", "success");
$center=ReservableCenter::find($centerid);
          $user_id=$center->user_id;
          $user=User::find($user_id);
          $week=Week::find($weekid);
          $message2 =
              "مدیر محترم مرکز"
              ." ".
            $center->name
              ."،"
              ."تسویه حساب شما"
              ."\n"
               ."از تاریخ "
             . jDateTime::strftime('Y-m-d', strtotime($week->start_date))
                  ."\n"
              ."تا تاریخ"
              . jDateTime::strftime('Y-m-d', strtotime($week->end_date))
                  ."\n"
                  ."به مبلغ"
              .$amount
              ."تومان"

              ." با موفقیت انجام شد"

              ." "."pelato.ir";


          $mobile=$user->mobile;
          $this->sendSMS($mobile, $message2);


          return redirect()->back();

      }
      else{
          flash_message("شما اجازه این کار را ندارید.", "danger");

          return redirect()->back();

      }
    }


    public function destroy($centerid,$weekid)
    {


        $tasviye=Checkout::where('week_id',$weekid)->where('center_id',$centerid)->first();
        if($tasviye){
            $tasviye->delete();
            flash_message("عملیات با موفقیت انجام شد","success");

             return redirect()->back();
        }
        flash_message('خطا در انجلم علیات','danger');

        return redirect()->back();

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


}




