<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use SoapClient;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/confirm';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|min:6|max:255|unique:users',
            'email' => 'required|min:6|max:255|unique:users',
            'mobile' => 'required|min:11|max:11|unique:users',
            'password' => 'required|min:6',
        ],[
          'username.unique' => 'این نام کاربری قبلا ثبت نام شده است.',
          'username.required' => 'نام کاربری وارد نشده است.',
          'username.min' => 'نام کاربری بایستی حداقل 6 کاراکتر داشته باشد',
          'email.unique' => 'این پست الکترونیکی قبلا در سایت ثبت شده است',
          'email.min' => 'پست الکترونیکی بایستی حداقل 6 کاراکتر باشد',
          'email.required' => 'پست الکترونیکی وارد نشده است',
          'mobile.required' => 'تلفن همراه وارد نشده است.',
          'mobile.min' => 'تلفن همراه بایستی 11 کاراکتر باشد.',
          'mobile.unique' => 'این تلفن همراه قبلا در سایت ثبت شده است.',
          'password.required' => 'کلمه عبور وارد نشده است.',
          'password.min' => 'کلمه عبور بایستی حداقل 6 کاراکتر باشد.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
      $confirmation_code = rand(11111,99999);

      $register=User::create([
        "username" => $data["username"],
        "password" => Hash::make($data["password"]),
        "name" => $data["name"],
        "email" => $data["email"],
        "mobile" => $data["mobile"],
        "type" => 1,
        "confirm" => 0,
        "confirmation_code" => $confirmation_code,
      ]);

      if($register){
        $this->redirectTo = '/confirm/'.$data["mobile"];

        // turn off the WSDL cache
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
      	$client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
      	  $user = "axsazi";
          $pass = "66251674";
          $fromNum = "+98100020400";
          $toNum = array($data["mobile"]);
          $messageContent = $data["name"].' عزیز، کاربری شما در سایت پلاتو ثبت گردید. کد فعالسازی شما: '.$confirmation_code;
      	$op  = "send";
      	//If you want to send in the future  ==> $time = '2016-07-30' //$time = '2016-07-30 12:50:50'

      	$time = '';

        echo $client->SendSMS($fromNum,$toNum,$messageContent,$user,$pass,$time,$op);
        }
        catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
      }else{
        flash_message("عضویت با مشکل مواجه شد","danger");
      }
      return $register;
    }
}
