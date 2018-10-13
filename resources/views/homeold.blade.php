@extends('layout.user')
@push('top_css')
<link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/owl.theme.default.css') }}">
<link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="/assets/global/component/datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="/assets/global/component/bootstrap-select/bootstrap-select.css">

@endpush
@push('bottom_scripts')
<script src="{{ asset('/js/owl.carousel.min.js') }}"></script>

<script src="/assets/global/component/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/global/component/datepicker/bootstrap-datepicker.fa.js"></script>
<script src="/assets/global/component/bootstrap-select/bootstrap-select.js"></script>
<script src="/assets/global/component/bootstrap-select/fa.js"></script>
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

<div  style=" margin-top: 40px;" class="container">
<!--
<div class="alert alert-warning">
  <strong>توجه!</strong> باتوجه به وجود مشکل در درگاه پرداخت، چنانچه بعد ازرزرو مراکز و پرداخت وجه هزینه کسر گردیدو نتیجه نمایش داده نشد،برای اطمینان از رزرو قطعی مرکز با پشتیبانی تماس حاصل نمایید.
</div>
-->

<!----start-search-box----->

  <div class="row">
        <div class="col-md-12 search-box">

            <div class="row text-center">
                <form action="{{route("index.search")}}" method="GET" autocomplete="off">
                    <div class="col-sm-3">
                        <div class="form-group" style="text-align: center;">
                            <input style="height:46px;line-height:46px" type="text" name="name" class="form-control " placeholder="نام پلاتو مورد نظر">
                        </div>
                    </div>
                    <div class="col-sm-3 " style="direction:rtl;  padding-bottom: 15px;">
                        <div class="form-group-lg">
                            <select class="selectpicker form-control" name="attribute[]" multiple data-live-search="true" data-size="6" title="دنبال چه امکاناتی هستید؟">
                               <!--  <option value="{{''}}">همه مراکز را جست و جو کن</option>
                               -->
                                <optgroup label="امکانات">

                                    @foreach($center_attributes as $center_attribute)
                                        <option value="{{$center_attribute->id}}">{{$center_attribute->name}}</option>
                                    @endforeach

                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 " style="direction:rtl;  padding-bottom: 15px;">
                        <div class="form-group-lg">
                            <select class="selectpicker form-control" name="size" data-live-search="true" data-size="6" title="حداقل اندازه اتاق به متر مربع">
                                <option value="0">مهم نیست</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 ">
                        <button type="submit" class="btn btn-lg btn-danger" style="border-radius: 11px;">
                            <small>جست و جو</small>
                        </button>
                    </div>
                </form>
                <div class="col-sm-1" style="margin-top: 3px;">
                    <a class="btn btn-default" href="{{route('adv_searchpage')}}" style="border-radius: 10px;">
                        جستجو پیشرفته<span class="glyphicon glyphicon-search" style="font-size: 16px;height: 25px;"></span>
                    </a>
                </div>


            </div>


        </div>
    </div>

<!----end------->


<div class="row">
    <div class="col-md-12">
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

</div>
@stop
