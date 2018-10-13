@extends('layout.user')

@push('top_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/assets/global/component/datepicker/bootstrap-datepicker.css">
<link rel="stylesheet" href="/assets/global/component/bootstrap-select/bootstrap-select.css">
<link rel="stylesheet" href="/assets/global/component/clockpicker/clockpicker.css">
<link rel="stylesheet" type="text/css" href="/assets/global/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="/assets/global/dist/jquery-clockpicker.min.css">
@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/portfolio-4.min.js" type="text/javascript"></script>

<script>

    $(document).ready(function () {
        // Handler for .ready() called.
        $('html, body').animate({
            scrollTop: $('#what').offset().top
        }, 'search_rsult');
    });
</script>

<script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/portfolio-4.min.js" type="text/javascript"></script>
<script src="/assets/global/component/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/global/component/datepicker/bootstrap-datepicker.fa.js"></script>
<script src="/assets/global/component/bootstrap-select/bootstrap-select.js"></script>
<script src="/assets/global/component/bootstrap-select/fa.js"></script>
<script src="/assets/global/component/clockpicker/clockpicker.js"></script>
<script src="/assets/global/dist/bootstrap-clockpicker.min.js"></script>
<script src="/assets/global/dist/jquery-clockpicker.min.js"></script>
<style>
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
	  .clabel{
        color: #1acbea;
        font-weight: bold;
        font-size: 8px;
    }


</style>

<script>
    $(document).ready(function() {
        $("#datepicker").datepicker({
            minDate: 0,
            maxDate: "+90D",
            dateFormat: "yy-mm-dd",
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth:true,
            changeYear:true,
            numberOfMonths: 1,
        });

        $('#visittime').click(function(){
            $("#endtimeerror").slideUp();
            $("#starttimeerror").slideUp();
        });
        $('#starttime').click(function(){
            $("#endtimeerror").slideUp();
            $("#starttimeerror").slideUp();
        });
        $('#endtime').click(function(){
            $("#endtimeerror").slideUp();
            $("#starttimeerror").slideUp();
        });

        $('#starttime').clockTimePicker({
            autosize:false,
            precision:10,
            onClose: function () {
                if ($("#visittime").val() == null ||$("#visittime").val() == ""){
                    $("#starttime").val("");
                    $("#starttimeerror").slideDown();
                }
                if ($("#endtime").val() != null){
                    $("#endtime").val("");
                }

            }

        });

        $('#endtime').clockTimePicker({
            autosize:false,
            precision:10,
            onClose: function (){
                var starttime = ($('#starttime').val()).split(':');
                var visittime = $('#visittime').val();
                var endtime = ($('#endtime').val()).split(":");

                var starttimemin = +(starttime[0] * 60) + +(starttime[1]);
                var endtimemin = +(endtime[0] * 60) + +(endtime[1]);

                if (!(endtimemin > starttimemin && ((endtimemin - starttimemin) >= visittime))) {
                    $("#endtime").val("");
                    $("#endtimeerror").slideDown();
                }

            }

        });

    });
</script>
<script type="text/javascript">
    $('.clockpicker').clockpicker();
</script>

<script>
    function myFunction() {
        var x = document.getElementById("myDIV");
        var y=document.getElementById("advsearch");
        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display="none";
        } else {
            x.style.display = "none";
            y.style.display = "block";
        }
    }
</script>

@endpush

@section('content')
@include('layout.user.error')
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="portfolio-content portfolio-4">
        <div id="js-filters-full-width" class="cbp-l-filters-alignCenter">

            <!--  start search box---->


           <div class="row">
      <div class="col-xs-12  col-md-2 col-md-offset-5"  id="advsearch" style="padding-bottom:15px;padding-top:5px;">        
  <button class="btn btn-success"  onclick="myFunction()" style="border-radius:5px;">نمایش باکس سرچ پیشرفته</button>

    </div>
</div>
            <div class="panel panel-success" id="myDIV" style="display: none;">
                <div class="panel-heading text-center" onclick="myFunction()">   جســـتجــوی پیـشـــرفتــه  <span class="glyphicon glyphicon-search"></span></div>
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
                                    <label for="time"> از ساعت    </label>

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
                            <button type="submit" class="btn btn-lg btn-danger" style="border-radius: 11px;">
                                <small>جست و جو</small>
                            </button>
                        </div>
                    </form>

                    </form>


                </div>
            </div>


            <!---end--->

            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item"> همه
                <div class="cbp-filter-counter"></div>
            </div> /
            @foreach($center_type as $ct)
            <div data-filter=".ct-{{$ct->id}}" class="cbp-filter-item"> {{$ct->name}}
                <div class="cbp-filter-counter"></div>
            </div> @if (! $loop->last) / @endif
            @endforeach
        </div>
        <div id="js-grid-full-width" class="cbp row">
          @foreach($reservable_center as $rs)
            <div class="cbp-item identity ct-{{ $rs->center_type->id}} col-md-3" style="height: 200px;">
                <a href="/centers/{{ $rs->id}}" class="cbp-caption">
                    <div class="cbp-caption-defaultWrap img-responsive" style="height: 200px;">
                        <div class="cbp-overview">
                            <span>{{ $rs->name}}</span>
                        </div>
                        <img class="img-responsive" style="height:200px;" src="@if(!empty($rs->image)) /images_thumb/{{ $rs->image->picture }} @else /img/default.gif @endif" alt="">
                    </div>
                    <div class="cbp-caption-activeWrap">
                        <div class="cbp-l-caption-alignCenter">
                            <div class="cbp-l-caption-body">
                                <div class="cbp-l-caption-title">{{ $rs->name}}</div>
                                <div class="cbp-l-caption-desc">
                                  <span title="نوع مرکز"><i class="fa fa-tag"></i> {{ $rs->center_type->name }}<br/></span>
                                  <span title="آدرس"><i class="fa fa-map-marker"></i> آدرس: {{ mb_substr($rs->address,0,20)}} ...<br/></span>
                                  <span title="تعداد اتاق"><i class="fa fa-bank"></i> تعداد اتاق ها: {{ $rs->room->count() }}<br/></span>
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
<!-- END PAGE CONTENT INNER -->
@stop