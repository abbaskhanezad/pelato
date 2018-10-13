@extends('layout.admin')

@section('content')



    <div id="app">
        <section class="content">
		<div class="row text-center" style="padding:5px;border-radius:5px; font-weight:bold;">
            @include('layout.user.error')
		</div>

<form action="/centerowner/updateprofile" method="POST">

{{csrf_field()}}
        <div class="row" style="direction:rtl;">
            <div class="panel panel-info">
                <div class="panel-heading text-center">پروفایل مدیر مرکز</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="name"> نام:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$model->name}}">
                            @if ($errors->has('name'))
                                <small class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </small>
                            @endif
                        </div>
                        <div class="col-xs-6">
                            <label for="family"> نام خانوادگی:</label>
                            <input type="text" class="form-control" id="family" name="family" value="{{$model->family}}">
                            @if ($errors->has('family'))
                                <small class="help-block">
                                    <strong>{{ $errors->first('family') }}</strong>
                                </small>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="email"> ایمیل:</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{$model->email}}">
                            @if ($errors->has('email'))
                                <small class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </small>
                            @endif
                        </div>
                        <div class="col-xs-6">
                            <label for="mobile"> شماره تماس :</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{$model->mobile}}">
                            @if ($errors->has('mobile'))
                                <small class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </small>
                            @endif

                        </div>
                    </div>
                    <div class="row text-center" style="padding: 20px;">
                        <button type="submit" class="btn btn-success">بروزرسانی</button>

                    </div>


                    </div>
                </div>
            </div>
</form>
    </section>

    </div>


@endsection
@section('footer')

    <script src="{{asset('component/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('component/datepicker/bootstrap-datepicker.fa.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker2").datepicker({
                dateFormat: "yy-mm-dd",
                showOtherMonths: true,
                changeMonth:true,
                changeYear:true
            });

        });
    </script>



    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7h_OOPn4CmG658z7MuQ8CE8LxJl8Prrk"></script>

    <script type="text/javascript">
        window.onload = function () {
            $lat=document.getElementById("lat").value;
            $lon=document.getElementById("lon").value;


            var mapOptions = {

                center: new google.maps.LatLng($lat, $lon),
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            center=new google.maps.LatLng($lat, $lon);
            //var marker = new google.maps.Marker({position: center});
            var marker = new google.maps.Marker({
                position: center,
                map: map,
                icon: "http://uupload.ir/files/hwff_untitled.png",
                draggable:true

            });

            var infoWindow = new google.maps.InfoWindow();
            var latlngbounds = new google.maps.LatLngBounds();
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
            marker.setMap(map);

            var markersArray = [];
            // ltln='('+$lat+', '+$lon+')';
            //  alert(ltln);

            // placeMarker(ltln, map);
            map.addListener('click', function(e) {


                document.getElementById("lat").value=e.latLng.lat();
                document.getElementById("lon").value= e.latLng.lng();
                // alert(e.latLng);
                deleteOverlays();
                placeMarker(e.latLng, map);

            });
            function placeMarker(location) {

                var marker = new google.maps.Marker({
                    position: location,
                    map: map

                });
                markersArray.push(marker);
            }

            function deleteOverlays() {
                if (markersArray) {
                    for (i in markersArray) {
                        markersArray[i].setMap(null);
                    }
                    markersArray.length = 0;
                }
            }

        }

    </script>

@endsection
