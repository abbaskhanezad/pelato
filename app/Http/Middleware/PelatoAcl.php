<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PelatoAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $getAction = empty($request->route()->getAction())?"":$request->route()->getAction();
      $getController = isset($getAction["controller"])?$getAction["controller"]:"";

      if(!empty($getController)){
        $launch = $getController;
        $launch = str_replace('App\Http\Controllers\\','',$launch);
        $launch = str_replace('Controller','',$launch);
        $launch = explode("@",$launch);
        $controller = $launch[0];
        $action = $launch[1];

        //about Indexes =   controller => [action,user_access,center_access,admin_access]
        $access = [
          "CenterType" => [
            "index",false,false,true,false,
            "add",false,false,true,false,
            "edit",false,false,true,false,
            "delete",false,false,true,false,
          ],
          "CenterAttribute" => [
            "index",false,false,true,false,
            "add",false,false,true,false,
            "edit",false,false,true,false,
            "delete",false,false,true,false,
          ],
          "ReservableCenter" => [
            "index",false,false,true,true,
            "add",false,false,true,true,
            "edit",false,false,true,false,
            "delete",false,false,true,false,
          ],
          "Room" => [
            "index",false,false,true,false,
            "add",false,false,true,false,
            "edit",false,false,true,false,
            "delete",false,false,true,false,
          ],
          "User" => [
            "index",false,false,true,true,
            "add",false,false,true,true,
            "edit",false,false,true,false,
            "delete",false,false,true,false,
            "confirm",true,true,true,false,
          ],
          "Timing" => [
            "index",false,true,true,true,
            "set",false,true,true,true,
          ],
		    "Comment" => [
            "index",false,false,true,true,
            "change_state",false,false,true,true,
			"create",false,false,true,true,
			"delete",false,false,true,true,
          ],
		   "Discount" => [
            "get_discount_form",false,false,true,true,
            "discounts",false,false,true,true,
			"del_discounts",false,false,true,true,
          ],
        ];

          //controller and action exist check
          if(isset($access[$controller][0])&&$access[$controller][0]==$action){
            if( ! $access[$controller][Auth::user()->type] ){
              return redirect('/');
            }
          }
        }

        //$request->debug = $controller;

        $request->current_user = Auth::user();
        return $next($request);
    }
}
