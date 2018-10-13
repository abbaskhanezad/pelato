@extends('layout.user')

@section('bottom_scripts')
    <button onclick="goBack()">Go Back</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@stop
@section('content')
@include('layout.user.error')
@php
use App\Discounts;
use App\ReservableCenter;
@endphp
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="fa fa-ticket font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست رزروها</span>
              </div>
          </div>
          <div class="portlet-body">

              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="order_list">
                  <thead>
                  <tr>
                      <th> کدتخفیف </th>
                      <th> درصد تخفیف</th>
                      <th> مرکز ارائه کننده </th>
                  </tr>
                  </thead>
                  <tbody>
                 <tr>
                     <td>{{$discount->discounts_name}}</td>
                     <td>{{$discount->discounts_value}}</td>
                     <td>@if($discount->center_id==0){{'سایت پلاتو'}} @else {{\App\ReservableCenter::find($discount->center_id)->name}}   @endif</td>
                 </tr>
                  </tbody>
              </table>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
      <div>
          <button class="btn btn-info" onclick="goBack()">بازگشت</button>
      </div>
  </div>
</div>
@stop
