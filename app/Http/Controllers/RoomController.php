<?php

namespace App\Http\Controllers;

use App\CenterAttribute;
use Illuminate\Http\Request;
use App\Room;
use App\ReservableCenter;
use Input;
use App\Image;

class RoomController extends Controller
{
    function index(Room $room , ReservableCenter $reservable_center_filter, Request $request){
      if ($request->is("room/center/*")) {
        $room_whole = Room::where("reservable_center_id",$reservable_center_filter->id)->get();
      }else{
        $room_whole = Room::all();
      }
      $reservable_center = ReservableCenter::all();
      $room_attributes = CenterAttribute::whereType('room')->get();
      if ($request->is('*/edit')) {
          $edit = true;
      }else{
        $room = new Room;
        $room->size = 10;
        $room->price_per_hour = 10;
        $edit = false;
      }


      return view('room.index',compact('room','room_whole','edit','reservable_center','reservable_center_filter', 'room_attributes'));
    }

    function add(Request $request){
      $state = Room::create($request->all());
      $state->tags()->attach($request->room_attributes);
      if($state){
        flash_message("اتاق با موفقیت افزوده شد.","success");
      }else{
        flash_message("افزودن اتاق با مشکل مواجه شد.","danger");
      }
      return back();
    }

    function edit(Room $room , Request $request){
      $state = $room->update($request->all());
	  if (!empty($request->room_attributes))
		{
			$room->tags()->sync($request->room_attributes);
		}
          else
              {
               $room->tags()->detach();
              }
      if($state){
        flash_message("اتاق با موفقیت ویرایش شد.","success");
      }else{
        flash_message("ویرایش اتاق با مشکل مواجه شد.","danger");
      }
      return redirect('/room');

    }

    function delete(Room $room){
      if($room->room_timing->count() > 0){
        flash_message("این اتاق شامل زمانبندی می باشد و امکان حذف آن وجود ندارد.","danger");
      }else{
        $state = $room->delete();
        if($state){
          flash_message("اتاق با موفقیت حذف شد.","success");
        }else{
          flash_message("حذف اتاق با مشکل مواجه شد.","danger");
        }
      }
      return redirect('/room');
    }

    public function uploadImage(Request $request,$room_id)
    {

        if($room_id && is_numeric($room_id)){
            $room = Room::find($room_id);
            if($room && $room instanceof Room){
                $image_name =bin2hex(random_bytes(16));
                $image_extension = $request->file('file')->getClientOriginalExtension();
                $fullNameImage = $image_name.'.'.$image_extension;

                $uploadedFile = $request->file('file')->storeAs('/images',$fullNameImage);


                $room_data =[
                    'owner_type'=> Room::ROOM,
                    'owner_id' => $room_id,
                    'picture' => $fullNameImage
                ];

                Image::create($room_data);
            }
        }

    }

    public function editroom(Room $room)
    {
        $images = Image::all()->where('owner_type','=',Room::ROOM)
            ->where('owner_id','=',$room->id);

        $tags = $room->tags()->pluck('name','id')->toArray();
        $allAttributes = CenterAttribute::all()->pluck('name','id')->toArray();
        $allAttributes = CenterAttribute::where('type','room')->pluck('name','id')->toArray();

        return view('room.edit', compact('room','allAttributes','tags','images'));
    }

    public function deleteImageRoom(Request $request)
    {

        $room_id = $request->input('room_id');
        $image_id = $request->input('image_id');

        if($room_id && is_numeric($room_id)) {
            $room = Room::find($room_id);
            if($room && $room instanceof Room){
                if($image_id && is_numeric($image_id)){
                    $image = Image::find($image_id);
                    if($image && $image instanceof Image){
                        $imagePath = '/images/'.$image->picture;
                        @unlink(public_path($imagePath));
                        $deleteResult = $image->delete();
                        $image->deleteResult = $deleteResult;
                        return $image;
                    }
                }
            }
        }
    }

    function update(Room $room, Request $request)
    {
        $state = $room->update($request->all());
        if (!empty($request->room_attributes)) {
            $room->tags()->sync($request->room_attributes);
        } else {
            $room->tags()->detach();
        }
        if ($state) {
            flash_message("اتاق با موفقیت ویرایش شد.", "success");
        } else {
            flash_message("ویرایش اتاق با مشکل مواجه شد.", "danger");
        }
        return redirect('/room');

    }


}
