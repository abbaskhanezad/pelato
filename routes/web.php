<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//  Route::get('/artisan',function (){
//      \Illuminate\Support\Facades\Artisan::call('migrate');
//  });

use App\ReservableCenter;
use Carbon\Carbon;

Route::get('/', function () {
     $center_attributes=\App\CenterAttribute::where('type','center')->get();
    $today_date=\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime( Carbon::now()));
    $best_reserves = ReservableCenter::whereIsBest(true)->latest('updated_at')->get();
    $center_attributes=\App\CenterAttribute::where('type','center')->get();
    return view('home', compact('best_reserves','center_attributes','center_attributes','today_date'));
})->name('homepage');

Route::get('/home', function () {
  //  return view('home');
      $center_attributes=\App\CenterAttribute::where('type','center')->get();

   $best_reserves = ReservableCenter::whereIsBest(true)->latest('updated_at')->get();
    return view('home', compact('best_reserves'));
});

Route::get('adv_search', function () {

    $center_attributes=\App\CenterAttribute::where('type','center')->get();
		    $today_date=\Morilog\Jalali\jDateTime::strftime('Y-m-d', strtotime( Carbon::now()));
			   //var_dump($today_date);


    return view('advance_search.index', compact('center_attributes','today_date'));

})->name('adv_searchpage');

Route::get('/adv_search/result' , "WelcomeController@adv_searchResult")->name('index.adv_search');


Route::get('/search/result' , "WelcomeController@searchResult")->name('index.search');


Route::post('/addstar','StarController@addstar');

Auth::routes();
Route::post('reset/done', 'UserController@reset');
Route::get('reset/done', 'UserController@reset2');
Route::post('password/change', 'UserController@changepassword');


Route::get('centerowner/password/reset', 'CenterOwnerController@showresetform');
Route::post('centerowner/reset/done', 'CenterOwnerController@reset');
Route::get('centerowner/reset/done', 'CenterOwnerController@reset2');
Route::post('centerowner/password/change', 'UserController@changepassword');




Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//Route::get('/logout' , 'Auth\LoginController@logout');

Route::get('confirm', 'UserController@confirm');
Route::get('confirm/{mobile}', 'UserController@confirm');
Route::post('confirm/{mobile}', 'UserController@confirm');

//----------------Show Reservable Center List--------------------------------------------
Route::get('centers', 'ReservableCenterController@public_listing');
Route::get('centers/{reservable_center}', 'ReservableCenterController@public_specific_center')->name('center.show');
Route::get('center/{slug}', 'ReservableCenterController@redirect_name');
Route::get('centers/{reservable_center}/week/{week}', 'ReservableCenterController@public_specific_center');

//Route::get('centers/type/{center_type}', 'ReservableCenterController@public_listing');

Route::get('contact',function(){
    return view('static.contact');
});
Route::get('terms_of_service',function(){
    return view('static.terms_of_service');
});


Route::get('reservable_center/register', 'ReservableCenterController@createCenterForm')->name('reservable_center.createForm');
Route::post('reservable_center/register', 'ReservableCenterController@storeCenterForm')->name('reservable_center.storeForm');


Route::post('check_discounts','SiteController@check_discounts');



