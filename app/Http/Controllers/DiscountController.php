<?php

namespace App\Http\Controllers;

use App\Discounts;
use App\ReservableCenter;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\discountRequest;

use DB;
class DiscountController extends Controller
{


    public function get_discount_form()
    {
       $Discounts=Discounts::orderBy('id','DESC')->get()->toArray();
        $centers=ReservableCenter::all();

       return View('discount.index',['Discounts'=>$Discounts,'centers'=>$centers]);
    }
    public function discounts(discountRequest $request)
    {
        if(!empty($request->get('discounts_name')) && !empty($request->get('discounts_value'))  && !empty($request->get('capacity')) )
        {


           if($request->priority==1 && $request->discounts_value>10 && $request->center_id==0){

               flash_message('درصد تخفیف برای حالت خصوصی نمی تواند بیش از 10 باشد','danger');
               return redirect()->back();
           }
            if($request->priority==1 && $request->discounts_value<10&& $request->center_id==0 && $request->show==0){

             $priority=2;

            //dd($request->all());
        }else{
                $priority=$request->priority;

            }

$discount=new Discounts();
            $discount->discounts_name=$request->discounts_name;
            $discount->discounts_value=$request->discounts_value;
            $discount->capacity=$request->capacity;
            $discount->center_id=$request->center_id;
            $discount->priority=$priority;

         //   $Discounts=Discounts::create($request->all());
            $discount->save();
        }

       if($request->has('Discounts'))
       {
          // DB::table('setting')->where('option_name','Discounts')->update(['option_value'=>'Active']);
       }
       else
       {
         //  DB::table('setting')->where('option_name','Discounts')->update(['option_value'=>'InActive']);
       }
flash_message('کد تخفیف با موفقیت اضافه شد','success');
        return redirect()->back();
    }
    public function del_discounts($id)
    {
        DB::table('discounts')->where('id',$id)->delete();
        flash_message('کد تخفیف با موفقیت حذف شد','success');

        return redirect()->back();
    }

    public function show($id)
    {

        $dis = Discounts::where('id', $id)->first();
        if ($dis) {
            return View('discount.show', ['discount' => $dis]);

        } else {
            flash_message('کد تخفیف حذف شده است', 'success');

            return redirect()->back();

        }
    }


    }
