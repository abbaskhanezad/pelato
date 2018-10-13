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

    </style>

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                minDate: 0,
                maxDate: "+30D",
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


    <!----start-search-box----->
    <form action="{{route("index.adv_search")}}" method="GET" autocomplete="off">

    <div class="row" style="padding-bottom: 20px;padding-top: 20px;">
        <div class="col-md-12 search-box">

            <div class="row text-center">
                    <div class="col-sm-4">
                        <div class="form-group" style="text-align: center;">
                            <label for="name">  نام پلاتو مورد نظر  </label>

                            <input style="height:46px;line-height:46px" type="text" name="name" class="form-control " placeholder="نام پلاتو مورد نظر">
                        </div>
                    </div>
                    <div class="col-sm-4 " style="direction:rtl;  padding-bottom: 15px;">
                        <div class="form-group-lg">
                            <label for="attribute">  امکانات مورد نظر     </label>

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
                    <div class="col-sm-4 " style="direction:rtl;  padding-bottom: 15px;">
                        <div class="form-group-lg">
                            <label for="size"> اندازه پلاتو مورد نظر </label>

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

            </div>


        </div>
    </div>
        <div class="row"  style="padding-bottom: 20px;padding-top: 20px;">
            <div class="col-md-12 search-box">

                <div class="row text-center">
                    <div class="col-sm-4">
                        <div class="form-group" style="text-align: center;">
                            <label for="rooz"> روز مورد نظر برای رزرو </label>

                            <input type="text" class="form-control" name="rooz" id="datepicker" >
                            @if ($errors->has('rooz'))
                                <span class="help-block"  style="color: red;">
                                            <strong>{{ $errors->first('rooz') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="time"> ساعت مورد نظر برای رزرو </label>

                            <div class="input-group clockpicker"  data-align="top" data-autoclose="true" >

                                <input   name="time" type="text" class="form-control" value="09:00" required>
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
                    <div class="col-sm-4 " style="direction:rtl;  padding-bottom: 15px;">
                        <div class="form-group">
                            <label for="money"> حداکثر مبلغ مورد نظر برای رزرو </label>


                            <input type="number" class="form-control" placeholder="مبلغ به تومان" name="money" min="1000" value="{{old('money')}}" >
                            @if ($errors->has('money'))
                                <span class="help-block" style="color: red;">
                                            <strong>{{ $errors->first('money') }}</strong>
                                        </span>
                            @endif

                        <small class="bg-danger">مبلغ را به تومان وارد کنید</small>


                    </div>

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


    <!----end------->


@stop