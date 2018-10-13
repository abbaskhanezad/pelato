@extends('layout.user')

@section('bottom_scripts')

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
