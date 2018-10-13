<?php

namespace App\Http\Controllers;

use App\CenterAttribute;
use App\ReservableCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Session;
use SoapClient;
use App\Http\Requests\changepassRequest;

class UserController extends Controller
{
    function index(User $user , Request $request){
      echo $request->debug;
	    $keyword = $request->get('keyword');
		  $type = $request->get('type');
		if (!empty($keyword))
        {
            $edit = false;
            $user_whole = User::where('mobile', 'LIKE', "%$keyword%")->orWhere('name', 'LIKE', "%$keyword%")->orWhere('family', 'LIKE', "%$keyword%")->orWhere('username', 'LIKE', "%$keyword%")->paginate(20);
		
            return empty($user_whole->first()) ? redirect()->back()->with(['message' => 'کاربری با  اطلاعات وارد شده وجود ندارد'])
                : view('user.index',compact('user','user_whole','edit'));
        }
		if(!empty($type)){
			$edit = false;
			
			$user_whole=User::where('type',$type)->paginate(100);
			 return empty($user_whole->first()) ? redirect()->back()->with(['message' => 'مرکزداری وجود ندارد'])
                : view('user.index',compact('user','user_whole','edit'));
		}

      $user_whole = User::latest('id')->paginate(20);
      if ($request->is('*/edit')) {
          $edit = true;
      }else{
        $edit = false;
      }


      return view('user.index',compact('user','user_whole','edit'));
    }


    function add(Request $request){
      $this->validate($request, [
        'username' => 'required|unique:users',
		'mobile' => 'required|unique:users',
      ]);

      $state = User::create([
        "username" => $request->username,
        "password" => Hash::make($request->password),
        "name" => $request->name,
        "family" => $request->family,
        "email" => $request->email,
        "mobile" => $request->mobile,
        "type" => $request->type,
        "confirm" => 1,
      ]);
      if($state){
        flash_message("کاربر با موفقیت افزوده شد.","success");
      }else{
        flash_message("افزودن کاربر با مشکل مواجه شد.","danger");
      }
      return back();
    }
    function edit(User $user , Request $request){
      $state = $user->update([
        "username" => $request->username,
        "password" => Hash::make($request->password),
        "name" => $request->name,
        "family" => $request->family,
        "email" => $request->email,
        "mobile" => $request->mobile,
        "type" => $request->type,
      ]);
      if($state){
        flash_message("کاربر با موفقیت ویرایش شد.","success");
      }else{
        flash_message("ویرایش کاربر با مشکل مواجه شد.","danger");
      }
      return redirect('/user');
    }
    function delete(User $user){
      $state = $user->delete();
      if($state){
        flash_message("کاربر با موفقیت حذف شد.","success");
      }else{
        flash_message("حذف کاربر با مشکل مواجه شد.","danger");
      }
      return redirect('/user');

    }
    function confirm(Request $request , $mobile = null){

      if($request->getMethod() =="POST"){
        $confirm = User::where([
          ["mobile",$request->mobile],
          ["confirmation_code",$request->confirm_code],
        ]);
        if($confirm->count() == 1){
          $confirmed_id = $confirm->first()->id;
          $confirm->update([
            "confirm"=>1,
            "confirmation_code"=>""
          ]);
          \Auth::loginUsingId($confirmed_id);
          flash_message("کاربری شما تایید و به سیستم وارد شدید.","success");
        }else{
          flash_message("کد فعالسازی صحیح نمی باشد.","danger");
        }
      }


      $user = User::where("mobile",$mobile);
      if($user->count()==0){
        $mobile = "";

        //Redirect if user previously confirmed
      }elseif($user->first()->confirm==1){
        return redirect('/');
      }

      return view('user.confirm',compact('mobile'));
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
        return view('auth.passwords.reset');
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
            return redirect('/login');
        }




 }
    public function centerOwners()
    {
		$user_whole = User::with('reservable_center')->whereHas('reservable_center', function ($query) {
            $query->where([
                ['verified', false],
                ['active', false],
            ]);
        })->latest()->paginate(10);
        return view('user.center_owners.index', compact('user_whole'));
        return view('user.center_owners.index', compact('user_whole'));
    }

    public function userCenterShow(ReservableCenter $center)
    {
        $center_attributes = CenterAttribute::whereType('center')->get();
        return view('user.center_owners.show', compact('center', 'center_attributes'));
    }

	  public function updateConfirm(User $user)
    {
        $user->confirm == true ? $user->update(['confirm' => false]) : $user->update(['confirm' => true]);
        return redirect()->back();
    }

	public function userShow(User $user)
    {
        return view('user.center_owners.identity_info', compact('user'));
    }

}
