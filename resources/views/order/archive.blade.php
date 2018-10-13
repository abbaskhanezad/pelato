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
                  <i class="fa fa-ticket font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست رزروها</span>
              </div>
          </div>
          <div class="portlet-body">
              <p>لیست سابقه رزروهای شما عبارتند از:</p>
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="order_list">
                  <thead>
                      <tr>
                          <th> # </th>
                          <th> شناسه رزرو </th>
                          <th> جزئیات رزرو </th>
                          <th> مبلغ پرداختی </th>
                          <th> کد رهگیری </th>
                          <th> تاریخ رزرو </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $c => $o)
                        <tr>
                            <td> {{ $c+1 }} </td>
                            <td> PLT-{{ $o->id }} </td>
                            <td> <a href="/orders/{{$o->id}}">مشاهده</a> </td>
                            <td> {{ $o->whole_price * 1000 }}تومان  </td>
                            <td> {{ $o->mellat_pay_ref_id }} </td>
                            <td>{{$o->created_at->format('H:i')}}  {{ jalali_date($o->created_at) }}    </td>
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
