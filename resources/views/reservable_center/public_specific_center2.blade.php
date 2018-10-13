@extends('layout.user')

@push('top_scripts')
<link href="/assets/pages/css/blog-rtl.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkQLW8Ypo634J3vfm3g1L-78qRnh8LjBQ"></script>

@endpush

@push('bottom_scripts')
@if($reservable_center->google_map_lat)
<script>
var lat = {{$reservable_center->google_map_lat}};
var lon = {{$reservable_center->google_map_lon}};
</script>
@endif
<script type="text/javascript" src="/js/map-location-show.js"></script>


<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<?php //<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> ?>
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
<script src="/js/timing_show.js" type="text/javascript"></script>
@endpush

@section('content')
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
                    @if(!empty($reservable_center->image))
                    <div class="blog-single-img">
                      <img src="/images/{{ $reservable_center->image->picture }}" />
                    </div>
                    @endif
                    <div class="blog-single-desc">
                        <p>{!!$reservable_center->description!!}</p>
                    </div>
                    <?php /*
                    <div class="blog-single-foot">
                        <ul class="blog-post-tags">
                            <li class="uppercase">
                                <a href="javascript:;">Bootstrap</a>
                            </li>
                            <li class="uppercase">
                                <a href="javascript:;">Sass</a>
                            </li>
                            <li class="uppercase">
                                <a href="javascript:;">HTML</a>
                            </li>
                        </ul>
                    </div>
                    <div class="blog-comments">
                        <h3 class="sbold blog-comments-title">Comments(30)</h3>
                        <div class="c-comment-list">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" alt="" src="../assets/pages/img/avatars/team1.jpg"> </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">Sean</a> on
                                        <span class="c-date">23 May 2015, 10:40AM</span>
                                    </h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" alt="" src="../assets/pages/img/avatars/team3.jpg"> </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">Strong Strong</a> on
                                        <span class="c-date">21 May 2015, 11:40AM</span>
                                    </h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object" alt="" src="../assets/pages/img/avatars/team4.jpg"> </a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="#">Emma Stone</a> on
                                                <span class="c-date">30 May 2015, 9:40PM</span>
                                            </h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>
                                    </div>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" alt="" src="../assets/pages/img/avatars/team7.jpg"> </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">Nick Nilson</a> on
                                        <span class="c-date">30 May 2015, 9:40PM</span>
                                    </h4> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. </div>
                            </div>
                        </div>
                        <h3 class="sbold blog-comments-title">Leave A Comment</h3>
                        <form action="#">
                            <div class="form-group">
                                <input type="text" placeholder="Your Name" class="form-control c-square"> </div>
                            <div class="form-group">
                                <input type="text" placeholder="Your Email" class="form-control c-square"> </div>
                            <div class="form-group">
                                <input type="text" placeholder="Your Website" class="form-control c-square"> </div>
                            <div class="form-group">
                                <textarea rows="8" name="message" placeholder="Write comment here ..." class="form-control c-square"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn blue uppercase btn-md sbold btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                    */ ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-single-sidebar bordered blog-container">
                    <div>
                      <div id="map" style="width: 100%;height:200px;"></div>
                    </div>
                    <div>
                      <i class="fa fa-location-arrow"></i> {{ $reservable_center->address }}
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
                    <?php /*
                    <div class="blog-single-sidebar-links">
                        <h3 class="blog-sidebar-title uppercase">Useful Links</h3>
                        <ul>
                            <li>
                                <a href="javascript:;">Lorem Ipsum </a>
                            </li>
                            <li>
                                <a href="javascript:;">Dolore Amet</a>
                            </li>
                            <li>
                                <a href="javascript:;">Metronic Database</a>
                            </li>
                            <li>
                                <a href="javascript:;">UI Features</a>
                            </li>
                            <li>
                                <a href="javascript:;">Advanced Forms</a>
                            </li>
                        </ul>
                    </div>
                    <div class="blog-single-sidebar-ui">
                        <h3 class="blog-sidebar-title uppercase">UI Examples</h3>
                        <div class="row ui-margin">
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/1.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/37.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/57.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/53.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/59.jpg" />
                                </a>
                            </div>
                            <div class="col-xs-4 ui-padding">
                                <a href="javascript:;">
                                    <img src="../assets/pages/img/background/42.jpg" />
                                </a>
                            </div>
                        </div>
                    </div>
                    */ ?>
                </div>
            </div>
        </div>
        @if(isset(Auth::user()->id))
        <div class="row">
          <div class="col-md-12">
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
              <div class="portlet light ">
                  <div class="portlet-title">
                      <div class="caption font-dark">
                          <i class="icon-settings font-dark"></i>
                          <span class="caption-subject bold uppercase">رزرو اتاق برای
                            <span class="week_title">
                              @if($set_week > $current_week)
                              <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id - 1 }}"><i class="fa fa-chevron-right" title="هفته قبل"></i></a>
                              @endif
                              {{ $lingual_set_week }}
                              <a href="/centers/{{ $reservable_center->id}}/week/{{ $set_week->id + 1 }}"><i class="fa fa-chevron-left" title="هفته بعد"></i></a>
                            </span>
                          </span>
                      </div>
                  </div>
                  <div class="portlet-body">
                    <p>در ذیل اتاقهای مرکز قابل مشاهده هستند. ساعات قابل رزرو هر اتاق به رنگ خاکستری نشان داده می شوند. با کلیک بر ساعات مورد نظر
                    ، آن ساعت به رنگ آبی در می آید و می توانید با فشردن دکمه رزرو به مرحله تایید و پرداخت ساعات رزرو مورد نظرتان بروید.</p>
                  </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>

        @foreach($reservable_center->room as $room)
        <div class="row">
          <div class="col-md-12">
              <!-- BEGIN EXAMPLE TABLE PORTLET-->
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

                        </div>
                        <div class="col-md-6">
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
                      <div class="col-md-12" style="overflow-x: scroll">
                      <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                          <thead>
                              <tr>
                                  <th> روز</th>
                                  <th> تاریخ </th>
                                  @for($i=0;$i<24;$i++)
                                  <th> {{$i}} </th>
                                  @endfor
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($day_mapper as $dmkey => $dm)
                              <tr class="odd gradeX">
                                <th> {{$dm}} </th>
                                <th> {{ jalali_date(date_day_plus($set_week->start_date,$dmkey)) }} </th>
                                @for($i=0;$i<24;$i++)
                                <th class="box room_{{ $room->id }}" data-roomid="{{$room->id}}" data-day="{{$dmkey }}" data-hour="{{ $i }}" id="box_{{ $dmkey }}_{{ $i }}"> </th>
                                @endfor
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                    <div style="clear: both;"></div>
                  </div>
              </div>
              <!-- END EXAMPLE TABLE PORTLET-->
          </div>
        </div>
        @endforeach

        @endif


    </div>
</div>
@if(isset(Auth::user()->id))
<form method="post" id="order_form" action="/order/set">
  {{csrf_field() }}
  <input type="hidden" name="order_list" value="">
  <button class="btn btn-lg pull-right btn-success" id="room_timing_reserve" type="button">رزرو</button>
</form>
@else
<div class="row">
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
            <br/>
            اگر هنوز ثبت نام نکرده اید از <a href="/register">اینجا</a> اقدام کنید.
            </p>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
@endif

<!-- END PAGE CONTENT INNER -->
@stop
