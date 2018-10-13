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
            font-size: 9px!important;
            box-shadow: none;
            border-color: #d2d6de;
            text-align: right;
        }
        .filter-option{
            border-radius: 5px;
            font-size: 9px;
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




@endpush

@section('content')
@include('layout.user.error')
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="portfolio-content portfolio-4">
        <div id="js-filters-full-width" class="cbp-l-filters-alignCenter">

            <div class="row">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">   جســـتجــوی پیـشـــرفتــه  <span class="glyphicon glyphicon-search"></span></div>
                    <div class="panel-body">
                        <form action="{{route("index.adv_search")}}" method="GET" autocomplete="off">

                            <div class="row"  style="padding-bottom: 20px;padding-top: 20px;">


                                <div class="col-xs-3">
                                    <div class="form-group" style="text-align: center;">
                                        <label for="rooz" class="clabel">  روز </label>

                                        <input type="text" placeholder="انتخاب روز" class="form-control" name="rooz" id="datepicker" value="{{$tarikh}}" >
                                        @if ($errors->has('rooz'))
                                            <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('rooz') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="time"  class="clabel"> از ساعت </label>

                                        <div class="input-group "  data-align="top" data-autoclose="true" >

                                            <input   name="time" type="time" class="form-control" value="{{$azsaat}}" required>
                                            @if ($errors->has('time'))
                                                <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('time') }}</strong>
                                        </span>
                                            @endif
                                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label for="time"  class="clabel"> تا ساعت </label>

                                        <div class="input-group "  data-align="top" data-autoclose="true" >

                                            <input   name="endtime" type="time" class="form-control" value="{{$tasaat}}" required>
                                            @if ($errors->has('time'))
                                                <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('time') }}</strong>
                                        </span>
                                            @endif
                                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-xs-3 " style="direction:rtl;">
                                    <div class="form-group">
                                        <label for="money"  class="clabel">  مبلغ  </label>


                                        <input type="number" class="form-control" placeholder="مبلغ به تومان" name="money" min="1000" step="1000" value="{{$mablagh}}" >
                                        @if ($errors->has('money'))
                                            <span class="help-block" style="color: red;">
                                            <strong>{{ $errors->first('money') }}</strong>
                                        </span>
                                        @endif



                                    </div>

                                </div>



                            </div>
                            <div class="row"  style="padding-bottom: 20px;padding-top: 20px;">

                                <div class="col-xs-4">
                                    <div class="form-group" style="text-align: center;">
                                        <label for="name"  class="clabel">  نام </label>

                                        <input  type="text" name="name" class="form-control " value="{{$name}}" placeholder="نام پلاتو مورد نظر" style="height: 46px;">
                                    </div>
                                </div>

                                <div class="col-xs-4 ">
                                    <div class="form-group-lg">
                                        <label for="attribute"  class="clabel"> امکانات</label>

                                        <select class="selectpicker form-control" name="attribute[]" multiple data-live-search="true" data-size="6" title="دنبال چه امکاناتی هستید؟">
                                        <!--  <option value="{{''}}">همه مراکز را جست و جو کن</option>
                               -->
                                            <optgroup label="امکانات">
                                                @if(count($request_attr)>0)

                                                    @foreach($center_attributes as $center_attribute)
                                                        <option value="{{$center_attribute->id}}" @if(in_array($center_attribute->id,$request_attr)) selected @endif>{{$center_attribute->name}}</option>
                                                    @endforeach
                                                @else
                                                    @foreach($center_attributes as $center_attribute)
                                                        <option value="{{$center_attribute->id}}" >{{$center_attribute->name}}</option>
                                                    @endforeach
                                                @endif

                                            </optgroup>
                                        </select>                                    </div>
                                </div>
                                <div class="col-xs-4 " style="direction:rtl;  padding-bottom: 1px;">
                                    <div class="form-group-lg">
                                        <label for="size"  class="clabel"> اندازه</label>

                                        <select class="selectpicker form-control" name="size" data-live-search="true" data-size="6" title="حداقل اندازه اتاق به متر مربع">
                                            <option value="0">مهم نیست</option>
                                            @for($i = 10; $i < 60;$i=$i+10)
                                                <option value="{{$i}}" @if($i==$request_size) selected  @endif>{{$i}}</option>
                                            @endfor


                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row text-center" style="padding-bottom: 20px;padding-top: 2px;">
                                <button type="submit" class="btn btn-lg btn-success" style="border-radius: 11px;">
                                    <small>جست و جو</small>
                                </button>
                            </div>
                        </form>

                        </form>


                    </div>
                </div>
            </div>

            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item"> همه
                <div class="cbp-filter-counter"></div>
            </div> /
            @foreach($center_type as $ct)
            <div data-filter=".ct-{{$ct->id}}" class="cbp-filter-item"> {{$ct->name}}
                <div class="cbp-filter-counter"></div>
            </div> @if (! $loop->last) / @endif
            @endforeach
        </div>


        @if(count($reservable_center)==0)

            <div class="alert alert-danger text-center">
                <span style="font-size: 40px;"><i class="glyphicon glyphicon-info-sign"></i></span> <strong>{{"با عرض پوزش موردی یافت نشد.. "}}</strong> <span>{{"  "}}</span>
            </div>


        @endif

        <div id="js-grid-full-width" class="cbp row" id="search_result">

       
        </div>

               @foreach($reservable_center as $rs)

        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" style="direction: rtl; border-radius: 3px;">
            <div class="thumbnail" style="border-radius:8px;background-color:#ebeff0;">
                <div style="height:150px;width:100%;">
				 <a href="/centers/{{ $rs->id}}">
                    <img class="img-responsive" style="height:100%;width: 100%;" src="@if(!empty($rs->image)) /images_thumb/{{ $rs->image->picture }} @else /img/default.gif @endif" alt="">
                </a>
				
				</div>
                <div class="caption">
				<a href="/centers/{{ $rs->id}}">
                    <h5 style="color: #00c4ff"><span style="font-weight: bold;"> {{ $rs->name}} </span></h5>
				</a>
                    <p> <span class="glyphicon glyphicon-tag"></span>  نوع مرکز :{{ $rs->center_type->name }} </p>
                    <p> <span class="fa fa-bank"></span>  تعداد اتاق:{{ $rs->room->count() }} </p>
                     <div style="background-color: #bee2fd;padding: 5px;border-radius: 8px;">
                         <span class="fa fa-clipboard"></span>    ویژگی ها:
                         <p style="height:43px;overflow-y:auto">
                             @if($rs->center_attribute->count()>0)
                                 @foreach($rs->center_attribute as $ca)
                                     <span class="badge badge-success" style="font-weight: bold;">
                                {{ $ca->name }}
                             </span>
                         @endforeach
                         @else
                             <p style="color:red;">ویژگی برای این مرکز ثبت نشده است</p>

                             @endif
                             </p>
                     </div>

                    <?php

                    $string = strip_tags($rs->address);
                    if (strlen($string) > 60) {
                        $stringCut = substr($string, 0, 60);
                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...' ;
                    }
                    ?>
                    <p style="direction:rtl;" >
                        <span class="fa fa-2x fa-map-marker text-green text-bold" style="color: red;"></span>
                        <small class="no-margin" style="display: block; height: 50px; overflow-y: auto;">
                            <span>{{$rs->address}}</span>
                        </small>
                    </p>
                    <p>
                        <a href="/centers/{{ $rs->id}}" class="btn btn-sm btn-success" style="margin-bottom: 2px; width: 100%;border-radius:5px;">
                            <span style="border-radius:5px;">مشــاهــده و رزرو مــرکــز</span>
                        </a>

                    </p>
                </div>
            </div>
        </div>

         @endforeach


    </div>
</div>
<!-- END PAGE CONTENT INNER -->
@stop
