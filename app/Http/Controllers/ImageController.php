<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
//use Illuminate\Contracts\validation\Validator;
//use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Contracts\Filesystem;
//use Illuminate\Filesystem;
use App\Image;
use App\ReservableCenter;
use App\Room;


class ImageController extends Controller
{
  function index(Request $request){
    if(Auth::user()->type == 3){
      $image = Image::all();
    }else{
      //$image = Image::whereIn("owner_type");
    }

    return view('image.index',compact('image'));
  }

  function reservable_center_poster(Request $request){
    $file = array('image' => Input::file('image'));
    // setting up rules
    $rules = array('image' => 'required' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) {
      // send back to the page with the input data and errors
      return redirect('dashboard')->withInput()->withErrors($validator);
    }else{
      // checking file is valid.
      if (Input::file('image')->isValid()) {
        $destinationPath = 'images'; // upload path
        $destinationThumbnailPath = 'images_thumb'; // upload path
        $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
        $fileName = md5(time()).'.'.$extension; // renameing image
        Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        \FolkloreImage::make($destinationPath.'/'.$fileName,array(
          'width' => 800,
        ))->save($destinationPath.'/'.$fileName);
        \FolkloreImage::make($destinationPath.'/'.$fileName,array(
          'width' => 300,
          'height' => 300,
          'crop' => true,
        ))->save($destinationThumbnailPath.'/'.$fileName);
        // sending back with message

        $reservable_center = ReservableCenter::where("user_id","=",Auth::user()->id)->first();
        if(isset($reservable_center->image->picture)){
          \File::delete('images/'.$reservable_center->image->picture);
          \File::delete('images_thumb/'.$reservable_center->image->picture);
          $reservable_center->image->update(['picture' => $fileName]);
        }else{
          Image::create([
            'owner_id' => $reservable_center->id,
            'owner_type' => 1,
            "picture" => $fileName
          ]);
        }
        flash_message("عکس با موفقیت آپلود شد",'success');
        return redirect('dashboard');
      }else {
        // sending back with error message.
        flash_message("آپلود عکس با مششکل مواجه شد",'danger');
        return redirect('dashboard');
      }
    }
  }

  function room_list(Room $room , Request $request){
    return view('image.index',compact('room'));

  }

  function room_add(Room $room,Request $request){
    $file = array('image' => Input::file('image'));
    // setting up rules
    $rules = array('image' => 'required' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    if (!$validator->fails()) {
      // checking file is valid.
      if (Input::file('image')->isValid()) {
        $destinationPath = 'images'; // upload path
        $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
        $fileName = md5(time()).'.'.$extension; // renameing image
        Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        \FolkloreImage::make($destinationPath.'/'.$fileName,array(
          'width' => 800,
        ))->save($destinationPath.'/'.$fileName);
        // sending back with message

        Image::create([
          'owner_id' => $room->id,
          'owner_type' => 2,
          "picture" => $fileName
        ]);
        flash_message("عکس با موفقیت آپلود شد",'success');
      }else {
        // sending back with error message.
        flash_message("آپلود عکس با مششکل مواجه شد",'danger');
      }
    }
    return view('image.index',compact('room'));
  }


  function room_delete(Room $room, Image $image){
    \File::delete('images/'.$image->picture);
    $state = $image->delete();
    if($state){
      flash_message("عکس با موفقیت حذف شد.","success");
    }else{
      flash_message("حذف عکس با مشکل مواجه شد.","danger");
    }
    return redirect('/image/room/'.$room->id.'/list');

  }
}