Route::group(['middleware' => ['auth','PelatoAcl']], function () {
    //----------------Center Types--------------------------------------------
    Route::get('center_type', 'CenterTypeController@index');
    Route::post('center_type/add', 'CenterTypeController@add');
    Route::get('center_type/{center_type}/edit', 'CenterTypeController@index');
    Route::patch('center_type/{center_type}/edit', 'CenterTypeController@edit');
    Route::get('center_type/{center_type}/delete', 'CenterTypeController@delete');
    //----------------Center Attributes--------------------------------------------
    Route::get('center_attribute', 'CenterAttributeController@index');
    Route::post('center_attribute/add', 'CenterAttributeController@add');
    Route::get('center_attribute/{center_attribute}/edit', 'CenterAttributeController@index');
    Route::patch('center_attribute/{center_attribute}/edit', 'CenterAttributeController@edit');
    Route::get('center_attribute/{center_attribute}/delete', 'CenterAttributeController@delete');
    //----------------Room Attributes--------------------------------------------
    Route::get('room_attribute', 'RoomAttributeController@index')->name('room_attributes.index');
    Route::post('room_attribute/add', 'RoomAttributeController@store')->name('room_attributes.store');
    Route::get('room_attribute/{room_attribute}/edit', 'RoomAttributeController@index')->name('room_attributes.edit');
    Route::patch('room_attribute/{room_attribute}/edit', 'RoomAttributeController@update')->name('room_attributes.update');
    Route::get('room_attribute/{room_attribute}/delete', 'RoomAttributeController@destroy')->name('room_attributes.delete');
    //----------------Reservable Centers-------------------------------------------
    Route::get('reservable_center', 'ReservableCenterController@index');
    Route::post('reservable_center/add', 'ReservableCenterController@add');
    Route::get('reservable_center/{reservable_center}/edit', 'ReservableCenterController@index')->name('reservable_center.edit');
    Route::patch('reservable_center/{reservable_center}/edit', 'ReservableCenterController@edit')->name('reservable_center.update');
    Route::get('reservable_center/{reservable_center}/delete', 'ReservableCenterController@delete');
    Route::get('reservable_center/{reservable_center}/verify', 'ReservableCenterController@verify');
    Route::get('reservable_center/{reservable_center}/active', 'ReservableCenterController@active');
    Route::put('reservable_center/{reservable_center}/isBest', 'ReservableCenterController@isBest')->name('reservable_center.isBest');
    //----------------Users--------------------------------------------
    Route::get('user', 'UserController@index')->name('users.index');
    Route::post('user/add', 'UserController@add');
    Route::get('user/{user}/edit', 'UserController@index');
    Route::patch('user/{user}/edit', 'UserController@edit');
    Route::get('user/{user}/delete', 'UserController@delete');
    Route::put('user/{user}/confirm', 'UserController@updateConfirm')->name('users.update.confirm');
    Route::get('user/center_owner', 'UserController@centerOwners')->name('users.center_owner');
    Route::get('user/center_owner/{center}/show', 'UserController@userCenterShow')->name('users.center_owner.show');
	Route::get('user/{user}/show', 'UserController@userShow')->name('users.show');

    Route::get('message/sendform','SiteController@showform');
    //----------------Reservable Center Rooms--------------------------------------------
    Route::get('room', 'RoomController@index')->name('room.index');
    Route::get('room/center/{reservable_center_filter}', 'RoomController@index');
    Route::post('room/add', 'RoomController@add');
    Route::get('room/{room}/edit', 'RoomController@index');
    Route::patch('room/{room}/edit', 'RoomController@edit');
    Route::get('room/{room}/delete', 'RoomController@delete');


    Route::get('room/{room}/edit','RoomController@editroom')->name('room.edit');
    Route::post('room/{room}/update','RoomController@update')->name('room.update');
    Route::post('/room/image-upload/{room_id}','RoomController@uploadImage')->name('room.upload.image');
    Route::post('/room/image/delete','RoomController@deleteImageRoom')->name('delete.imageRoom');


    //----------------Reservable Center Rooms Timing--------------------------------------------
    Route::get('timing', 'TimingController@index');
    Route::get('timing/center/{center}', 'TimingController@index');
    Route::get('timing/week/{week}/set', 'TimingController@set');
    Route::get('timing/center/{center}/week/{week}/set', 'TimingController@set');
    Route::post('timing/week/{week}/set', 'TimingController@set');
    Route::post('timing/center/{center}/week/{week}/set', 'TimingController@set');
    Route::get('timing/ajax_order_view/{order}', 'TimingController@ajax_order_view');
    //----------------Dashboard--------------------------------------------
    Route::get('dashboard', 'DashboardController@index');
    Route::post('dashboard', 'ImageController@reservable_center_poster');
    //----------------Image--------------------------------------------
    Route::get('image/room/{room}/list', 'ImageController@room_list');
    Route::post('image/room/{room}/list', 'ImageController@room_add');
    Route::get('image/room/{room}/image/{image}/delete', 'ImageController@room_delete');
    //----------------Events--------------------------------------------
    Route::get('event', 'EventController@index');
    Route::post('event/add', 'EventController@add');
    Route::get('event/{event}/edit', 'EventController@index');
    Route::patch('event/{event}/edit', 'EventController@edit');
    Route::get('event/{event}/delete', 'EventController@delete');
    Route::get('event/test', 'EventController@test');
    //---------------Reserve Process--------------------------------------------
	Route::post('register/order', 'OrderController@customReserve')->name('custom.reserve');
	Route::put('order/update/{order}', 'OrderController@updateStatusPayment')->name('order.update.statusPayment');
    Route::get('order/set', 'OrderController@set');
    Route::post('order/pay', 'OrderController@pay');
    Route::any('order/payback/{order}', 'OrderController@payback');
    Route::get('orders', 'OrderController@archive');
    Route::get('orders/{order}', 'OrderController@archive_detail');
    Route::get('myorders/{order}', 'OrderController@myarchive_detail');

    Route::get('orders_all/', 'OrderController@all');
	Route::get('showorders/{id}', 'OrderController@archivefromuser');
	
	Route::get('checkout/{center_id}/{week_id}/{amount}','CheckoutController@tasvie');
    Route::delete('restorcheckout/{center_id}/{week_id}','CheckoutController@destroy');


	Route::post('user/add_comment','WelcomeController@comment');
    Route::get('admin/comment','CommentController@index');
    Route::post('admin/comment/change_state','CommentController@change_state');
    Route::post('admin/comment/create','CommentController@create');
    Route::delete('admin/comment/{id}','CommentController@delete');



	Route::get('admin/discounts','DiscountController@get_discount_form');
    Route::post('admin/discounts','DiscountController@discounts');
    Route::delete('admin/discounts/{id}','DiscountController@del_discounts');



    Route::get('discount_detail/{id}', 'DiscountController@show');

    Route::get('sendmessage', 'SiteController@sendmessage');
    Route::post('message', 'SiteController@message');






});

