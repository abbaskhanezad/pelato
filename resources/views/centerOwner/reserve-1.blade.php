@extends('layout.admin')
@push('top_scripts')
<link href="/assets/pages/css/blog-rtl.min.css" rel="stylesheet" type="text/css" />
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkQLW8Ypo634J3vfm3g1L-78qRnh8LjBQ"></script>--}}
<link href="/assets/global/plugins/leaflet/leaflet.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/star.css" rel="stylesheet" type="text/css" />

<style>
    .rsdiv{
        -webkit-overflow-scrolling: touch;

    }

</style>
@endpush

@section('bottom_scripts')



    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/global/scripts/star.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/leaflet/leaflet.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/map-location-show.js"></script>

    <script src="/js/underscore-min.js" type="text/javascript"></script>
    <script>
        var week_id = {{ $weekid }};
        var room_list=[];
        var order_list=[];
        var room_timing = {!! $room_timing !!}
    @foreach($reservable_center->room as $room)
    room_list.push({id:{{ $room->id}},price:{{ $room->price_per_hour}}});
        @endforeach

    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/timing_show.js" type="text/javascript"></script>
    <script>
        if(document.getElementsByClassName('btn btn-info').length)
        {
            let timingSellable=document.getElementsByClassName('timing_sellable_user');
            for (let index = 0; index < timingSellable.length; index++) {
                timingSellable[index].onclick=function(){

                    alert('کاربر گرامی،برای رزرو آنلاین وارد حساب کاربری خود شوید.');
                }

            }
        }
    </script>


    <script>
        add_answer=function(id,name)
        {


            document.getElementById('answer').value=id;
            var msg='ارسال پاسخ به '+name;
            $("#abbas").html(msg);
            window.location='#add_comment';
        }
    </script>



@stop
@section('content')
    <div id="app">
        <section class="content">
            <div class="row">

                @php
                    $k=1;

                @endphp
