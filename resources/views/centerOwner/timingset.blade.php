@extends('layout.admin')

@push('top_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="/assets/global/plugins/nouislider/nouislider.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/nouislider/nouislider.pips.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGINS -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
    //paste this code under head tag or in a seperate js file.
    // Wait for window load
    $(window).load(function() {
// Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });
</script>


<style>

    /* Paste this css to your style sheet file or under head tag */
    /* This only works with JavaScript,
    if it's not present, don't show loader */
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif) center no-repeat #fff;
    }

</style>
@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/nouislider/nouislider.min.js" type="text/javascript"></script>
<script src="/js/underscore-min.js" type="text/javascript"></script>
<script>
    var week_id = {{ $set_week->id }};
    var room_list = [];
    var room_timing = {!! $room_timing !!}
@foreach($center->room as $room)
room_list.push({id:{{ $room->id}}, price:{{ $room->price_per_hour}}});
            @endforeach
    var edit_enabled = {{ $edit_enabled}};
</script>
<script src="/js/time-set.js" type="text/javascript"></script>
<script src="/js/timing_range_slider.js" type="text/javascript"></script>
<script>
    $('#message').delay(1200).fadeOut('slow');

</script>

<script>
    function sabt() {
        update_cells_batch2();
        document.getElementById("room_timing_result").submit();
    }

</script>
@endpush
@section('content')
    <!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
    <div id="app">
        <section class="content">

            <div id="message" class="text-center" style="font-weight:bold;">
                @include('layout.user.error')
            </div>


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
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">


                            <div class="row">
                                <div class="col-xs-12 hidden-lg hidden-md navbar navbar-static-top text-center"
                                     style="position: fixed;  background-color: #00a65a;  border-radius: 10px;">

                                    <form method="post" id="room_timing_result">
                                        {{csrf_field() }}
                                        <div class="row">
                                            <input type="hidden" name="result_to_save" value="">

                                            <div class="text-center">
                                                <button onclick="sabt();" class="btn btn-success pull-right"
                                            style="border-radius: 10px; height: 60px; width: 100%;font-size:20px;font-weight:bold;">
                                                    ثبت نهایی زمانبندی
                                                </button>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>


                            <div class="row" style="padding-top: 80px;">
                                <div class="text-center">

                                    <div class="alert alert-warning" role="alert">

                                        با اعمال زمانبندی جدید، زمانهای قبلی تنظیم شده تغییر خواهد نمود.
                                    </div>
                                </div>
                            </div>
                            <div class="caption font-dark" style="width: 450px;">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">زمانبندی اتاقهای مرکز " {{ $center->name }}
                                    " برای
                    <span class="week_title">
                      <a href="@if($is_admin)/centerowner/timing/center/{{ $center->id}}/week/{{ $set_week->id - 1 }}/set @else /centerowner/timing/week/{{ $set_week->id - 1 }}/set @endif"><i
                                  class="glyphicon glyphicon-chevron-right" title="هفته قبل"></i></a>
                        {{ $lingual_set_week }}
                        <a href="@if($is_admin) /centerowner/timing/center/{{ $center->id }}/week/{{ $set_week->id + 1 }}/set @else /centerowner/timing/week/{{ $set_week->id + 1 }}/set @endif"><i
                                    class="glyphicon glyphicon-chevron-left" title="هفته بعد"></i></a>
                    </span>
                    </span>
                            </div>
                        </div>

                        <div class="actions">


                            <form method="post" id="room_timing_result">
                                {{csrf_field() }}
                                <div class="row" style="padding-top: 15px;padding-right:10px;">
                                    <input type="hidden" name="result_to_save" value="">
                                    <a class="btn btn-primary pull-right"
                                       href="@if($is_admin) /centerowner/timing/center/{{ $center->id }}/ @else /centerowner/selectday @endif">بازگشت</a>
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
                                            <label class="radio-inline"><input type="radio" value="1" checked="true"
                                                                               name="control_what">زمانهای قابل
                                                رزرو</label>
                                            <label class="radio-inline"><input type="radio" value="2"
                                                                               name="control_what">قیمت</label>
                                        </div>
                                    </div>
                                    <div class="form-group  col-md-7">
                                        <label class="col-md-5 control-label">محدوده زمانی</label>
                                        <div class="col-md-7">
                                            <div id="working_range" class="noUi-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-3 col-md-offset-9 text-center">
                                    <button class="btn btn-info" onclick="update_cells_batch2();">اعمال</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
    </div>
    <div class="row" style="padding: 10px;color: black;">
        <hr style="color: black;">
    </div>
    @foreach($center->room as $room)
        <div class="row hidden-lg hidden-md hidden-xs" style="padding-top:15px;">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">اتاق: {{ $room->name }}</span>
                        </div>
                        <div class="actions">
                            <span>قیمت</span>
                            <a class="btn btn-default btn-sm" title="قیمت پایه اتاق">
                                <i class="fa fa-asterisk"></i> {{ $room->price_per_hour }} </a>
                            <a class="btn btn-default btn-sm" title="قیمت متفاوت اتاق">
                                <i class="fa fa-arrows"></i>
                                <input type="number" style="width:60px;height:20px;display: inline"
                                       name="room_{{ $room->id}}_new_price" min="1" id="new_price" class="form-control"
                                       value="{{ $room->price_per_hour }}">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="col-md-12" style="overflow-x: scroll">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column"
                                   id="sample_1">
                                <thead>

                                <tr>
                                    <th style="font-size: 12px;" colspan="2">برنامه اتاق {{ $room->name }}</th>
                                    <th colspan="12" style="background-color: #F4C20B;color: white;">صبح</th>
                                    <th colspan="12" style="background-color: #1d4f8e;color: white;">بعداز ظهر</th>
                                </tr>

                                <tr>
                                    <th> روز</th>
                                    <th> تاریخ</th>
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
                                    <tr class="odd gradeX">
                                        <th> {{$dm}} </th>
                                        <th> {{ jalali_date(date_day_plus($set_week->start_date,$dmkey)) }} </th>
                                        @for($i=0;$i<24;$i++)
                                            <th class="box room_{{ $room->id }}" data-roomid="{{$room->id}}"
                                                data-day="{{$dmkey }}" data-hour="{{ $i }}"
                                                id="box_{{ $dmkey }}_{{ $i }}"></th>
                                        @endfor
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="col-xs-12 hidden-lg hidden-md">


                                <span class="badge badge-warning">برای دیدن باقی زمان ها به سمت چپ بکشید</span>


                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        @endforeach
        </section>
        </div>
@stop
