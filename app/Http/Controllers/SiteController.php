<?php

namespace App\Http\Controllers;

use App\Address;
use App\Category;
use App\Comment;
use App\lib\Jdf;
use App\lib\mellat;
use App\Order;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Product;
use Illuminate\Support\Facades\Session;
use Response;
use Mail;
use SoapClient;

class SiteController extends Controller
{
    public function addcart(Request $request)
    {
        if($request->has('product_id'))
        {
           $product_id=$request->get('product_id');
            if(Product::find($product_id))
            {
                if(Session::has('cart'))
                {
                    $array=Session::get('cart');
                    $array[$product_id]=1;
                    Session::put('cart',$array);

                }
                else
                {
                    $array=array();
                    $array[$product_id]=1;
                    Session::put('cart',$array);
                }

                return redirect('cart');
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }
    public function cart()
    {
        return View('site.cart');
    }
    public function comment(Requests\CommentRequest $request)
    {
        if($request->has('product_id'))
        {
            $product_id = $request->get('product_id');
            if (Product::find($product_id))
            {
                $Comment=new Comment($request->all());
                $Comment->state=0;
                $Comment->time=time();
                $Comment->save();
                return redirect()->back()->with('create','ok');
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }
    public function del_cart(Request $request)
    {
       if($request->ajax())
       {
           $id=$request->get('id');
           if(array_key_exists($id,Session::get('cart')))
           {
               $array=Session::get('cart');
               unset($array[$id]);
               if(!empty($array))
               {
                   Session::put('cart',$array);
               }
               else
               {
                   Session::forget('cart');
               }

           }



if(empty(Session::get('cart')))
{
    ?><script>
    $("#order_box").hide()
</script><?php
}


           return View('site.ajaxcart');
       }

    }
      public function check_discounts(Request $request)
    {


        if ($request->ajax()) {
            $discounts = $request->get('discounts');
            $row = DB::table('discounts')->where('discounts_name', $discounts)->first();
            if ($row) {
                if($row->center_id==Session::get('discount_center_id')||$row->center_id==0){
                    if($row->capacity>0){
						Session::forget('discount_id');
                        Session::put('discount_id',$row->id);
                        Session::forget('discounts');
                        $t = $row->discounts_value;
                        Session::put('discounts', $t);
                        if($row->center_id==0 && $row->priority==1){
                            Session::forget('pelato_discount');
                            Session::put('pelato_discount', $t);
                        }
                        if($row->center_id==0 && $row->priority==2){
                            Session::forget('pelato_discount');
                            Session::put('pelato_discount', $t);
                        }
                        return Response::json(array('ok' => 'ok', "discount" => $t));
                    }else{
						Session::forget('discount_id');
                        Session::forget('discounts');

                        return 'capacityerror';
                    }

                }
                else{
					Session::forget('discount_id');
                    Session::forget('discounts');

                    return 'nok';

                }


            }
            //  return View('site.ajaxcart',['message'=>'کد تخفیف وارد شده صحیح نمی باشد']);
			Session::forget('discount_id');
            Session::forget('discounts');
            return 'nok';
        }
    }

    public function addorder(Requests\OrderRequest $request)
    {
        $Jdf=new Jdf();
        $date=$Jdf->tr_num($Jdf->jdate('Y-n-j'));
        $product_id=null;
        foreach(Session::get('cart') as $key=>$value)
        {
            $product_id.=$key.',';
        }
        $order=new Order($request->all());
        $order->date=$date;
        $order->time=time();
        $order->product_id=$product_id;
        $order->payment_status='معلق';
        $order->order_read='no';
        $order->price=Session::get('price');
        $order->total_price=Session::get('total_price');

        require_once 'app/lib/nusoap.php';

        $mellat=new mellat();
        $res=$mellat->pay(Session::get('price'));
        if($res)
        {
            $order->RefId=$res;
            if($order->save())
            {
                Session::forget('cart');
                Session::forget('price');
                Session::forget('total_price');
                return View('site.location',['res'=>$res]);
            }
            else
            {
                return View('site.location');
            }
        }
        else
        {
            return View('site.location');
        }

    }
    public function order(Request $request)
    {
        $RefId=$request->get('RefId');
        $ResCode=$request->get('ResCode');
        $SaleOrderId=$request->get('SaleOrderId');
        $SaleReferenceId=$request->get('SaleReferenceId');
        if($ResCode==0)
        {
            require_once 'app/lib/nusoap.php';
            $mellat=new mellat();
            if($mellat->Verify($SaleOrderId,$SaleReferenceId))
            {
                $order=Order::where('RefId',$RefId)->first();
                $order->saleReferenceId=$SaleReferenceId;
                $order->payment_status='پرداخت شده';
                $order->save();

                $product_id=$order->product_id;
                $product_id=explode(',',$product_id);
                $array=array();
                $time=time()+24*60*60;
                foreach($product_id as $key=>$value)
                {
                    if(!empty($value))
                    {
                        $product=Product::where('id',$value)->first();
                        $download=$product->download;
                        $string=md5($time.'/sdjfhsdjhg');
                        DB::table('download')->insert(['file'=>$download,'name'=>$string,'time'=>$time]);
                        $array[$key]=array('title'=>$product->title,'url'=>$string);
                    }
                }
              //  define('email',$order->email);
              //  define('name',$order->fname);
              //  Mail::send('auth/emails/link',['order'=>$array,'time'=>$order->time],function($message)
              //  {
                //    $message->to(email,name)->subject('ایده پردازان جوان');
              //  });

                return View('site.order',['order'=>$array,'time'=>$order->time]);
            }
            else
            {

            }
        }


    }
    public function get_file(Request $request)
    {
        if($request->has('url'))
        {
           $url=$request->get('url');
           $row=DB::table('download')->where('name',$url)->first();
            if($row)
            {
               if($row->time-time()>0)
               {
                   $file_path=$row->file;
                   return Response::download($file_path,'file.zip', [
                       'Content-Length: '. filesize($file_path)
                   ]);
               }
                else
                {

                }
            }
        }
    }

    public function sendmessage()
    {

        return view('message.index');
}

    public function message(Request $request)
    {

      $number=$request->mobile;
        $message=$request->message;

        $array = explode(',', $number);

echo $this->sendSMS($array,$message);
    }



    function sendSMS($array, $message)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
            $user = "axsazi";
            $pass = "66251674";
            $fromNum = "+98100020400";
            $toNum = $array;
            $messageContent = $message;
            $op = "send";
            //If you want to send in the future  ==> $time = '2016-07-30' //$time = '2016-07-30 12:50:50'

            $time = '';

            $client->SendSMS($fromNum, $toNum, $messageContent, $user, $pass, $time, $op);

        } catch (SoapFault $ex) {
            //echo $ex->faultstring;
        }

    }

    public function showform()
    {
        return view('message.sendform');
    }
}