//-----------centerOwner------
Route::group(['middleware' => ['auth','centerowner']], function () {



	Route::get('centerowner/contact',function(){
    return view('static.centerownercontact');
});


    Route::get('centerowner/profile','CenterOwnerController@profile')->name('centerowner.profile');
    Route::patch('centerowner/updateprofile','CenterOwnerController@update')->name('centerowner.updateprofile');
    Route::post('centerowner/updateprofile','CenterOwnerController@update');

    Route::get('centerowner/panel','CenterOwnerController@index')->name('centerowner.index');
    Route::get('centerowner/dashboard','CenterOwnerController@show')->name('showcenterdetail');
    Route::post('centerowner/dashboard', 'CenterOwnerController@reservable_center_poster');
    Route::get('centerowner/timing', 'CenterOwnerController@timing')->name('centerownertiming');

    Route::get('centerowner/timing/week/{week}/set', 'CenterOwnerController@set');
    Route::get('centerowner/timing/center/{center}/week/{week}/set', 'CenterOwnerController@set');
    Route::post('centerowner/timing/week/{week}/set', 'CenterOwnerController@set');
    Route::post('centerowner/timing/center/{center}/week/{week}/set', 'CenterOwnerController@set');
    Route::get('centerowner/timing/ajax_order_view/{order}', 'CenterOwnerController@ajax_order_view');

    //----------------Image--------------------------------------------
    Route::get('centerowner/image/room/{room}/list', 'CenterOwnerController@room_list');
    Route::post('centerowner/image/room/{room}/list', 'CenterOwnerController@room_add');
    Route::get('centerowner/image/room/{room}/image/{image}/delete', 'CenterOwnerController@room_delete');

   Route::get('centerowner/selectday', 'CenterOwnerController@selectday');
  
    Route::post('centerowner/setdaytime','CenterOwnerController@setdaytime');
    Route::get('centerowner/setdaytime','CenterOwnerController@setdaytime');
    

	Route::get('centerowner/discounts','CenterOwnerController@get_discount_form');
    Route::post('centerowner/discounts','CenterOwnerController@discounts');
    Route::delete('centerowner/discounts/{id}','CenterOwnerController@del_discounts');

    Route::get('centerlogout',function(){

        Auth::logout();
        return redirect('/centerlogin');
    });

    Route::get('centerowner/orders_detail','CenterOwnerController@specific_orders');
    Route::get('centerowner/orders/{order}', 'CenterOwnerController@archive_detail');

    Route::get('orders_detail','OrderController@specific_orders');
    Route::get('myorders_detail','OrderController@myspecific_orders');

    Route::post('register/centerorder', 'OrderController@centercustomReserve')->name('centercustom.reserve');

    Route::get('/user/mostReserve/list','UserController@userWithMostReserveList')->name('user.mostReserveList');

});



Route::get('centerlogin',function(){

    if (Auth::check()){
        if(Auth::user()->type==2){
            return redirect('centerowner/panel');
        }
        if(Auth::user()->type==1){
            return redirect('users/index');
        }
    }
    return view('centerOwner.login');
});

Route::post('centerownerlogin','CenterOwnerController@login')->name('centerownerlogin');
//---------end-------





Route::get('users/index',function(){


    return view('users.index');
});





Route::any('verify', function (){
   return 'hi';
})->name('verify');

Route::get('getway-view', function (){
    return view('test-getway');
});

Route::post('getway', function (){
    $parameters = array(
        'pin' => 'ls41K23m570r2P55772Y' ,
        'LoginAccount'		=> '',
        'Amount' 			=> 1000,
        'OrderId' 			=> '',
        'CallBackUrl' 		=> route('verify'),
        'AdditionalData' 	=> ''
    );

    $client		= new SoapClient('https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl',array('soap_version'=>'SOAP_1_1','cache_wsdl'=>WSDL_CACHE_NONE  ,'encoding'=>'UTF-8'));
    $result		= $client->SalePaymentRequest(array("requestData" => $parameters));
    $token 		= $result->SalePaymentRequestResult->Token;
    $status 	= $result->SalePaymentRequestResult->Status;


    if ($token > 0 && $status==0)
    {
        header('location:https://pec.shaparak.ir/NewIPG/?Token='.$token);
        exit;
    } else {
        echo 'error in payment request - status : '. $status;
    }
})->name('test.getway');

Route::get('abbas','WelcomeController@abbas');
Route::get('kh','WelcomeController@kh');