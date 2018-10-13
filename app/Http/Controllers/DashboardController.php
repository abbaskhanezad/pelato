<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservableCenter;
use App\Room;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    function index(Request $request){
      $reservable_center = ReservableCenter::where("user_id",Auth::user()->id)->first();
      
      return view('dashboard.center_index',compact('reservable_center'));
    }
}
