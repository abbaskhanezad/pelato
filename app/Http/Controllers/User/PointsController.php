<?php

namespace App\Http\Controllers\User;

use App\ChangeToWalletLog;
use App\Http\Requests\changepassRequest;
use App\Http\Requests\ChangePointRequest;
use App\Point;
use App\PointItem;
use App\Setting;
use App\Wallet;
use App\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PointsController extends Controller
{
    public function index()
    {

        $allPointItems = PointItem::all()->pluck('point_item_title','point_item_id')->toArray();

        $user = Auth::user();


        $point_count_changed = ChangeToWalletLog::where('log_user_id',$user->id)->sum('log_point_count_changed');


        $points = $user->points->groupBy('point_item_id');

        $sumPointsArray =[];
        $totalPoints =0;
        foreach ($points as $point_item_id=>$point){
            $pointItemValue = PointItem::find($point_item_id)->point_item_value;
           $sumCountPointItem = ($point->sum('point_count')) * $pointItemValue;
            $sumPointsArray[$point_item_id] = $sumCountPointItem;
            $totalPoints += $sumCountPointItem;
        }
        $totalPoints -=$point_count_changed;




        return view('users.points.index',compact('sumPointsArray','allPointItems','totalPoints'));
    }


    public function calculator(Request $request)
    {
        $priceOfPoint = Setting::where('setting_key','priceOfPoint')->pluck('setting_value')->first();
        $result = $priceOfPoint * $request->input('valInput');
        return $result;
    }


    public function changeToWallet(ChangePointRequest $request)
    {
        $countPoint = $request->input('countPoint');

        $user = Auth::user();

        $point_count_changed = ChangeToWalletLog::where('log_user_id',$user->id)->sum('log_point_count_changed');


        $points = $user->points->groupBy('point_item_id');

        $sumPointsArray =[];
        $totalPoints =0;
        foreach ($points as $point_item_id=>$point){
            $pointItemValue = PointItem::find($point_item_id)->point_item_value;
            $sumCountPointItem = ($point->sum('point_count')) * $pointItemValue;
            $sumPointsArray[$point_item_id] = $sumCountPointItem;
            $totalPoints += $sumCountPointItem;
        }

        $totalPoints -=$point_count_changed;



        if($countPoint > ($totalPoints)){
            return redirect()->back()->with('statusError','تعداد امتیازهای شما کمتر از مقدار وارد شده می باشد');
        }

        $changedPointToWallet = ChangeToWalletLog::create([
            'log_user_id' => Auth::user()->id,
            'log_point_count_changed'=>$countPoint
        ]);


        $priceOfPoint = Setting::where('setting_key','priceOfPoint')->pluck('setting_value')->first();
        $price = $priceOfPoint * $countPoint;


        if($changedPointToWallet && $changedPointToWallet instanceof ChangeToWalletLog){

            WalletLog::create([
                'user_id' =>$user->id,
                'price' =>$price,
                'method_create' => WalletLog::POINT,
                'wallet_operation'=>WalletLog::INCREMENT,
            ]);


            return redirect()->back()->with('statusSuccess','امتیاز با موفقیت به کیف پول انتقال یافت');
        }






    }
}