<div style="overflow: scroll">
                @foreach($reservable_center->room as $room)



                    <div id="<?= 'br'.$k ?>" class="tab-pane fade @if($k==1) {{ 'in active'}} @endif">
                        <!---start-plate--->
                        <div class="row">
                            <div class="col-md-12 touch">
                                <!---start-box-room--->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">اتاق: {{ $room->name }}</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row" style="margin-bottom: 15px;">
                                            <div class="col-md-6">
                                                <span>اندازه: </span> <span><b> {{ $room->size }} متر مکعب </b></span><br/>
                                                <span>جنس کف: </span> <span><b> {{ $room->floor_type }} </b></span><br/>
                                                <span>جنس دیوار: </span> <span><b> {{ $room->wall_type }} </b></span><br/>
                                                @if ($room->sandali)
                                                    <span>تعداد صندلی : </span> <span><b> {{ $room->sandali }}نفر </b></span><br/>
                                                @endif
                                                @if(!empty($room->tags()->get()->toArray()))
                                                    <div class="blog-single-sidebar-tags">
                                                        <h4 class="caption-subject bold uppercase">ویژگی ها :</h4>
                                                        @foreach($room->tags()->get() as $tag)
                                                            <span class="badge badge-important"> {{ $tag->name }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-4" style="float: left;">
                                                @if(count($room->image)>0)
                                                    <div id="slideshow-{{$room->id}}" class="carousel slide" data-ride="carousel">
                                                        <!-- Indicators -->
                                                        <ol class="carousel-indicators">
                                                            @foreach($room->image as $kimg => $image)
                                                                <li data-target="#slideshow-{{$room->id}}" data-slide-to="{{ $kimg }}" class="active"></li>
                                                            @endforeach
                                                        </ol>

                                                        <!-- Wrapper for slides -->
                                                        <div class="carousel-inner" role="listbox">
                                                            @foreach($room->image as $kimg => $image)
                                                                <div class="item @if($kimg == 0)  active @endif">
                                                                    <img src="/images/{{ $image->picture}}">
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- Left and right controls -->
                                                        <a class="right carousel-control" href="#slideshow-{{$room->id}}" role="button" data-slide="prev">
                                                            <i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i>
                                                            <span class="sr-only">قبلی</span>
                                                        </a>
                                                        <a class="left carousel-control" href="#slideshow-{{$room->id}}" role="button" data-slide="next">
                                                            <i class="glyphicon glyphicon-chevron-left" aria-hidden="true"></i>
                                                            <span class="sr-only">بعدی</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-md-12 touch hidden-lg hidden-md">

                                            <table class=" table table-striped table-bordered table-hover table-checkable order-column" id="sample_1" style=" display: block;">
                                                <!--
                                                  <div class="col-md-12">

                                                   <table class="ui-responsive table-stroke table table-striped table-hover table-bordered" data-mode="reflow" data-role="table" id="movie-table">
                                                  -->
                                                <thead>

                                                <tr>
                                                    <th style="font-size: 12px;" colspan="2">برنامه اتاق {{ $room->name }}</th>
                                                    <th colspan="12" style="background-color: #F4C20B;color: white;">صبح</th>
                                                    <th colspan="12" style="background-color: #1d4f8e;color: white;">بعداز ظهر</th>
                                                </tr>

                                                <tr>
                                                    <th> روز</th>
                                                    <th>تاریخ</th>
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
                                                        @if(compare_with_today(date_day_plus($set_week->start_date,$dmkey)))
                                                            @for($i=0;$i<24;$i++)
                                                                <th class="box room_{{ $room->id }} timing_unsellable" data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                            @endfor
                                                        @else
                                                            @if(is_today(date_day_plus($set_week->start_date,$dmkey)))
                                                                @for($i=0;$i<24;$i++)
                                                                    @if(compare_with_now($i))
                                                                        <th class="box room_{{ $room->id }} timing_unsellable" data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                    @else
                                                                        <th class="box room_{{ $room->id }} " data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($i=0;$i<24;$i++)
                                                                    <th class="box room_{{ $room->id }} " data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                @endfor
                                                            @endif
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>



                                            <div class="col-xs-12 hidden-lg hidden-md">


                                                <span class="badge badge-warning">برای دیدن باقی زمان ها به سمت چپ بکشید</span>


                                            </div>

                                        </div>

                                        <div class="col-lg-12 touch hidden-sm hidden-xs">

                                            <table class=" table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                <!--
                                                  <div class="col-md-12">

                                                   <table class="ui-responsive table-stroke table table-striped table-hover table-bordered" data-mode="reflow" data-role="table" id="movie-table">
                                                  -->
                                                <thead>

                                                <tr>
                                                    <th style="font-size: 12px;" colspan="2">برنامه اتاق {{ $room->name }}</th>
                                                    <th colspan="12" style="background-color: #F4C20B;color: white;">صبح</th>
                                                    <th colspan="12" style="background-color: #1d4f8e;color: white;">بعداز ظهر</th>
                                                </tr>

                                                <tr>
                                                    <th> روز</th>
                                                    <th>تاریخ</th>
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
                                                        @if(compare_with_today(date_day_plus($set_week->start_date,$dmkey)))
                                                            @for($i=0;$i<24;$i++)
                                                                <th class="box room_{{ $room->id }} timing_unsellable" data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                            @endfor
                                                        @else
                                                            @if(is_today(date_day_plus($set_week->start_date,$dmkey)))
                                                                @for($i=0;$i<24;$i++)
                                                                    @if(compare_with_now($i))
                                                                        <th class="box room_{{ $room->id }} timing_unsellable" data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                    @else
                                                                        <th class="box room_{{ $room->id }} " data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($i=0;$i<24;$i++)
                                                                    <th class="box room_{{ $room->id }} " data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                                                @endfor
                                                            @endif
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>



                                            <div class="col-xs-12 hidden-lg hidden-md">


                                                <span class="badge badge-warning">برای دیدن باقی زمان ها به سمت چپ بکشید</span>


                                            </div>

                                        </div>

                                        <!--jaye sabegh -->



                                        <div style="clear: both;"></div>
                                    </div>



                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->


                                <!--end-box-room-->

                            </div>

                        </div>



                        <!---end_plate--->

                    </div>




                    @php
                        $k=$k+1;
                    @endphp
                @endforeach
</br>

</div>

            </div>


            <!----end-navs---->


            @if(isset(Auth::user()->id))

                <div class="row" style="padding-button:10px;margin:1px;">
                    <form method="get" id="order_form" action="/order/set">
                        <input type="hidden" name="order_list" value="">
                        <div class="row" style="text-align:center;">
                            <button class="btn btn-lg  btn-success" id="room_timing_reserve" type="button" style="width: 30%;margin-bottom: 15px;">رزرو</button>
                        </div>
                    </form>
                </div>
        @endif



        @foreach($reservable_center->room as $room)

        @endforeach

        {{--@endif--}}


    </div>
    </div>





    @if(!isset(Auth::user()->id))

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">رزرو اتاق</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <p>جهت رزرو اتاق بایستی ابتدا <a href="/login">وارد</a> شوید.
                        <br>
                        اگر هنوز ثبت نام نکرده اید از <a href="/register">اینجا</a> اقدام کنید.
                    </p>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        @endif






        </div>
        </section>
    </div>
@endsection



