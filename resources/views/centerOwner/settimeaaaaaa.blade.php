@extends('layout.admin')

@push('top_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="/assets/global/plugins/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/nouislider/nouislider.pips.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/nouislider/nouislider.min.js" type="text/javascript"></script>
<script src="/js/underscore-min.js" type="text/javascript"></script>
<script>
    var week_id = {{ $set_week->id }};
    var room_list=[];
    var room_timing = {!! $room_timing !!}
@foreach($center->room as $room)
room_list.push({id:{{ $room->id}},price:{{ $room->price_per_hour}}});
            @endforeach
    var edit_enabled = {{ $edit_enabled}};
</script>
<script src="/js/timing.js" type="text/javascript"></script>
<script src="/js/timing_range_slider.js" type="text/javascript"></script>

@endpush
@section('content')
    <div id="app">
        <section class="content">
            <div class="row text-center" style="font-size: 16px;font-weight: bold; padding-left: 5px; padding-right: 5px;">
                @include('layout.user.error')
            </div>

    <!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->


            <div class="row">
                <div class="col-xs-12 hidden-lg hidden-md navbar navbar-static-top text-center"  style="position: fixed;  height: 65px;background-color: #00a65a; padding: 20px; border-radius: 10px;">
          <span class="caption-subject bold uppercase" style="font-weight: bold;font-family: 'IRANSans', sans-serif">زمانبندی اتاقهای مرکز " {{ $center->name }} " </span>

                    <form method="post" id="room_timing_result">
                        {{csrf_field() }}
                        <div class="row">
                            <input type="hidden" name="result_to_save" value="">
                            <input type="hidden" name="weekid" value="{{$week_id}}">
                            <input type="hidden" name="dayid" value="{{$day_id}}">
                        <div class="text-center">
                            <button type="submit"  class="btn btn-info pull-right" style="border-radius: 10px; margin-right: 40%">ثبت نهایی</button>

                        </div>
                        </div>
                    </form>

                </div>
            </div>
    <div class="row">
        <div class="col-md-12"  style="padding: 20px;">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="row" style="padding: 15px;">
                        <div class="caption font-dark" style="width: 450px;">
                            <i class="icon-settings font-dark"></i>

                            <span class="caption-subject bold uppercase">زمانبندی اتاقهای مرکز " {{ $center->name }} "
                    </span>
                        </div>
                    </div>

                    <div class="actions  hidden-xs">
                        <form method="post" id="room_timing_result">
                            {{csrf_field() }}
                            <div class="row" style="padding: 20px;">
                                <input type="hidden" name="result_to_save" value="">
                                <input type="hidden" name="weekid" value="{{$week_id}}">
                                <input type="hidden" name="dayid" value="{{$day_id}}">

                                <button type="submit"  class="btn btn-success pull-right">ثبت نهایی</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="col-md-2 control-label">تنظیم</label>
                                    <div class="col-md-10">
                                        <label class="radio-inline"><input type="radio" value="1" checked="true" name="control_what">زمانهای قابل رزرو</label>
                                        <label class="radio-inline"><input type="radio" value="2" name="control_what">قیمت</label>
                                    </div>
                                </div>
                                <div class="form-group  col-md-7">
                                    <label class="col-md-5 control-label">محدوده زمانی</label>
                                    <div class="col-md-7">
                                        <div id="working_range" class="noUi-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-3 col-md-offset-9">
                                <a class="btn btn-warning" href="/centerowner/selectday" ><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>بازگشت</a>
                                <button class="btn btn-info" onclick="update_cells_batch();">اعمال</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    @foreach($center->room as $room)

        <div class="panel panel-info">
            <div class="panel-heading" style="font-size: 18px; font-weight: bold; text-align: center;"> {{ $room->name }} </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                </div>
                                <div class="actions">
                                    <span>قیمت</span>
                                    <a  class="btn btn-default btn-sm" title="قیمت پایه اتاق">
                                        <i class="fa fa-asterisk"></i> {{ $room->price_per_hour }} </a>
                                    <a  class="btn btn-default btn-sm" title="قیمت متفاوت اتاق">
                                        <i class="fa fa-arrows"></i>
                                        <input type="number" style="width:60px;height:20px;display: inline" name="room_{{ $room->id}}_new_price" min="1" id="new_price" class="form-control"  value="{{ $room->price_per_hour }}">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="col-md-12" style="overflow-x: scroll">
                                <!--
                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                <thead>

                                <tr>
                                    <th style="font-size: 12px;" colspan="2">برنامه اتاق {{ $room->name }}</th>
                                    <th colspan="12" style="background-color: #F4C20B;color: white;">صبح</th>
                                    <th colspan="12" style="background-color: #1d4f8e;color: white;">بعداز ظهر</th>
                                </tr>

                                <tr>
                                    <th> روز</th>
                                    <th> تاریخ </th>
                                    @for($i=0;$i<24;$i++)
                                    @php
                                        $start=$i;
                                        $end=$i+1;
                                        if($start>12){
                                        $start=$start-12;
                                        }
                                         if($end>12){
                                        $end=$end-12;
                                        }
                                    @endphp



                                            <th> {{$start}}-{{$end}} </th>
                                    @endfor
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($day_mapper as $dmkey => $dm)
                                    @if($dmkey==$day_id-1)
                                        <tr class="odd gradeX">
                                            <th> {{$dm}} </th>
                                        <th> {{ jalali_date(date_day_plus($set_week->start_date,$dmkey)) }} </th>
                                        @for($i=0;$i<24;$i++)
                                            <th class="box room_{{ $room->id }}"  data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                        @endfor
                                                </tr>
                                                @endif
                                @endforeach




                                        </tbody>
                                    </table>

           -->

                                    <hr>



                                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">

                                        <tr>
                                            <th class="text-center" style="width: 20%">ساعت</th>
                                            <th class="text-center">وضعیت</th>
                                        </tr>
                                        @for($i=0;$i<24;$i++)
                                            <tr>
                                                <th class="text-center">{{$i}}-{{$i+1}}</th>
                                                @foreach($day_mapper as $dmkey => $dm)
                                                    @if($dmkey==$day_id-1)
                                                        <th class="box room_{{ $room->id }} text-center"  data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                    @endif
                                                @endforeach

                                            </tr>


                                        @endfor


                                    </table>


                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>

            </div>
        </div>



    @endforeach
    </section>
    </div>
@stop
