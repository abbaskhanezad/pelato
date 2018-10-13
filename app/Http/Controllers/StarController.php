<?php

namespace App\Http\Controllers;
use App\Starrating;
use App\OrderRoom;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StarController extends Controller
{
	
	public function addstar(Request $request)
    {
        if (Auth::check()) {
            //var_dump(Auth::user()->id);
            //$exist = Starrating::where('center_id', $request->center_id)->where('ip', $_SERVER["REMOTE_ADDR"])->count();
            // var_dump($exist);
            //start-code-for-find-center---------
            $orders = OrderRoom::where('user_id', \Auth::user()->id)->where('paid', 1)->count();
            //  foreach($orders as $c => $o) {
            // var_dump($o->id);
            // $order=OrderRoom::where('id',$o->id)->get();
            //var_dump($order);
            $exist=Starrating::where('center_id',$request->center_id)->where('ip',$_SERVER["REMOTE_ADDR"])->count();
            // var_dump($exist);

            if($exist>0){
               // session()->put('msg','شما قبلا برای این مرکز امتیاز داده اید');
                //session()->put('type','danger');
                 flash_message("شما قبلا برای این مرکز امتیاز داده اید.","danger");
                //  var_dump(session('type'));
                return redirect()->back();
            }

            else {
                $Starrating = new Starrating();
                $Starrating->center_id = $request->center_id;
                // $Starrating->star = $request->whatever1;
                $Starrating->nezafat = $request->nezafat;
                $Starrating->tajhizat = $request->tajhizat;
                $Starrating->khadamat = $request->khadamat;
                $Starrating->ip = $_SERVER["REMOTE_ADDR"];
                $Starrating->save();
                //session()->put('msg', 'امتیاز شما با موفقیت ثبت شد');
                //session()->put('type', 'success');
                flash_message("امتیاز با موفقیت ثبت شد.","success");
                //dd(session('type'));
                return redirect()->back();
    }
		}
        else{
            var_dump('not auth');
        }



	}
}
