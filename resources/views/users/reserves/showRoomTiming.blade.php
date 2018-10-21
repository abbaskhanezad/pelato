@extends('layout.users')

@section('style')
    <style>
        .boxContent {
            margin-top: 30px;
        }

        .divCenter {
            margin: 10px auto;
        }

        .itemHour {
            text-align: center;
            cursor: pointer;
        }

        .itemHour:hover {
            opacity: 0.5;
        }

        .notAllowReserve {
            background-color: #ff5238;
            color: white;
        }

        .allowReserve {
            background-color: #53ff92;
        }

        .reserving {
            background-color: yellow;
        }
    </style>
@endsection

@section('script')
    <script>

        var date = $('.boxContent').data('date');
        $('.itemHour').click(function (event) {
            event.preventDefault();
            $this = $(this);
            var room_id = $this.data('roomid');
            var hour = $this.data('hour');

            $.ajax({
                url: '{{route('user.panel.reserve.checkAllowReserve')}}',
                method: 'get',
                dataType: 'JSON',
                data: {
                    room_id: room_id,
                    hour: hour,
                    date: date,
                },

                success: function (response) {
                    if (response) {
                        var className = room_id + '-' + hour;
                        // $('#'+className).css('backgroundColor','yellow');

                        $('#' + className).toggleClass('reserving');


                    } else {
                        alert('غیر قابل رزرو');
                    }
                },
                error: function () {

                }
            });


        });
    </script>
@endsection

@section('content')

    <div class="boxContent" data-date="{{$gregorianDate}}">
        @if(count($center_rooms) > 0 && count($room_timing) >0)

            <a href="{{ route('user.panel.reserve.showReservingList') }}" class="btn btn-danger btn-block btn-large">پس از انتخاب زمان موردنظر خود اینجا کلیک کنید ...</a>

            @foreach($center_rooms as $room)
                <div class="btn btn-warning  divCenter">
                    لیست زمانبندی اتاق {{ $room->name }}
                </div>

                <div class="btn btn-primary btn-xs btn-block">برنامه زمانبندی قبل از ظهر</div>

                @for($i=0;$i<=11;$i++)

                    @if( in_array($room->id,$room_timing) && in_array($i,array_keys($room_timing)))
                        <div class="col-xs-1 well itemHour allowReserve" data-roomid="{{$room->id}}"
                             data-hour="{{ $i }}" id="{{ $room->id.'-'.$i }}"
                        > {{ persianFormat($i) }}</div>
                    @else
                        <div class="col-xs-1 well itemHour notAllowReserve" data-roomid="{{$room->id}}"
                             data-hour="{{ $i }}" id="{{ $room->id.'-'.$i }}"
                        > {{ persianFormat($i) }}</div>

                    @endif

                @endfor


                <div style="clear: both;"></div>

                <div class="btn btn-primary btn-xs btn-block">برنامه زمانبندی بعد از ظهر</div>

                @for($i=12;$i<=23;$i++)


                    @if( in_array($room->id,$room_timing) && in_array($i,array_keys($room_timing)))
                        <div class="col-xs-1 well itemHour allowReserve" data-roomid="{{$room->id}}"
                             data-hour="{{ $i }}" id="{{ $room->id.'-'.$i }}"
                        > {{ persianFormat($i) }}</div>
                    @else
                        <div class="col-xs-1 well itemHour notAllowReserve" data-roomid="{{$room->id}}"
                             data-hour="{{ $i }}" id="{{ $room->id.'-'.$i }}"
                        > {{ persianFormat($i) }}</div>

                    @endif






                @endfor



            @endforeach




        @else
            <h2>هیچ زمانبندی یافت نشد !</h2>
        @endif
    </div>


@endsection

