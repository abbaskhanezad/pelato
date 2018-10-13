<?php

namespace App\Http\Controllers\User;

use App\ReservableCenter;
use App\Starrating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $all_reservable_center = ReservableCenter::where("verified", "1")->get();

        $best_reservable_center_id = Starrating::orderBy('star', 'desc')->take(10)->pluck('center_id')->toArray();


        $best_reservable_center = ReservableCenter::find($best_reservable_center_id);

        foreach ($best_reservable_center as $rs_item) {
            $rs_item->avgNezafat = Starrating::avgNezafat($rs_item->id);
            $rs_item->avgTajhizat = Starrating::avgTajhizat($rs_item->id);
            $rs_item->avgKhadamat = Starrating::avgKhadamat($rs_item->id);
            $rs_item->avgAll = Starrating::avgAll($rs_item->id);
            $rs_item->countStarRate = Starrating::countStarRate($rs_item->id);
        }

        $best_reservable_center = $best_reservable_center->sortBy('countStarRate')->reverse()->all();

        return view('users.index', compact('all_reservable_center', 'best_reservable_center', 'maxRate'));
    }
}
