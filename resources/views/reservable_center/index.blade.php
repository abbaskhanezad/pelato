@extends('layout.user')

@push('top_scripts')
<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/leaflet/leaflet.css" rel="stylesheet" type="text/css" />

@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="/assets/global/plugins/leaflet/leaflet.js" type="text/javascript"></script>
@if($reservable_center->google_map_lat)
<script>
	var lat = {{$reservable_center->google_map_lat}};
	var lon = {{$reservable_center->google_map_lon}};
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
@else
<script>
	var lat = 35.69439;
	var lon = 51.42151;
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

@endif
{{--<script type="text/javascript" src="/js/map-location-select.js"></script>--}}
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote({
            height:300,
        });
    });
</script>
@endpush

@section('content')
    @include('layout.user.error')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-building font-dark"></i>
                        <span class="caption-subject bold uppercase">لیست مراکز</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> نام </th>
                            <th> نوع </th>
                            <th> صاحب </th>
                            <th> تایید</th>
                            <th> فعال</th>
                            @if(auth()->user()->type == 3)
                            <th>مرکز برتر</th>
                            @endif
                            <th> زمان ثبت</th>
                            <th> زمان ویرایش</th>
                            <th> عملیات </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reservable_center_whole as $data)
                            <tr class="odd gradeX">
                                <td> {{$loop->iteration}} </td>
                                <td> {{$data->name}} </td>
                                <td> {{$data->center_type->name}}</td>
                                <td> {{$data->user->name}} {{$data->user->family}} </td>
                                <td> @if($data->verified) <i class="fa fa-check font-green"></i> @else <i class="fa fa-times font-red"></i> @endif </td>
                                <td> @if($data->active) <i class="fa fa-check font-green"></i> @else <i class="fa fa-times font-red"></i> @endif </td>
                                @if(auth()->user()->type == 3)
                                    <td class="id" >
                                        <form action="{{ route('reservable_center.isBest' , ['id' => $data->id]) }}" method="post">
                                            {{ method_field('put') }}
                                            {{ csrf_field() }}
                                            <button type="submit" id="status" data-id="{{ $data->id }}" @if($data->is_best) class="btn btn-success btn-sm status"> @else class="btn btn-danger btn-sm status"> @endif
                                                @if($data->is_best)<i class="fa fa-check font-white"></i> @else <i class="fa fa-times font-white"></i> @endif
                                            </button>
                                        </form>
                                    </td>
                                @endif
                                <td> {{jalali_datetime($data->created_at)}} </td>
                                <td> {{jalali_datetime($data->updated_at)}} </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" role="menu">
                                            @if(auth()->user()->type == 3)
                                            <li>
                                                <a href="/reservable_center/{{$data->id}}/edit">
                                                    <i class="icon-pencil"></i> ویرایش</a>
                                            </li>
                                            <li>
                                                <a onclick="if(confirm('آیا با حذف موافق هستید؟')) href='/reservable_center/{{$data->id}}/delete'"  style="color: red">
                                                    <i class="icon-trash"  style="color: red"></i> حذف </a>
                                            </li>
                                            <li>
                                                <a href="/reservable_center/{{$data->id}}/verify">
                                                    <i class="icon-check"></i> @if($data->verified) رد تایید @else تایید @endif </a>
                                            </li>
                                            <li>
                                                <a href="/reservable_center/{{$data->id}}/active">
                                                    <i class="fa fa-user-times"></i> @if($data->active) غیر فعالسازی @else فعالسازی @endif </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="/room/center/{{$data->id}}">
                                                    <i class="fa fa-building"></i> لیست اتاقها</a>
                                            </li>
                                            <li>
                                                <a href="/timing/center/{{$data->id}}">
                                                    <i class="fa fa-clock-o"></i> زمانبندی</a>
                                            </li>



                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">@if($edit) ویرایش @else ثبت @endif مرکز</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="@if($edit) /reservable_center/{{$reservable_center->id}}/edit @else /reservable_center/add @endif" enctype="multipart/form-data"  method="post" class="form-horizontal">
                        <div class="form-body">
                            {{ csrf_field() }}
                            @if($edit)
                                {{method_field('PATCH')}}
                            @endif
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="user_id">کاربر</label>
                                <div class="col-md-4">
                                    <select name="user_id" id="user_id" required="true" class="form-control">
                                        @foreach($user as $u)
                                            <option value="{{$u->id}}"  @if($u->id == $reservable_center->user_id) selected="selected" @endif>{{$u->name}} {{$u->family}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="center_type_id">نوع</label>
                                <div class="col-md-4">
                                    <select name="center_type_id" id="center_type_id" required="true" class="form-control">
                                        @foreach($center_type as $ct)
                                            <option value="{{$ct->id}}" @if($ct->id == $reservable_center->center_type_id) selected="selected" @endif>{{$ct->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="name">نام</label>
                                <div class="col-md-4">
                                    <input type="text" name="name" id="name" required="true" class="form-control" placeholder="" value="{{$reservable_center->name}}">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="address">آدرس</label>
                                <div class="col-md-10">
                                    <input type="text" name="address" id="address" required="true" class="form-control" placeholder="" value="{{$reservable_center->address}}">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="description">توضیحات</label>
                                <div class="col-md-10">
                                    <textarea name="description" id="description" rows="10" required="true" class="form-control">{{$reservable_center->description}}</textarea>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="map">مکان روی نقشه</label>
                                <div class="col-md-10">
                                    <div id="map" style="width: 100%;height:400px;"></div>
                                    <input type="hidden" name="google_map_lat" id="map-lat" readonly="yes" value="{{$reservable_center->google_map_lat}}"><br>
                                    <input type="hidden" name="google_map_lon" id="map-lng" readonly="yes" value="{{$reservable_center->google_map_lon}}">
                                </div>
                            </div>
                            <?php $center_attributes=[];foreach($reservable_center->center_attribute as $ca){
                                $center_attributes[]=$ca->id;
                            }?>
                            <div class="form-group">
                                <label class="control-label col-md-2">عکس پیشفرض</label>
                                <div class="col-md-10">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 300px; height: 300px;">
                                            <img src="@if(!empty($reservable_center->image)) /images/{{ $reservable_center->image->picture }} @else /img/default.gif @endif" alt="" /> </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 300px;"> </div>
                                        <div>
                                      <span class="btn default btn-file">
                                          <span class="fileinput-new"> انتخاب عکس </span>
                                          <span class="fileinput-exists"> تغییر عکس </span>
                                          <input type="file" name="image"> </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف عکس </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="center_attributes">ویژگی ها</label>
                                <div class="col-md-4">
                                    <select name="center_attributes[]" size="10" multiple id="center_attributes" required="true" class="form-control">
                                        @foreach($center_attribute as $ca)
                                            <option value="{{$ca->id}}" @if(in_array($ca->id,$center_attributes)) selected="selected" @endif>{{$ca->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">برای انتخاب چندین گزینه همزمان با کلیک، کلید Ctrl را نگه دارید</span>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green">@if($edit) ویرایش @else ثبت @endif</button>
                                    @if($edit)
                                        <a href="/reservable_center" class="btn default">انصراف</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
@stop
