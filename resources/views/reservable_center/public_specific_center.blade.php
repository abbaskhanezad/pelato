@extends('layout.user')

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
    @if($reservable_center->google_map_lat)
        <script>
            var lat = {{$reservable_center->google_map_lat}};
            var lon = {{$reservable_center->google_map_lon}};
        </script>
    @endif

    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/global/scripts/star.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/leaflet/leaflet.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/map-location-show.js"></script>

    <script src="/js/underscore-min.js" type="text/javascript"></script>
    <script>
        var week_id = {{ $current_week->id }};
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
    <!--
    <div class="row text-center">
        <div class="col-sm-12">

        </div>
    </div>

-->

    @php
        use \App\Jdf;
     $jdf=new Jdf();
    @endphp




    @if(count($center_discounts)>0)
        <div class="alert alert-warning text-center" style="font-weight: bold;" >
            @foreach($center_discounts as $cd)

                {!!
                '<div>'.
                            '  هم اکنون کد تخفیف'.'<span class="label label-success">'. $cd->discounts_name.'</span>'. ' با '.'<span class="badge">'.$cd->discounts_value.'</span>' .' درصد تخفیف برای این مرکز فعال می باشد '


              .'</div>'

                !!}

            @endforeach

        </div>

    @endif


    @if(count($pelato_public)>0)
        <div class="alert alert-warning text-center" style="font-weight: bold;" >
            @foreach($pelato_public as $cd)

                {!!
                '<div>'.
                            '  هم اکنون کد تخفیف'.'<span class="label label-success">'. $cd->discounts_name.'</span>'. ' با '.'<span class="badge">'.$cd->discounts_value.'</span>' .' درصد تخفیف برای این مرکز فعال می باشد '


              .'</div>'

                !!}

            @endforeach

        </div>

    @endif




    @if(count($pelato_disconts)>0)
        <div class="alert alert-info text-center" style="font-weight: bold;" >
            @foreach($pelato_disconts as $cd)

                {!!
                '<div>'.
                            '  هم اکنون کد تخفیف'.'<span class="label label-success">'. $cd->discounts_name.'</span>'. ' با '.'<span class="badge">'.$cd->discounts_value.'</span>' .' درصد تخفیف از طرف سایت پلاتو برای این مرکز فعال می باشد.  '


              .'</div>'

                !!}

            @endforeach
        </div>

    @endif











    @if(session()->has('msg'))

        <div class="alert alert-{{session('type')}}" >
            {{session('msg')}}
        </div>
    @endif


    <?php
    use App\Starrating;

    ?>
    @include('layout.user.error')
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="page-content-inner">
        <div class="blog-page blog-content-2">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-single-content bordered blog-container">
                        <div class="blog-single-head">
                            <h1 class="blog-single-head-title">{{ $reservable_center->name }}</h1>

                        </div>
                        <!---starrating--->
                    <!--
                        <div class="row">
                            <div class="col-md-5 text-center">
                                <p class="rating-input" style="direction: rtl;">
                                    <?php
                    // $star=round(Starrating::where('center_id',$reservable_center->id)->avg('star'));
                    $nezafat=round(Starrating::where('center_id',$reservable_center->id)->avg('nezafat'));
                    $tajhizat=round(Starrating::where('center_id',$reservable_center->id)->avg('tajhizat'));
                    $khadamat=round(Starrating::where('center_id',$reservable_center->id)->avg('khadamat'));
                    $star=floor(($nezafat+$khadamat+$tajhizat)/3);
                    $count=Starrating::where('center_id',$reservable_center->id)->count();
                    // echo $reservable_center->id;
                    // $star=3;
                    ?>
                            <span style="font-size: large; font-weight: bold;">میانگین امتیازات این مرکز:</span>
                            @for($r=0;$r<5;$r++)

                        @if($r<$star)
                            <span style="font-size: large; font-weight: bold;" data-value="{{$r}}" class="fa fa-star check"></span>
                                        @else
                            <span  style="font-size: large; font-weight: bold;" data-value="{{$r}}" class="fa fa-star-o"></span>
                                        @endif
                    @endfor

                            </p>
                        </div>

                        <div class="col-md-2" style="padding-top: 8px;">
                            <span type="button" class="btn btn-success">    تعداد کل آرا  <span class="badge">{{$count}}</span></span>
                            </div>

                            <div class="col-md-5" style="padding-top: 5px;">
                                <div class="alert alert-success text-center">
                                    <p style="font-size: 12px;"><a href="#end"> برای امتیاز دهی به این مرکز کلیک کنید</a></p>
                                </div>
                            </div>
                        </div>

                        -->

                        <div class="row">
                            <div class="col-md-7">
                                <p class="rating-input" style="direction: rtl;">
                                    <?php
                                    // $star=round(Starrating::where('center_id',$reservable_center->id)->avg('star'));
                                    $nezafat=round(Starrating::where('center_id',$reservable_center->id)->avg('nezafat'));
                                    $tajhizat=round(Starrating::where('center_id',$reservable_center->id)->avg('tajhizat'));
                                    $khadamat=round(Starrating::where('center_id',$reservable_center->id)->avg('khadamat'));
                                    $star=floor(($nezafat+$khadamat+$tajhizat)/3);
                                    $count=Starrating::where('center_id',$reservable_center->id)->count();
                                    // echo $reservable_center->id;
                                    // $star=3;
                                    ?>
                                    <span style="font-size: large; font-weight: bold;">میانگین امتیازات این مرکز:</span>
                                    @for($r=0;$r<5;$r++)

                                        @if($r<$star)
                                            <span style="font-size: large; font-weight: bold;" data-value="{{$r}}" class="fa fa-star check"></span>
                                        @else
                                            <span  style="font-size: large; font-weight: bold;" data-value="{{$r}}" class="fa fa-star-o"></span>
                                        @endif
                                    @endfor

                                    {{'('}}
                                    {{'از    '}}{{$count}}{{'  رای'}}
                                    {{')'}}

                                </p>

                            </div>
                        <!--

                            <div class="col-md-2" style="padding-top: 8px;">
                                <span type="button" class="btn btn-success">    تعداد کل آرا  <span class="badge">{{$count}}</span></span>
                            </div>



							<div class="col-md-2" style="padding-top: 8px;">
							{{'('}}
                        {{'از    '}}{{$count}}{{'  رای'}}
                        {{')'}}

                                </div>
                                -->

                            <div class="col-md-5" style="padding-top: 5px;">
                                <div class="alert alert-success text-center">
                                    <p style="font-size: 12px;"><a href="#end"> برای امتیاز دهی به این مرکز کلیک کنید</a></p>
                                </div>
                            </div>
                        </div>

                        <!---end-starrating--->
                        @if(!empty($reservable_center->image))
                            <div class="blog-single-img">
                                <img src="/images/{{ $reservable_center->image->picture }}" />
                            </div>
                        @endif
                        <div class="blog-single-desc">
                            <p>{!!$reservable_center->description!!}</p>
                        </div>


                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-single-sidebar bordered blog-container">
                        <div style="margin-bottom: 25px;">
                            <div id="map" style="width: 100%;height:200px;"></div>
                        </div>
                        <div>
                            <i class="fa fa-map-marker"></i> {{ $reservable_center->address }}
                        </div>
                        <div class="blog-single-sidebar-tags">
                            <h3 class="blog-sidebar-title uppercase">ویژگی ها</h3>
                            <ul class="blog-post-tags">
                                @foreach($reservable_center->center_attribute as $ca)
                                    <li class="uppercase">
                                        <a href="javascript:;"> {{ $ca->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        {{--@if(isset(Auth::user()->id))--}}



        <!---navs---->
            <div class="row">

            </div>
        </div>


        <div class="row" style="padding: 10px;">

            <div class="col-md-2" style="display: inline-block; margin: 10px; ">
                   <span style="font-weight: bold;font-size: 25px;">
                         لیست اتاق ها
                   </span>


            </div>
            <div class="col-md-10" style="display: inline-block; margin: 10px;">

                <span class="glyphicon glyphicon-calendar"></span>
                <span class="caption-subject bold uppercase">برنامه ی:
                            <span class="week_title">
                              @if($set_week > $current_weekM6)
                                    <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id - 1 }}"><i class="glyphicon glyphicon-hand-left" style="font-size: 25px;" title="هفته قبل"></i></a>
                                @endif
                                {{ $lingual_set_week }}
                                <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id + 1 }}"><i class="glyphicon glyphicon-hand-right" style="font-size: 25px;" title="هفته بعد"></i></a>
                            </span>
                          </span>

            </div>

        </div>


        @php
            $i=1;
        @endphp
        <ul class="nav nav-tabs">
            @foreach($reservable_center->room as $room)


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


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">

                <div class="portlet-title">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    توضیحات


                <!--
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">رزرو اتاق برای
                            <span class="week_title">
                              @if($set_week > $current_weekM6)
                    <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id - 1 }}"><i class="glyphicon glyphicon-hand-left" title="هفته قبل"></i></a>
                              @endif
                {{ $lingual_set_week }}
                        <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id + 1 }}"><i class="glyphicon glyphicon-hand-right" title="هفته بعد"></i></a>
                            </span>
                          </span>
                        </div>
                   -->
                </div>
                <div class="portlet-body">
                    <p style="text-align: right;">در بخش فوق میتوانید زمان های خالی و اطلاعات اتاق های این مرکز را مشاهده کنید.<br />

                        <span style="color: #00ccff;">توجه</span>:
                        <br>
                        ساعاتی که به رنگ                        <span style="color: #ff0000;">قرمز</span>نشان داده شده است قابل رزرو نیستند.
                    </p>
                    <p style="text-align: right;"><span style="color: #ff0000;">توضیحات</span>: ساعاتی که به رنگ سبز نمایش داده شده قابل رزرو می باشد و شما با کلیک بر روی ساعات مورد نظر و فشردن کلمه ی رزرو در انتهای صفحه میتوانید به مرحله ی تایید و پرداخت ساعات رزرو مورد نظرتان بروید.</p>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <div  id="end" class="row">
        <div class="col-md-12">
            <div class="row etc-row2" style="text-align: center; font-weight: bold;font-size: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading">امتیاز دهی به مرکز</div>
                    <div class="panel-body">
                        <form action="{{ url('addstar') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label style="font-weight:bold;padding: 5px;">نظافت:</label>
                                <div class="star-rating1">
                                    <span class="fa fa-star-o" data-rating="1"></span>
                                    <span class="fa fa-star-o" data-rating="2"></span>
                                    <span class="fa fa-star-o" data-rating="3"></span>
                                    <span class="fa fa-star-o" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                    <input type="hidden" name="nezafat" class="rating-value1" value={{$nezafat}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  style="font-weight:bold;padding: 5px;">تجهیزات:</label>
                                <div class="star-rating2">
                                    <span class="fa fa-star-o" data-rating="1"></span>
                                    <span class="fa fa-star-o" data-rating="2"></span>
                                    <span class="fa fa-star-o" data-rating="3"></span>
                                    <span class="fa fa-star-o" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                    <input type="hidden" name="tajhizat" class="rating-value2" value={{$tajhizat}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  style="font-weight:bold;padding: 5px;">خدمات دهی:</label>
                                <div class="star-rating3">
                                    <span class="fa fa-star-o" data-rating="1"></span>
                                    <span class="fa fa-star-o" data-rating="2"></span>
                                    <span class="fa fa-star-o" data-rating="3"></span>
                                    <span class="fa fa-star-o" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                    <input type="hidden" name="khadamat" class="rating-value3" value={{$khadamat}}>
                                    <input type="hidden" name="center_id"  value="{{$reservable_center->id}}">
                                </div>
                            </div>
                            @if(Auth::check())
                                <input type="submit" class="btn btn-primary btn-small" value="ارسال ستاره">
                            @else
                                <div class="alert alert-warning">
                                    <strong>هشدار!</strong> برای نظردهی لطفا لاگین نمایید.
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-----------start-comment----->

    <div  id="end" class="row" style="padding-top: 20px;">
        <div class="col-md-12">
            <div class="row etc-row2" style="text-align: center; font-weight: bold;font-size: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading">نظرات کاربران</div>
                    <div class="panel-body">



                        <!-----show-comment--->

                        <div style="direction:rtl;">
                            <div style="width:100%;background:#ffffff;margin-top:10px;">
                                @if($Comment->count()>0)

                                    @foreach($Comment as $key=>$value)
                                        <div style="margin:auto;width:98%;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.15);border-radius: 20px">
                                            <div style="height: 37px;line-height: 37px;background: #e8e9eb;padding: 0 2px;border-radius: 2px 2px 0 0;font-size:12px;"><span>ارسال شده توسط : </span> <span>{{ $value['name'] }}</span><span> - </span> {{ $jdf->jdate('Y/n/j',$value['time']) }}</div>

                                            <div style="color: #555555;background: #f5f6f7;padding: 17px 15px 23px;font-size:14px;line-height: 25px;">

                                                {!! nl2br(strip_tags($value['comment'])) !!}



                                                <?php
                                                $parent=\App\Comment::where(['parent_id'=>$value['id'],'state'=>1])->orderBy('id','DESC')->get()->toArray();
                                                ?>
                                            </div>
                                            @foreach($parent as $key1=>$value1)

                                                <div style="width:92%;margin:auto">

                                                    <p style="font-size:10px;padding-top:15px;color: #3FB8AF"><span>ارسال شده توسط : </span> <span>{{ $value1['name'] }}</span><span> - </span>{{ $jdf->jdate('Y/n/j',$value1['time']) }}</p>
                                                    <div style="width:100%;margin-top:5px;border:1px solid #eeeff1;"></div>
                                                    <div style="font-size:12px;padding-top:10px;padding-bottom:10px; direction: rtl;">{!! nl2br(strip_tags($value1['comment'])) !!}</div>
                                                </div>
                                            @endforeach


                                        </div>
                                        <div style="width:98%;margin:auto"><p style="padding-right:10px;color:red;font-size:13px;padding-top:2px;cursor:pointer;padding-bottom:10px;" onclick="add_answer('<?= $value['id'] ?>','<?= $value['name'] ?>')">ارسال پاسخ به اين نظر</p></div>

                                    @endforeach

                                    <div style="width:100%;height:40px;background:#ffffff;padding-right:15px">{{ $Comment->render() }}</div>
                                @else
                                    <p style="color:red;text-align:center;padding-top:0px;padding-bottom:50px;">تا کنون نظری برای این مرکز ثبت نشده است</p>
                                @endif



                                <div style="padding-top:20px;"></div>


                            </div>
                        </div>

                        <!--------end------>





                        <!--Send-comment----->
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div id="add_comment" class="text-center" style="margin-top:50px; ">
                                <!--
                                <form method="post" action="{{ url('user/add_comment') }}">
                                    <table>
                                        {{ csrf_field() }}
                                        <input type="hidden" name="center_id" value="{{$reservable_center->id }}">
                                <input type="hidden" name="parent_id" value="0" id="answer" />
                                <tr>
                                    <td colspan="2"><p style="padding-right:30px;" id="answer_box">
                                            @if(Session::has('create'))
                                    {{ 'نظر شما با موفقيت ثبت و بعد از تاييد مدير سايت نمايش داده خواهد شد' }}
                                @endif
                                        </p></td>
                                </tr>
                                <tr>
                                    <td><input value="{{ old('name') }}"  class="form-control" type="text" name="name" required="required" placeholder="نام" style="border:1px solid #eeeff1;font-size:13px;margin-right:30px;height:30px;width:300px;margin-top:20px;padding-right:15px;font-family:Yekan;margin-left:0px; background:transparent;background-color:#F8F9FF " ></td>
                                    <td>
                                        @if($errors->has('name'))
                                    <span style="color:#ff0000;">{{ $errors->first('name') }}</span>
                                        @endif
                                        </td>
                                    </tr>

                                    <tr>

                                        <td>
                                            <input type="text" name="email" value="{{ old('email') }}"  class="form-control" placeholder="ايميل" required="required" style="border:1px solid #eeeff1;font-size:13px;margin-right:30px;height:30px;width:300px;margin-top:20px;padding-right:15px;font-family:Yekan; background:transparent;background-color:#F8F9FF" >
                                    </td>
                                    <td>
                                        @if($errors->has('email'))
                                    <span style="color:#ff0000">{{ $errors->first('email') }}</span>
                                        @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><textarea name="comment" class="form-control" rows="5" cols="2" required="required" style="border:1px solid #eeeff1;margin-right:30px;font-size:13px;margin-top:20px;padding-right:15px;font-family:Yekan;background-color:#f8f9ff;  background:transparent;" placeholder="نظر شما">{{ old('comment') }}</textarea></td>
                                </tr>

                                <tr>
                                    <td colspan="2">@if($errors->has('comment'))
                                    <span style="color:#ff0000;padding-right:30px;">{{ $errors->first('comment') }}</span>
                                        @endif</td>
                                </tr>


                                <tr>
                                    <td colspan="2"><input class="btn btn-success" type="submit" style="background:#62b965;border:1px solid #62b965;font-size:13px;font-family:Yekan;color:#ffffff;width:100px;margin-right:30px;margin-top:20px;margin-bottom:20px;" value="ثبت نظر"></td>
                                </tr>
                            </table>
                        </form>
-->
                                    <div  style="padding: 10px;">
                                        <p id="abbas" style="color:darkred"></p>

                                    </div>
                                    <form method="post" action="{{ url('user/add_comment') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="center_id" value="{{$reservable_center->id }}">
                                        <input type="hidden" name="parent_id" value="0" id="answer" />
                                        <div class="form-group">
                                            <label for="name"><span style="padding:4px;" class="glyphicon glyphicon-user"></span>نام:</label>
                                            <input type="text" class="form-control" id="name" required="required" placeholder=" نام خود را وارد نمایید" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @else value=""  @endif>
                                            @if($errors->has('name'))
                                                <span style="color:#ff0000">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1"><span style="padding:4px;" class="glyphicon glyphicon-comment"></span>نظر: </label>
                                            <textarea class="form-control" name="comment" id="comment" rows="3" required="required" placeholder="نظر خود را واردنمایید"></textarea>
                                            @if($errors->has('comment'))
                                                <span style="color:#ff0000">{{ $errors->first('comment') }}</span>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-success">ثبت نظر</button>
                                    </form>




                                </div>
                            </div>
                        </div>

                        <!---end--------->




                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-----------------end------->

    <!-- END PAGE CONTENT INNER -->
@stop
