<?php

namespace App\Http\Controllers;

use App\ConfirmationCode;
use App\Discounts;
use App\Http\Requests\CenterFormRequest;
use App\SMS;
use Illuminate\Http\Request;
use App\ReservableCenter;
use App\User;
use App\CenterType;
use App\CenterAttribute;
use App\Week;
use App\Room;
use App\Image;
use App\Comment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservableCenterController extends Controller
{
    // use SMS;

    function index(ReservableCenter $reservable_center , Request $request){
      $reservable_center_whole = ReservableCenter::all();
      $user = User::where("type","=",2)->get();
      $center_type = CenterType::all();
      $center_attribute = CenterAttribute::whereType('center')->get();

      if ($request->is('*/edit')) {
          $edit = true;
      }else{
        $edit = false;
      }

      return view('reservable_center.index',compact('reservable_center','reservable_center_whole','edit','user','center_type','center_attribute'));
    }
    function add(Request $request){
      try{
        $reservable_center = new ReservableCenter(
          [
            "user_id" => $request->user_id,
            "center_type_id" => $request->center_type_id,
            "name" => $request->name,
            "address" => $request->address,
            "description" => $request->description,
            "google_map_lat" => $request->google_map_lat,
            "google_map_lon" => $request->google_map_lon,
            "verified" => 1,
            "active" => 1,
          ]
        );
        $reservable_center->save();
        $reservable_center->center_attribute()->attach($request->center_attributes);
        flash_message("مرکز با موفقیت افزوده شد.","success");


        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => '' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
          // send back to the page with the input data and errors
          return redirect('reservable_center')->withInput()->withErrors($validator);
        }else{
          // checking file is valid.
          if (Input::hasFile('image')) {
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

            Image::create([
              'owner_id' => $reservable_center->id,
              'owner_type' => 1,
              "picture" => $fileName
            ]);
            flash_message("عکس با موفقیت آپلود شد",'success');
          }else {
            // sending back with error message.
            flash_message("آپلود عکس با مششکل مواجه شد",'danger');
          }
        }

      }catch(Exception $e){
        flash_message("افزودن مرکز با مشکل مواجه شد.","danger");
      }
      return back();
    }
    function edit(ReservableCenter $reservable_center , Request $request){
      try{
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => '' , 'mimes' => 'png'); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
          // send back to the page with the input data and errors
          return redirect('reservable_center')->withInput()->withErrors($validator);
        }else{
          // checking file is valid.
          if (Input::hasFile('image')) {
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
          }else {
            // sending back with error message.
            flash_message("آپلود عکس با مششکل مواجه شد",'danger');
          }
        }

        $reservable_center->update(
          [
            "user_id" => $request->user_id,
            "center_type_id" => $request->center_type_id,
            "name" => $request->name,
            "address" => $request->address,
            "description" => $request->description,
            "google_map_lat" => $request->google_map_lat,
            "google_map_lon" => $request->google_map_lon,
          ]
        );

        $reservable_center->center_attribute()->sync($request->center_attributes);
        flash_message("مرکز با موفقیت ویرایش شد.","success");
      }catch(Exception $e){
        flash_message("ویرایش مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/reservable_center');
    }
    function delete(ReservableCenter $reservable_center){
      try{
        if($reservable_center->room->count() > 0){
          flash_message("این مرکز شامل چندین اتاق می شود و امکان حذف آن تا زمان حذف اتاقها وجود ندارد.","danger");
        }else{
          $picture = $reservable_center->image->picture;
          $reservable_center->center_attribute()->detach();
          $reservable_center->delete();
          \File::delete('images/'.$picture);
          \File::delete('images_thumb/'.$picture);
          flash_message("مرکز با موفقیت حذف شد.","success");
        }
      }catch(Exception $e){
        flash_message("حذف مرکز با مشکل مواجه شد.","danger");
      }
      return redirect('/reservable_center');

    }
    function verify(ReservableCenter $reservable_center , Request $request){
      if($reservable_center->verified){
        $verified = 0;
      }else{
        $verified = 1;
      }
      $state = $reservable_center->update(["verified" => $verified]);
      if($state){
        if($verified){
          flash_message("مرکز با موفقیت تایید شد.","success");
        }else{
          flash_message("مرکز با موفقیت رد تایید شد.","success");
        }
      }else{
        if($verified){
          flash_message("تایید مرکز با مشکل مواجه شد.","danger");
        }else{
          flash_message("رد تایید مرکز با مشکل مواجه شد.","danger");
        }
      }
      return redirect('/reservable_center');
    }
    function active(ReservableCenter $reservable_center , Request $request){
      if($reservable_center->active){
        $active = 0;
      }else{
        $active = 1;
      }
      $state = $reservable_center->update(["active" => $active]);
      if($state){
        if($active){
          flash_message("مرکز با موفقیت فعال شد.","success");
        }else{
          flash_message("مرکز با موفقیت غیر فعال شد.","success");
        }
      }else{
        if($active){
          flash_message("فعالسازی مرکز با مشکل مواجه شد.","danger");
        }else{
          flash_message("غیر فعالسازی مرکز با مشکل مواجه شد.","danger");
        }
      }
      return redirect('/reservable_center');
    }
    function public_listing(Request $request){
      $reservable_center = ReservableCenter::where("verified","1")->get();
      $center_type = CenterType::all();

      $center_attributes=\App\CenterAttribute::where('type','center')->get();
        $today_date=\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime( Carbon::now()));


        $current_date = date("Y-m-d");
        $current_week = Week::where([
            ["start_date", "<=", $current_date],
            ["end_date", ">=", $current_date],
        ])->first();

        $current_week_id = $current_week->id;
        $datetime = date("Y-m-d");
        $day_num = date('w', strtotime($datetime));
        $day_num=$day_num+1;
        if($day_num>=7){
            $day_num=$day_num-7;
        }

        $reservable_center_not_selled = ReservableCenter::whereHas('room', function ($query) use($current_week_id,$day_num)  {
            $query->whereHas('room_timing', function ($query)  use($current_week_id,$day_num) {

                $query->where('week_id','>=',$current_week_id)->where('day','>=',$day_num)->where('selled','0');
            });
        })->pluck('id')->toArray();




        return view('reservable_center.public_listing',compact('reservable_center_not_selled','reservable_center','center_type','center_attributes','today_date'));
    }
    function public_specific_center(ReservableCenter $reservable_center , Request $request, $week = null){
        if($week)
        {
            $set_week = Week::where("id",$week)->first();

            $current_week = $set_week;

            $current_date = date("Y-m-d");
            $current_weekM6 = Week::where([
                ["start_date","<=",$current_date],
                ["end_date",">=",$current_date],
            ])->first();
        }
        else
        {
            $current_date = date("Y-m-d");
            $current_weekM6 =  $current_week = Week::where([
                ["start_date","<=",$current_date],
                ["end_date",">=",$current_date],
            ])->first();
        }



        //If given week id is incorrect , current week will be setted
        if(!isset($set_week->id)){
            $set_week = $current_week;
        }


      //Determine lingual phrase for set week
      $dif_week = $set_week->id - $current_weekM6->id;
      switch($dif_week){
        case 0:
        $lingual_set_week = "هفته جاری";
        break;

        case 1:
        $lingual_set_week = "هفته بعد";
        break;

        case -1:
        $lingual_set_week = "هفته قبل";
        $edit_enabled = 0;
        break;

        default:
            if($dif_week>1){
              $lingual_set_week = $dif_week." هفته بعد";
            }else{
              $edit_enabled = 0;
              $lingual_set_week = abs($dif_week)." هفته قبل";
            }
        break;
      }

      $center_room_list = Room::where("reservable_center_id",$reservable_center->id)->select("id")->get();
      $room_timing = \DB::table('room_timings')
      ->select('room_timings.*',\DB::raw("'n/a' AS operation_status"))
      ->whereIn("room_id", $center_room_list)
      ->where("week_id", $current_week->id)
      ->get();


      $day_mapper = ["شنبه","یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنج شنبه","جمعه"];
      $Comment=Comment::where(['center_id'=>$reservable_center->id,'state'=>1,'parent_id'=>0])->orderBy('id','DESC')->paginate(10);
        $center_discounts=Discounts::where(['center_id'=>$reservable_center->id],['priority'=>0,],['capacity','>',0])->get();
        $pelato_disconts=Discounts::where('center_id',0)->where('capacity','>',0)->where('priority',1)->get();
        $pelato_public=Discounts::where('center_id',0)->where('capacity','>',0)->where('priority',0)->get();

        //	$center_discounts=array_merge($center_discounts,$pelato_public);
        Session::forget('discount_center_id');
        Session::put('discount_center_id',$reservable_center->id);
        return view('reservable_center.public_specific_center', compact('center_discounts','pelato_disconts','pelato_public','reservable_center','day_mapper','lingual_set_week','current_week','set_week','room_timing', 'current_weekM6','Comment'));
    }

    function redirect_name($slug) {
        $object = ReservableCenter::where("slug", $slug)->first();
        return redirect('centers/'.$object->id);
    }

    public function isBest(ReservableCenter $reservable_center)
    {
        $reservable_center->is_best==false ? $reservable_center->update(['is_best' => true]) : $reservable_center->update(['is_best' => false]);
        return redirect()->back()->with(flash_message("مرکز مورد نظر با موفقیت بروز رسانی شد.","success"));
    }


    public function createCenterForm()
    {
        $center_types = CenterType::get(['id', 'name']);
        $center_attributes = CenterAttribute::whereType('center')->get();
        $room_attributes = CenterAttribute::whereType('room')->get();
        return view('reservable_center.registration', compact('center_types', 'center_attributes', 'room_attributes'));
    }

   	public function storeCenterForm(CenterFormRequest $request)
    {
        $user = $this->storeUser($request->only(['username', 'name', 'email', 'mobile', 'password', 'user_images']));
        $this->storeCenter($request->only(['center_type_id', 'center_type', 'center_name', 'center_address', 'center_phone', 'center_chairs', 'ownership', 'center_time_activity', 'center_description', 'center_attribute', 'google_map_lat', 'google_map_lon', 'center_image']), $user);
        return redirect()->back()->with(flash_message("ثبت نام شما با موفقیت انجام شد، بعد از تایید با شما تماس گرفته خواهد شد.","success"));
    }

    public function storeUser($data)
    {
        $user = User::create([
            "username" => $data["username"],
            "password" => Hash::make($data["password"]),
            "name" => $data["name"],
            "email" => $data["email"],
            "mobile" => $data["mobile"],
            "confirm" => false,
            "type" => 2,
        ]);
        if ($data['user_images'])
            $this->createUserImages($data['user_images'], $user);
        return $user;
    }

    public function storeCenter($data, User $user)
    {
        $center = ReservableCenter::create([
            "user_id" => $user->id,
            "center_type_id" => $data['center_type'],
            "name" => $data['center_name'],
            "address" => $data['center_address'],
            "phone" => $data['center_phone'],
            "description" => $data['center_description'],
            "google_map_lat" => $data['google_map_lat'],
            "google_map_lon" => $data['google_map_lon'],
            "meta" => [
                'chair_count' => $data['center_chairs'],
                'ownership' => $data['ownership'],
                'time_activity' => $data['center_time_activity']
            ]
        ]);
        $center->center_attribute()->attach($data['center_attribute']);
        if ($data['center_image'])
            $this->createCenterImage($data['center_image'], $center);
        return $center;
    }
    
    public function createUserImages($userImages, User $user)
    {
        $destinationPath = 'images'; // upload path
        $destinationThumbnailPath = 'images_thumb'; // upload path
        foreach ($userImages as $userImage)
        {
            $extension = $userImage->getClientOriginalExtension(); // getting image extension
            $fileName = md5(time()) . '.' . $extension; // renameing image
            $userImage->move($destinationPath, $fileName); // uploading file to given path
            \FolkloreImage::make($destinationPath . '/' . $fileName, array(
                'width' => 800,
            ))->save($destinationPath . '/' . $fileName);
            \FolkloreImage::make($destinationPath . '/' . $fileName, array(
                'width' => 300,
                'height' => 300,
                'crop' => true,
            ))->save($destinationThumbnailPath . '/' . $fileName);
            // sending back with message
            Image::create([
                'owner_id' => $user->id,
                'owner_type' => 3,
                "picture" => $fileName
            ]);
        }
    }

    public function createCenterImage($centerImage, ReservableCenter $reservableCenter)
    {
        $destinationPath = 'images'; // upload path
        $destinationThumbnailPath = 'images_thumb'; // upload path
        $extension = $centerImage->getClientOriginalExtension(); // getting image extension
        $fileName = md5(time()).'.'.$extension; // renameing image
        $centerImage->move($destinationPath, $fileName); // uploading file to given path
        \FolkloreImage::make($destinationPath.'/'.$fileName,array(
            'width' => 800,
        ))->save($destinationPath.'/'.$fileName);
        \FolkloreImage::make($destinationPath.'/'.$fileName,array(
            'width' => 300,
            'height' => 300,
            'crop' => true,
        ))->save($destinationThumbnailPath.'/'.$fileName);
        // sending back with message
        Image::create([
            'owner_id' => $reservableCenter->id,
            'owner_type' => 1,
            "picture" => $fileName
        ]);
    }
}
