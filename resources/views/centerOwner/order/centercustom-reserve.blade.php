@extends('layout.admin')
@section('content')
@include('layout.user.error')
<div id="app">
    <section class="content">

    <div class="row">
        <div class="portlet light ">
            <div class="portlet-title">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
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
            </div>
        </div>
        <div class="text-center" style="padding: 10px;">
            <form action="/reserve/owner" method="post" >
                {{ csrf_field() }}
                    <fieldset>
                        <input type="hidden" name="final_order_list" value="{{ $order_list_stringify }}">
                        <div class="row">
                            <div class="form-group col-sm-6 {{ $errors->has('user_name') ? ' has-error' : '' }}">
                                <span class="help-block text-right" > نام و نام خانوادگی رزرو کننده </span>
                                <input type="text" name="user_name" class="form-control" id="user_name" value="{{ old('user_name') }}">
                            </div>
                            <div class="form-group col-sm-6 {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <span class="help-block text-right" > موبایل رزرو کننده </span>
                                <input type="text" name="mobile" class="form-control" id="mobile" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <span class="help-block text-right">مبلغ رزرو شده</span>
                                <input type="text" name="price" class="form-control" id="price" value="{{ $full_price * 1000 }}">
                            </div>
                            <div class="form-group col-sm-6 {{ $errors->has('center_type') ? ' has-error' : '' }}">
                                <span class="help-block text-right">نوع پرداخت</span>
                                <select class="form-control" name="status_payment" id="status_payment" style="height: 44px" >
                                    <option value="" class="form-control"> انتخاب نحوه پرداخت.. </option>
                                    @foreach($status_payments as $status_payment)
                                        @if($status_payment->id!=4 && $status_payment->id!=1&& $status_payment->id!=2)
                                        <option  value="{{$status_payment->id}}"  selected  class="form-control">{{ $status_payment->title }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-xs-12 col-md-12{{ $errors->has('center_type') ? ' has-error' : '' }}">
                                <span class="help-block text-right">نوع مشتری</span>
                                <select class="form-control" name="usertype" id="usertype" style="height: 44px" >
                                    <option value="0" class="form-control">مشتری مرکز </option>
                                    <option value="1" class="form-control"> مشتری سایت پلاتو </option>

                                </select>
                            </div>
                        </div>

                        <div class="f1-buttons text-center">
                            <button type="submit" class="btn btn-success btn-lg"> رزرو</button>
                        </div>
                    </fieldset>
            </form>
        </div>
    </div>

</section>
    </div>



@endsection