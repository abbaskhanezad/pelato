@extends('layout.user')


<script type="text/javascript">

    function del_row(centerid,weekid)
    {
                <?php
                $token=Session::token();
                ?>
        var route='<?= url("/restorcheckout")."/" ?>';
        if (!confirm("آیا از بازیابی تسویه اطمینان دارید؟!"))
            return false;
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action",route+centerid+'/'+weekid);
        var hiddenField1 = document.createElement("input");
        hiddenField1.setAttribute("name", "_method");
        hiddenField1.setAttribute("value",'DELETE');
        form.appendChild(hiddenField1);
        var hiddenField2 = document.createElement("input");
        hiddenField2.setAttribute("name", "_token");
        hiddenField2.setAttribute("value",'<?= $token ?>');
        form.appendChild(hiddenField2);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }



</script>

@section('content')
    @include('layout.user.error')
    @php
        use App\RoomTiming;
        use App\OrderRoom;
        use App\Checkout;
        $user_type=auth()->user()->type;
    @endphp
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">برنامه هفتگی مرکز " {{ $center->name }} "</span>
                    </div>
                    @if($is_admin)
                        <div class="actions">
                            <a class="btn btn-primary" href="/reservable_center/">بازگشت به لیست مراکز</a>
                        </div>
                    @endif
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th> شماره هفته </th>
                            <th> از تاریخ </th>
                            <th> تا تاریخ </th>
                            <th> تعداد ساعات قابل رزرو</th>
                            <th> تعداد ساعات رزرو شده</th>
                            <th>  مجموع فروش

                            <th>  مجموع فروش  از سایت  </th>
                            <th>  مجموع فروش با تخفیف سایت پلاتو  </th>

                            <th>مبلغ پرداختی به مرکزدار </th>
                            @if($user_type==3||$user_type==4)
                            <th> کمیسیون سایت پلاتو</th>

                                <th> وضعیت تسویه</th>
                            @endif

                            <th> عملیات </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($weeks as $data)
                            <?php
                            if($data->id >= ($current_week_id+8)){
                                break;
                            }
                            ?>
                            <tr class="odd gradeX @if($data->id == $current_week_id) selected_row @endif">
                                <td> {{$data->id}} </td>
                                <td> {{jalali_date($data->start_date)}} </td>
                                <td> {{jalali_date($data->end_date)}} </td>
                                <td> {{$data->reservable_count}} </td>
                                <td> {{$data->reserved_count}}</td>
                                <td>

                                    @php
                                        $centerid=$center->id;



                      $onl=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',1],['paid',1]  ])->get();




                            $ca=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',2],['paid',1]  ])->get();





                                $ho=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',3],['paid',1]  ])->get();




                                        $hamount=0;
                                        $oamount=0;
                                        $camount=0;

                                        foreach ($ho as $hz){
                                        $hamount+=$hz->whole_price;
                                        }

                                        foreach ($onl as $on){
                                        $oamount+=$on->whole_price;
                                        }
                                        foreach ($ca as $ct){
                                        $camount+=$ct->whole_price;
                                        }
                                        $income=$oamount+$camount+$hamount;
                                    @endphp

                                    {{number_format($income*1000)}}


                                </td>

                                <td>
                                    @php
                                        $centerid=$center->id;

                                        $hozuri=RoomTiming::whereHas('order_room',function ($query) use($centerid){
                                        $query->where([
                                        ['status_payment_id',3],
                                        ['paid',1]  ]);
                                        })->whereHas('room',function ($query) use($centerid){
                                        $query->where('reservable_center_id',$centerid);
                                        })->where('week_id',$data->id)->get();

                                        $cart=RoomTiming::whereHas('order_room',function ($query) use($centerid){
                                        $query->where([
                                        ['status_payment_id',2],
                                        ['paid',1]  ]);
                                        })->whereHas('room',function ($query) use($centerid){
                                        $query->where('reservable_center_id',$centerid);
                                        })->where('week_id',$data->id)->get();

                                        $online=RoomTiming::whereHas('order_room',function ($query) use($centerid){
                                        $query->where([
                                        ['status_payment_id',1],
                                        ['paid',1]  ]);
                                        })->whereHas('room',function ($query) use($centerid){
                                        $query->where('reservable_center_id',$centerid);
                                        })->where('week_id',$data->id)->get();


                      $onl=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',1],['paid',1]  ])->get();




                            $ca=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',2],['paid',1]  ])->get();





                                  $ho=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',3],['paid',1]  ])->get();




                                        $hamount=0;
                                        $oamount=0;
                                        $camount=0;
                                        $amount=0;

                                        foreach ($ho as $hz){
                                        $hamount+=$hz->whole_price;
                                        }

                                        foreach ($onl as $on){
                                        $oamount+=$on->whole_price;
                                        }
                                        foreach ($ca as $ct){
                                        $camount+=$ct->whole_price;
                                        }
                                        $site_get=$oamount+$camount;
                                    @endphp

                                    {{number_format($site_get*1000)}}


                                </td>



                                <td>
                                    @php
                                        $centerid=$center->id;



                      $onl=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                            $query->where('week_id',$data->id)
                            ->whereHas('room',function ($query) use($centerid){
                                      $query->where('reservable_center_id',$centerid);
                  });

                  })-> where([ ['status_payment_id',1],['paid',1] ,['pelato_discount','>',0] ])->get();









                                        $oamount=0;




                                        foreach ($onl as $on){
                                        $oamount+=$on->whole_price;
                                        }

                                        $site_get=$oamount;
                                    @endphp

                                    {{number_format($site_get*1000)}}


                                </td>





                                <td>

                                    @php

                                        $checkout=Checkout::where([['week_id',$data->id],['center_id',$center->id],['checkouted',1]])->count();

                                                  $centerid=$center->id;



                                                //--------bedune tkhfife pelatoi-------

                                                   $online=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                                                     $query->where('week_id',$data->id)
                                                     ->whereHas('room',function ($query) use($centerid){
                                                               $query->where('reservable_center_id',$centerid);
                                           });

                                           })-> where([ ['status_payment_id',1],['paid',1], ['pelato_discount',0]  ])->get();




                                                 //------------takhfife pelatoi khordeha---------------------
                                                   $online_pelato_discount=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                                                     $query->where('week_id',$data->id)
                                                     ->whereHas('room',function ($query) use($centerid){
                                                               $query->where('reservable_center_id',$centerid);
                                           });

                                           })-> where([ ['status_payment_id',1],['paid',1] ,['pelato_discount','>',0] ])->get();


                                                  //-------------------end-----------------


                                                     $cart=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                                                     $query->where('week_id',$data->id)
                                                     ->whereHas('room',function ($query) use($centerid){
                                                               $query->where('reservable_center_id',$centerid);
                                           });

                                           })-> where([ ['status_payment_id',2],['paid',1]  ])->get();





                                                           $hozuri=OrderRoom::whereHas('room_timing',function ($query) use($centerid,$data){

                                                     $query->where('week_id',$data->id)
                                                     ->whereHas('room',function ($query) use($centerid){
                                                               $query->where('reservable_center_id',$centerid);
                                           });

                                           })-> where([ ['status_payment_id',3],['paid',1]  ])->get();




                                                                 $hamount=0;
                                                                 $oamount=0;
                                                                 $odamount=0;
                                                                 $camount=0;
                                                                 $amount=0;

                                                                 foreach ($hozuri as $hz){
                                                                 $hamount+=$hz->whole_price;
                                                                 }

                                                                  foreach ($online as $on){
                                                                 $oamount+=$on->whole_price;
                                                                 }

                                                                   foreach ($online_pelato_discount as $on){
                                                                 $odamount+=($on->whole_price*100)/(100-$on->pelato_discount);
                                                                 }

                                                                  foreach ($cart as $ct){
                                                                 $camount+=$ct->whole_price;
                                                                 }
                                                               $amount=(((100-$center->commission)/100)*($oamount+$odamount+$camount)-($center->commission/100)*($hamount));
                                    @endphp
                                    @if($checkout>0)
                                        <span style="color:lightskyblue">{{"تسویه شده"}}</span>
                                    @else
                                        {{number_format(abs(($amount)*1000))}}

                                        @if($user_type==3||$user_type==4)
                                            @if($amount>0)
                                                <span style="color: red">{{"بدهکار"}}</span>
                                            @endif
                                            @if($amount<0)
                                                <span style="color: green">{{"بستانکار"}}</span>
                                            @endif
                                        @elseif($user_type==2)
                                            @if($amount>0)
                                                <span style="color: green">{{"بستانکار"}}</span>
                                            @endif
                                            @if($amount<0)
                                                <span style="color: red">{{"بدهکار"}}</span>
                                            @endif
                                        @endif

                                    @endif


                                </td>

                                @if($user_type==3||$user_type==4)

                                <td>{{$center->commission}}{{'%'}}</td>




                                    <td>
                                        @php
                                            $checkout=Checkout::where([['week_id',$data->id],['center_id',$center->id],['checkouted',1]])->count();
                                        @endphp
                                        @if($data->id<=$current_week_id)
                                            @if($checkout>0)

                                                <a onclick="del_row('<?=  $center->id ?>','<?=  $data->id ?>')" class="text-danger" style="font-size:14px;">بازیابی تسویه</a>

                                            @else
                                                <a href="/checkout/{{$center->id}}/{{$data->id}}/{{$amount*1000}}">تسویه حساب</a>

                                            @endif
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        {{--@if($data->id >= $current_week_id)--}}
                                        <a href="@if($is_admin) /timing/center/{{ $center->id }}/week/{{ $data->id }}/set @else /timing/week/{{ $data->id }}/set @endif">
                                            <button class="btn btn-xs warning" type="button"  aria-expanded="false">
                                                <i class="fa fa-cog"></i> زمانبندی / لیست رزرو
                                            </button>
                                        </a>
                                        {{--@endif--}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@stop
