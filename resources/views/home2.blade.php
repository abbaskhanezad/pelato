@extends('layout.user')
@push('top_css')
<link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/owl.theme.default.css') }}">
<link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="/assets/global/component/datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="/assets/global/component/bootstrap-select/bootstrap-select.css">

@endpush
@push('bottom_scripts')
<script src="/assets/global/component/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/global/component/datepicker/bootstrap-datepicker.fa.js"></script>
<script src="/assets/global/component/bootstrap-select/bootstrap-select.js"></script>
<script src="/assets/global/component/bootstrap-select/fa.js"></script>

    <style>
        .banner-fit {
            min-height: 350px;
        }
        .banner-fit {
            position: absolute;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            background-color: rgba(166, 163, 185, 0.5);
        }

        .search-box{
            font-size:9px!important;
        }
        .form-control {
            border-radius: 5px;
            font-size: 14px!important;
            box-shadow: none;
            border-color: #d2d6de;
            text-align: right;
        }
        .filter-option{
            border-radius: 5px;
            font-size: 12px;
            text-align: center!important;
        }
    </style>

<script>

    $(window).load(function(){
        $("#advsearch").hide();
    });

    $(document).ready(function(){
        $("#hs").click(function(){
			alert('hi');


                $('#advsearch, #simplesearch').toggle(400);


        });
    });



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

<!----start-search-box----->

    <div class="row">
        <div class="col-xs-12  col-md-2 col-md-offset-5 text-center"  style="padding: 20px;">
            <button class="btn btn-info" id="hs">جستجو ساده / جستحو پیشرفته</button>

        </div>
    </div>



    <div class="row" id="simplesearch" >
        <div class="panel panel-success">
            <div class="panel-heading text-center">   جســـتجــوی ساده  <span class="glyphicon glyphicon-search"></span></div>
            <div class="panel-body" >

                <form action="{{route("index.search")}}" method="GET" autocomplete="off">
                    <div class="col-sm-4">
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

                    <div class="col-sm-2 text-center ">
                        <button type="submit" class="btn btn-lg btn-success" style="border-radius: 11px;">
                            <small>جست و جو</small>
                        </button>
                    </div>

                </form>


            </div>
        </div>
    </div>


    <div class="row" id="advsearch" >
        <div class="panel panel-success">
            <div class="panel-heading text-center">   جســـتجــوی پیـشـــرفتــه  <span class="glyphicon glyphicon-search"></span></div>
            <div class="panel-body">
                <form action="{{route("index.adv_search")}}" method="GET" autocomplete="off">

                    <div class="row"  style="padding-bottom: 20px;padding-top: 20px;">


                        <div class="col-xs-4">
                            <div class="form-group" style="text-align: center;">
                                <label for="rooz"> روز مورد نظر </label>

                                <input type="text" placeholder="انتخاب روز" class="form-control" value="{{$today_date}}" name="rooz" id="datepicker" >
                                @if ($errors->has('rooz'))
                                    <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('rooz') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>


                        <div class="col-xs-4 ">
                            <div class="form-group">
                                <label for="time"> از ساعت  </label>

                                <div  id='datetimepicker3' data-align="top" data-autoclose="true" >

                                    <input   name="time" type="time" class="form-control" value={{date('H:i', strtotime('+3 hours'))}} required>
                                    @if ($errors->has('time'))
                                        <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('time') }}</strong>
                                        </span>
                                    @endif

                                </div>


                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="time"> تا ساعت   </label>

                                <div   id='datetimepicker3' data-align="top" data-autoclose="true" >

                                    <input   name="endtime" type="time" class="form-control" value='23:00' required>
                                    @if ($errors->has('endtime'))
                                        <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('endtime') }}</strong>
                                        </span>
                                    @endif

                                </div>


                            </div>
                        </div>



                    </div>
                    <div class="row"  style="padding-bottom: 20px;padding-top: 20px;">
                        <div class="col-xs-6 " style="direction:rtl;">
                            <div class="form-group">
                                <label for="money"> حداکثر مبلغ مورد نظر  </label>


                                <input type="number" class="form-control" placeholder="مبلغ به تومان" name="money" min="1000" value="10000"  step="1000">
                                @if ($errors->has('money'))
                                    <span class="help-block" style="color: red;">
                                            <strong>{{ $errors->first('money') }}</strong>
                                        </span>
                                @endif

                                <small class="bg-danger">مبلغ را به تومان وارد کنید</small>


                            </div>

                        </div>
                        <div class="col-xs-6">
                            <div class="form-group" style="text-align: center;">
                                <label for="name">  نام پلاتو مورد نظر  </label>

                                <input  type="text" name="name" class="form-control " placeholder="نام پلاتو مورد نظر">
                            </div>
                        </div>
                    </div>


                    <div class="row" style="padding-bottom: 20px; margin-left: 3px; margin-right: 3px;">

                        <div class="row text-center">

                            <div class="col-xs-6 ">
                                <div class="form-group-lg">
                                    <label for="attribute">  امکانات مورد نظر     </label>

                                    <select class="selectpicker form-control" name="attribute[]" multiple data-live-search="true" data-size="6" title="انتخاب  امکانات ">
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
                            <div class="col-xs-6 " style="direction:rtl;  padding-bottom: 15px;">
                                <div class="form-group-lg">
                                    <label for="size"> اندازه پلاتو مورد نظر </label>

                                    <select class="selectpicker form-control" name="size" data-live-search="true" data-size="6" title="انتخاب اندازه اتاق   ">
                                        <option value="0">مهم نیست</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>

                                    </select>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row text-center" style="padding-bottom: 20px;padding-top: 20px;">
                        <button type="submit" class="btn btn-lg btn-success" style="border-radius: 11px;">
                            <small>جست و جو</small>
                        </button>
                    </div>
                </form>

                </form>


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
