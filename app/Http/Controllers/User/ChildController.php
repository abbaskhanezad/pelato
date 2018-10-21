<?php

namespace App\Http\Controllers\User;

use App\PointItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function index()
    {

        $pointCount_reserve = PointItem::where('point_item_name','reserve')->first()->point_item_value;

        $user = Auth::user();
        $child = $user->child()->with('order_room')->get();
        return view('users.child.index',compact('child','pointCount_reserve'));
    }
}
