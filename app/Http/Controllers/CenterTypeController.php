<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CenterType;

class CenterTypeController extends Controller
{
    function index(CenterType $center_type , Request $request){
      $center_type_whole = CenterType::all();

      if ($request->is('*/edit')) {
          $edit = true;
      }else{
        $edit = false;
      }


      return view('center_type.index',compact('center_type','center_type_whole','edit'));
    }

    function add(Request $request){
      $state = CenterType::create($request->all());
      if($state){
        flash_message("نوع مرکز با موفقیت افزوده شد.","success");
      }else{
        flash_message("افزودن نوع مرکز با مشکل مواجه شد.","danger");
      }
      return back();
    }

    function edit(CenterType $center_type , Request $request){
      $state = $center_type->update(["name" => $request->name]);
      if($state){
        flash_message("نوع مرکز با موفقیت ویرایش شد.","success");
      }else{
        flash_message("ویرایش نوع مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/center_type');

    }

    function delete(CenterType $center_type){
      $state = $center_type->delete();
      if($state){
        flash_message("نوع مرکز با موفقیت حذف شد.","success");
      }else{
        flash_message("حذف نوع مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/center_type');

    }
}
