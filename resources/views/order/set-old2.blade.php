@extends('layout.user')

@section('bottom_scripts')


    <script>
        check=function()
            {
                var discounts=document.getElementById('discounts').value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});

                $.ajax(
                        {
                            url:'<?= url('check_discounts') ?>',
                            type:'POST',
                            data:'discounts='+discounts,
                            success:function(data)
                            {

                                if(data.ok=='ok'){
					
                                   var price=(100-(data.discount));
								   price=price*<?php echo Session::get('full_price')*10;  ?>
                                    // alert(<?= Session::get('discounts') ?>);
                                    $("#show").html('کد تخفیف وارد شده صحیح است')
                                    $("#pardakhti").html(price)
                                    $("#show").css({ 'color': 'green', 'font-size': '16px', 'font-weight':'bold' })


                                }

                                if(data=='nok'){
                                    var price= <?php echo (Session::get('full_price')*1000) ?>;
                                    $("#show").html('کد تخفیف وارد شده وجود ندارد')
                                    $("#pardakhti").html(price)
                                    $("#show").css({ 'color': 'red', 'font-size': '16px', 'font-weight':'bold' })
                                }

                               /// $("#show").html(data)
                               // alert(data);
                            }
                        });
            }


    </script>



@stop
@section('content')
@include('layout.user.error')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست روز و ساعات رزرو</span>
              </div>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="order_list">
                  <thead>
                      <tr>
                          <th> اتاق </th>
                          <th> روز</th>
                          <th> ساعات </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($timing_list_to_show as $room_key => $room)
                    <?php $newline = false; ?>
                    <tr class="odd gradeX">
                      <td rowspan="{{ $room_mapper[$room_key]["count"] }}"> {{$room_mapper[$room_key]["name"] }} </td>
                      @foreach($room as $day_key => $day)
                        @if($newline)
                          <tr class="odd gradeX">
                          <?php $newline = false; ?>
                        @endif
                        <td rowspan="{{count($day) }}"> {{$day_mapper[$day_key] }} </td>
                          @foreach($day as $hour)
                            @if($newline)
                              <tr class="odd gradeX">
                              <?php $newline = false; ?>
                            @endif
                            <td> {{$hour["start_hour"] }} - {{$hour["end_hour"] }} </td>
                            </tr>
                            <?php $newline = true; ?>
                          @endforeach
                        </tr>
                        <?php $newline = true; ?>
                      @endforeach
                    </tr>
                    @endforeach
                  </tbody>
              </table>
              <div class="row"><span class="pull-right">مبلغ پرداختی: {{$full_price * 1000 }} تومان</span></div>

  <div class="row text-center" style="padding-top:10px;">

        <div class="col-md-12" id="order_price" >
            <div style="width:90%;margin:auto;;border:1px solid #62b965">
                <span style="padding-right:5px;line-height:70px;">در صورت داشتن کد تخفیف وارد نمایید</span>
			
                <span  class="text-center"><input name="discounts" value="" id="discounts" type="text" style="border:1px solid #eeeff1;font-size:15px;font-family:Yekan;"></span>
                
				<span><input  type="button" class="btn btn-success" onclick="check()" value="بررسی"  style="background:#62b965;border:1px solid #62b965;font-size:13px;color:#ffffff;width:80px;margin-right:5px;height:27px;line-height:8px;padding:5px;"></span>
               <hr>
                <span style="color: red;" id="show"></span>
            </div>

            <div style="width:90%;margin:auto; padding-top: 5px;">
                <p style="padding-top:10px;"><span style="color:#ff0000">هزینه کل</span> : <span style="font-family:sans-serif">
                      <?= number_format(Session::get('full_price')*1000); ?>

                    </span> تومان</p>
                <p style="padding-top:10px;"><span style="color:#ff0000">هزینه قابل پرداخت</span> :
                    <span style="font-family:sans-serif" id="pardakhti">

                            <?= number_format(Session::get('full_price')*1000); ?>

                    </span> تومان</p>

            </div>

        </div>


    </div>

          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
<div class="row">
  <form method="post" id="order_form" action="/order/pay">
    {{csrf_field() }}
    <input type="hidden" name="final_order_list" value="{{ $order_list_stringify }}">
    <button class="btn btn-lg pull-right btn-success"  type="submit">تایید و پرداخت</button>
    <button class="btn btn-lg pull-right btn-default" onclick="window.history.back();" type="button">ویرایش زمان ها</button>
  </form>
</div>
  
@stop
