@extends('layout.user')
@if(!empty($reservable_center))
@push('top_scripts')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkQLW8Ypo634J3vfm3g1L-78qRnh8LjBQ"></script>
<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/plugins/leaflet/leaflet.css" rel="stylesheet" type="text/css" />

@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script>
var lat = {{$reservable_center->google_map_lat}};
var lon = {{$reservable_center->google_map_lon}};
</script>
<script src="/assets/global/plugins/leaflet/leaflet.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/map-location-show.js"></script>
@endpush

@section('content')
@include('layout.user.error')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">اطلاعات {{ $reservable_center->center_type->name}} {{ $reservable_center->name }}</span>
              </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-2">آدرس</div>
              <div class="col-md-10">{{ $reservable_center->address}}</div>
            </div>
            <div class="row">
              <div class="col-md-2">توضیحات</div>
              <div class="col-md-10">{!! $reservable_center->description !!}</div>
            </div>
            <div class="row">
              <div class="col-md-2">وضعیت تایید</div>
              <div class="col-md-10">@if($reservable_center->verified == 1) <i class="fa fa-check-circle-o text-success"></i> @else <i class="fa fa-ban text-warning"></i> @endif</div>
            </div>
            <div class="row">
              <div class="col-md-2">موقعیت مرکز روی نقشه</div>
              <div class="col-md-10">
                <div id="map" style="width: 100%;height:400px;"></div>
              </div>
            </div>
            <form method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="row">
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
                                <button type="submit" class="btn blue fileinput-exists"> ثبت عکس </button>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </form>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">اتاقها</span>
              </div>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                  <thead>
                      <tr>
                          <th> #</th>
                          <th> نام </th>
                          <th> اندازه(m2)</th>
                          <th> قیمت (هر ساعت)</th>
                          <th> جنس کف</th>
                          <th> جنس دیوار</th>
                          <th> تعداد عکس </th>
                          <th> عملیات</th>

                      </tr>
                  </thead>
                  <tbody>
                    <?php $zeros = 0; ?>
                    @foreach($reservable_center->room as $data)
                      <tr class="odd gradeX">
                          <td> {{$data->id}} </td>
                          <td> {{$data->name}} </td>
                          <td> {{$data->size}} </td>
                          <td> {{$data->price_per_hour}} </td>
                          <td> {{$data->floor_type}} </td>
                          <td> {{$data->wall_type}} </td>
                          <td> {{$data->image->count() }}</td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                      <i class="fa fa-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-left" role="menu">
                                      <li>
                                          <a href="/image/room/{{$data->id}}/list">
                                              <i class="icon-picture"></i> گالری عکس</a>
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
@stop
@else
@section('content')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">اطلاعات مرکز</span>
              </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-12">مرکزی برای شما ثبت نشده است.</div>
            </div>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
@stop
@endif
