@extends('layout.users')

@section('script')

    <link rel="stylesheet" href="/userAssets/persian-datepicker/dist/css/persian-datepicker.css"/>

    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <script src="/userAssets/persian-datepicker/assets/persian-date.min.js"></script>
    <script src="/userAssets/persian-datepicker/dist/js/persian-datepicker.min.js"></script>

    <script>

        $('.inline-example').persianDatepicker({
            inline: true,
            altField: '#inlineExampleAlt',
            altFormat: 'dddd - L',
            maxDate: new persianDate().add('month', 3).valueOf(),
            minDate: new persianDate().subtract('month', 3).valueOf(),
        });


    </script>

    <script>
        $('#nav-tab li:first-child').addClass('active');
        $('#tab-content div:first-child').addClass('in active');
        $('#room_carousel div:first-child').addClass('active');
    </script>

    <script>



    </script>

@endsection


@section('style')

    <style>
        .myNav {
            margin-top: 30px;
        }

        .room_content {
            line-height: 40px;
        }

    </style>
@endsection





@section('content')





        <div class="btn btn-warning btn-block" id="calender" style="cursor: auto">لطفا تاریخ موردنظر خود را انتخاب نمایید</div>
        <div class="calenderBox" >
            <form action="{{ route('user.panel.reserve.getTimingRoom',$center_id) }}" method="post">
                {{ csrf_field() }}

                <input type="text" name="date"  id="inlineExampleAlt" value="1" class="datepicker-demo"/>
                <div class="inline-example"></div>

                <button class="btn btn-success btn-block"> برای نمایش زمانبندی اتاق های این مرکز در تاریخ موردنظر اینجا کلیک کنید ...</button>
            </form>
        </div>


        <div class="container">


            <h3>لیست اتاق ها و مشخصات آنها</h3>

            <ul class="nav nav-tabs myNav" id="nav-tab">
                    @foreach($center_room_list as $room)
                    <li><a data-toggle="tab" href="#{{$room->id}}"> اتاق{{ ' '.$room->name }}</a></li>
                @endforeach
            </ul>

                    <div class="tab-content" id="tab-content">


                        @foreach($center_room_list as $room)

                            <div id="{{ $room->id }}" class="tab-pane fade room_content">

                                <div class="col-xs-12 col-md-3">
                                    <span>اندازه: </span> <span><b> {{ $room->size }} متر مکعب </b></span><br/>
                                    <span>جنس کف: </span> <span><b> {{ $room->floor_type }} </b></span><br/>
                                    <span>جنس دیوار: </span> <span><b> {{ $room->wall_type }} </b></span><br/>
                                </div>
                                <div class="col-xs-12 col-md-9 col-md-pull-2">
                                    @include('users.reserves.sections.carousel',['room'=>$room])
                                </div>

                            </div>



                        @endforeach


                    </div>

        </div>


@endsection

