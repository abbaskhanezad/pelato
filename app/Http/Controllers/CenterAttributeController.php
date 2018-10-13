<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CenterAttribute;

class CenterAttributeController extends Controller
{
    function index(CenterAttribute $center_attribute , Request $request){
      $center_attribute_whole = CenterAttribute::whereType('center')->paginate(10);

      if ($request->is('*/edit')) {
          $edit = true;
      }else{
        $edit = false;
      }


      return view('center_attribute.index',compact('center_attribute','center_attribute_whole','edit'));
    }

    function add(Request $request){
      $request->merge(['type' => 'center']);
      $state = CenterAttribute::create($request->all());
      if($state){
        flash_message("ویژگی مرکز با موفقیت افزوده شد.","success");
      }else{
        flash_message("افزودن ویژگی مرکز با مشکل مواجه شد.","danger");
      }
      return back();
    }

    function edit(CenterAttribute $center_attribute , Request $request){
      $state = $center_attribute->update(["name" => $request->name]);
      if($state){
        flash_message("ویژگی مرکز با موفقیت ویرایش شد.","success");
      }else{
        flash_message("ویرایش ویژگی مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/center_attribute');

    }

    function delete(CenterAttribute $center_attribute){
      $state = $center_attribute->delete();
      if($state){
        flash_message("ویژگی مرکز با موفقیت حذف شد.","success");
      }else{
        flash_message("حذف ویژگی مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/center_attribute');

    }
}
