@extends('layout.user')
@section('content')
@push('top_css')
<link href="{{ asset('assets/global/plugins/leaflet/leaflet.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endpush
@push('bottom_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('assets/global/plugins/leaflet/leaflet.js') }}" type="text/javascript"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote({
            height:300,
        });
    });
</script>


<script>
    @if($center->google_map_lat)
            var lat = "{{$center->google_map_lat}}";
            var lon = "{{$center->google_map_lon}}";
    @else
            var lat = 35.69439;
            var lon = 51.42151;
    @endif
    $(document).ready(function () {
        var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            osm = L.tileLayer(osmUrl, {maxZoom: 18});

        var marker = L.marker(
            [lat, lon],
            {
                draggable: true
            }
        );
        marker.on('drag', function(e) {
            $('#map-lat').val(e.latlng.lat);
            $('#map-lng').val(e.latlng.lng);
        });

        var map = L.map('map').setView([lat, lon], 15).addLayer(osm);
        marker.addTo(map);
    });
</script>

<script>
    $(document).ready(function() {
        $('.center-attributes').select2();
    });
</script>

@endpush
    @include('layout.user.error')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit portlet-form">
            <div class="portlet-title">
            <div class="portlet-body">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="user_id">کاربر</label>
                            <div class="col-md-4">
                                <input type="text" disabled="disabled" class="form-control"  value="{{\App\User::findOrFail($center->user_id)->name}}">
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="center_type_id">نوع</label>
                            <div class="col-md-4">
                                <input type="text" disabled="disabled" class="form-control" value="{{\App\CenterType::findOrFail($center->center_type_id)->name}}">
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="name">نام</label>
                            <div class="col-md-4">
                                <input type="text"  disabled="disabled" class="form-control" value="{{$center->name}}">
                            </div>
                        </div>
						<div class="form-group form-md-line-input">
							<label class="col-md-2 control-label" for="address">تلفن مرکز</label>
							<div class="col-md-4">
								@if($center->phone)
								<input type="text" readonly="readonly" class="form-control" value="{{$center->phone}}">
								@else
								<input type="text" readonly="readonly" class="form-control" value="ندارد" style="color: red">
								@endif
							</div>
               			 </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="address">آدرس</label>
                            <div class="col-md-10">
                                <input type="text" readonly="readonly" class="form-control" value="{{$center->address}}">
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="description">توضیحات</label>
                            <div class="col-md-10">
                                <textarea rows="10" readonly="readonly" id="description" class="form-control">{{$center->description}}</textarea>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="map">مکان روی نقشه</label>
                            <div class="col-md-10">
                                <div id="map" readonly="readonly" style="width: 100%;height:400px;"></div>
                                <input type="hidden" name="google_map_lat" id="map-lat" readonly="yes" value="{{$center->google_map_lat}}"><br>
                                <input type="hidden" name="google_map_lon" id="map-lng" readonly="yes" value="{{$center->google_map_lon}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">عکس پیشفرض</label>
                            <div class="col-md-10">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 300px; height: 300px;">
                                        <img src="@if(!empty($center->image)) /images/{{ $center->image->picture }} @else /img/default.gif @endif" alt="" />
                                    </div>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="center_attributes">ویژگی ها</label>
                            <div class="col-md-4">
                                @foreach($center->center_attribute()->get() as $center_attribute)
                                    <span class="badge badge-info">
                                        {{ $center_attribute->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                    </div>

                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                               <a href="{{ route('users.center_owner') }}" class="btn btn-sm btn-info pull-right">بازگشت به لیست مرکزداران</a>
                            </div>
                        </div>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
    </div>
</div>
@endsection