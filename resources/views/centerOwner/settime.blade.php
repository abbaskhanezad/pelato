@extends('layout.admin')

@push('top_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="/assets/global/plugins/nouislider/nouislider.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/nouislider/nouislider.pips.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
  <style>
        .reserved_hover{
            background-color: red;
        }
    </style>
@endpush

@push('bottom_scripts')

<script>
    $('#message').delay(1800).fadeOut('slow');

</script>
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
      <div id="message" class="text-center" style="font-weight:bold;">
                @include('layout.user.error')
            </div>

    <!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
    <div class="modal fade" id="reserve_data_box" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>

           <div class="row">
            <div class="col-xs-12 hidden-lg hidden-md navbar navbar-static-top text-center"  style="position: fixed;  background-color: #00a65a;  border-radius: 10px;">

                <form method="post" id="room_timing_result">
                    {{csrf_field() }}
                    <div class="row">
                        <input type="hidden" name="result_to_save" value="">
                        <input type="hidden" name="weekid" value="{{$week_id}}">
                        <input type="hidden" name="dayid" value="{{$day_id}}">
                        <div class="text-center">
                            <button type="submit"  class="btn btn-success pull-right" style="border-radius: 10px; height: 60px; width: 100%;font-size:20px;font-weight:bold;"> ثبت نهایی زمانبندی</button>

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
                        <div class="row" style="padding-top: 70px;padding-bottom: 10px;">
                            <div class="caption font-dark" style="width: 450px;">
                                <i class="icon-settings font-dark text-center"></i>

                                <span class="caption-subject bold uppercase text-center " style="margin-right:15%; font-weight:bold;font-size:18px;font-family:'IRANSans-web';">زمانبندی اتاقهای مرکز " {{ $center->name }} "
                    </span>
                            </div>
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





            @php
                $i=1;
            @endphp
            <ul class="nav nav-tabs">

            @foreach($center->room as $room)
                    <li @if($i==1) class="active" @endif><a data-toggle="tab" href="#br<?=$i ?>" >اتاق: {{ $room->name }}-{{$room->size}}متری</a></li>


                    @php
                        $i=$i+1;
                    @endphp
                @endforeach
            </ul>

            @php
                $k=1;
            @endphp
            <div class="tab-content">

    @foreach($center->room as $room)
            <div id="<?= 'br'.$k ?>" class="tab-pane fade @if($k==1) {{ 'in active'}} @endif">
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
                                                    @else
                                                        <th style="display:none;" class="box room_{{ $room->id }} text-center"  data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>

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
            </div>

                    @php
                        $k=$k+1;
                    @endphp
    @endforeach
            </div>
    </section>
    </div>
@stop
