@extends('layout.user')

@push('top_scripts')
<link href="/assets/pages/css/blog-rtl.min.css" rel="stylesheet" type="text/css" />
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkQLW8Ypo634J3vfm3g1L-78qRnh8LjBQ"></script>--}}
<link href="/assets/global/plugins/leaflet/leaflet.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/star.css" rel="stylesheet" type="text/css" />
<style>
    .rsdiv{
        -webkit-overflow-scrolling: touch;
		overflow:scroll;

    }

</style>

@endpush

@push('bottom_scripts')
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

<!--
	<link href="http://demos.jquerymobile.com/1.3.0-beta.1/css/themes/default/jquery.mobile-1.3.0-beta.1.css" rel="stylesheet" />
	<link href="http://demos.jquerymobile.com/1.3.0-beta.1/docs/_assets/css/jqm-docs.css" rel="stylesheet" />
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://demos.jquerymobile.com/1.3.0-beta.1/docs/_assets/js/jqm-docs.js"></script>
	<script src="http://demos.jquerymobile.com/1.3.0-beta.1/js/jquery.mobile-1.3.0-beta.1.js"></script>


	-->

@endpush

@section('content')
    <!--
    <div class="row text-center">
        <div class="col-sm-12">

        </div>
    </div>

-->




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
                 <div class="col-md-12">
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
										<span>قیمت پایه: : </span> <span><b> {{ $room->price_per_hour }} {{'هزار تومان'}}</b></span><br/>
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


                                <div class="col-md-12 rsdiv" style="overflow-x: scroll">

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



                                                    <th> {{$start}}تا{{$end}} </th>

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
                            <input type="submit" class="btn btn-primary btn-small" value="ارسال ستاره" style="padding-bottom:3px;">
							 <div class="alert alert-success" style="padding-top:3px;">
                                    <strong>تا کنون {{$count}} نفر نظر داده اند</strong>@if($count==0) {{'شما اولین نفر باشید'}} @else  {{'شما نفر بعدی باشید'}}   @endif
                                </div>
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
<!-- END PAGE CONTENT INNER -->
@stop
