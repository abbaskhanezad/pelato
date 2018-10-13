@extends('layout.user')
@push('top_css')
<link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/owl.theme.default.css') }}">
<link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
@endpush
@push('bottom_scripts')
<script src="{{ asset('/js/owl.carousel.min.js') }}"></script>
<script>
    $('.owl-carousel').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        nav:true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,

        responsive:{
            0:{
                items:1
            },
            @if($best_reserves->count()<=3)
            600:{
                items:3
            },
            @endif
            @if($best_reserves->count()>=4)
            1000:{
                items:4
            }
            @endif
        }
    })
</script>
@endpush
@section('content')
@include('layout.user.error')
<!--
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <!-- Wrapper for slides 
                <div class="carousel-inner" role="listbox">
                    <div class="item active"><img src="img/salon.jpg" alt="...">
                    </div>
                    <div class="item"><img src="img/meany-stage-pan-right.jpg" alt="...">
                    </div>
                    <div class="item"><img src="img/HEB 118 002large.jpg" alt="...">
                    </div>
                </div>
                <!-- Controls
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
-->
@if(!empty($best_reserves->toArray()))
<div class="clear margin-top-40"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-heading text-center">
                <h2>   برترین مراکز</h2>
            </div>
            <div class="owl-carousel owl-theme">
                @foreach($best_reserves as $best_reserve)
                        <div class="cbp-item-wrapper">
                            <a href="{{ route('center.show', ['reservable_center' => $best_reserve->id]) }}" class="cbp-caption" style="text-decoration: none">
                                <div class="cbp-caption-defaultWrap img-responsive" style="height: 200px;">
                                    <img class="img-responsive img-thumbnail" style="height:200px;" src="/images_thumb/{{ $best_reserve->image->picture }}" alt="">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignCenter">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title"> {{ $best_reserve->name }}</div>
                                            <div class="cbp-l-caption-desc">
                                                <span title="نوع مرکز"><i class="fa fa-tag"></i> {{$best_reserve->center_type->name}}<br></span>
                                                <span title="آدرس"><i class="fa fa-map-marker"></i> آدرس: {{ $best_reserve->address }} <br></span>
                                                <span title="تعداد اتاق"><i class="fa fa-bank"></i> تعداد اتاق ها: {{ $best_reserve->room->count() }}<br></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
<div  style=" margin-top: 40px;" class="container">
<!--
<div class="alert alert-warning">
  <strong>توجه!</strong> باتوجه به وجود مشکل در درگاه پرداخت، چنانچه بعد ازرزرو مراکز و پرداخت وجه هزینه کسر گردیدو نتیجه نمایش داده نشد،برای اطمینان از رزرو قطعی مرکز با پشتیبانی تماس حاصل نمایید.
</div>
-->




<div class="row">
        <h2 style="text-align: center;"><strong>چطوری از سایت پلاتو استفاده کنیم؟</strong></h2>
        </br>
        <div class="col-sm-3">
            <img style="text-align: center;" src="/img/1.png" class="img-responsive" alt="login" />
            </br>
            <h3 style="text-align: center;">1.در سایت <a style="color: #3366ff;" href="http://www.e.pelato.ir/register">ثبت نام</a> کن.</h3>
            <h5 style="text-align: center;">اگر قبلا ثبت نام کردی <a style="color: #3366ff;" href="http://www.e.pelato.ir/login">وارد شو</a>.</h5>
        </div>
        <div class="col-sm-3">
            <img style="text-align: center;" src="/img/2.png" class="img-responsive" alt="login" />
            </br>
            <h4 style="text-align: center;">2.به شماره تلفن همراهت پیام تایید ثبت نام ارسال می شه.</h4>
        </div>
        <div class="col-sm-3">
            <img style="text-align: center;" src="/img/3.png" class="img-responsive" alt="login" />
            </br>
            <h4 style="text-align: center;">3.کد تایید را در سایت وارد کن.</h4>
        </div>
        <div class="col-sm-3">

            <img style="text-align: center;" src="/img/4.png" class="img-responsive" alt="login" />
            </br>
            <h4 style="text-align: center;">4.حالا به راحتی می تونی مرکز مورد نظر خودت رو رزرو کنی.<a href="http://www.e.pelato.ir/centers">(لیست مراکز)</a></h4>
        </div>

    </div>

    </div>


</div>
@stop
