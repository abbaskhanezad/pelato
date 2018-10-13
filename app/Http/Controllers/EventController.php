<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventScence;


class EventController extends Controller
{
  function test(){
    //$post = (new Event)->fill([""])->user()->associate(Auth::user())->save();
    $event = Event::create([
      "user_id" => 1,
      "name" =>"mreza",
      "address" =>"haft tir",
      "phone" =>"021-77645101",
      "mobile" =>"09129342358",
      "price" =>"34",
      "capacity" => 5
    ]);

    $state = (new EventScence)->fill([
      "start_datetime" => date("Y-m-d H:i:s"),
      "duration" => 5
      ])->event()->associate($event)->save();

    $state = (new EventScence)->fill([
      "start_datetime" => date("Y-m-d H:i:s"),
      "duration" => 6
      ])->event()->associate($event)->save();



  }
  function index(Event $event , Request $request){
    $event_whole = Event::all();

    if ($request->is('*/edit')) {
        $edit = true;
    }else{
      $edit = false;
    }


    return view('event.index',compact('event','event_whole','edit'));
  }

  function add(Request $request){
    $state = Event::create($request->all());
    if($state){
      flash_message("رویداد با موفقیت افزوده شد.","success");
    }else{
      flash_message("افزودن رویداد با مشکل مواجه شد.","danger");
    }
    return back();
  }

  function edit(Event $event , Request $request){
    $state = $event->update(["name" => $request->name]);
    if($state){
      flash_message("رویداد با موفقیت ویرایش شد.","success");
    }else{
      flash_message("ویرایش رویداد با مشکل مواجه شد.","danger");
    }
    return redirect('/event');

  }

  function delete(Event $event){
    $state = $event->delete();
    if($state){
      flash_message("رویداد با موفقیت حذف شد.","success");
    }else{
      flash_message("حذف رویداد با مشکل مواجه شد.","danger");
    }
    return redirect('/event');

  }

}
