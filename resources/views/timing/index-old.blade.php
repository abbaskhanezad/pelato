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
                          <th>مجموع فروش</th>
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
                          <td> {{number_format($data->reserved_prices * 1000)}}</td>
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
