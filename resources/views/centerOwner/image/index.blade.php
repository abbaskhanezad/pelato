@extends('layout.admin')

@push('top_scripts')
<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('bottom_scripts')
<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

@endpush
@section('content')
@include('layout.user.error')
<div id="app">
    <section class="content">

<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست عکسهای اتاق {{ $room->name}}</span>
              </div>
              <div class="actions">
                <a class="btn btn-info btn-xl" href="/centerowner/dashboard/">داشبورد</a>
              </div>
          </div>
          <div class="portlet-body">

            <div class="row">
              <div class="col-md-4">
                  <!-- BEGIN Portlet PORTLET-->
                  <div class="portlet box blue-hoki">
                      <div class="portlet-title">
                          <div class="caption">
                              <i class="fa fa-gift"></i>عکس جدید</div>
                      </div>
                      <div class="portlet-body">
                        <form action="" method="post"  enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                            <img src="" alt="" /> </div>
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
                  <!-- END Portlet PORTLET-->
              </div>
              <?php $i = 1; ?>
              @foreach ($room->image as $key => $image)
              <?php $i++;?>
              @if($i == 4)
              <?php $i = 1; ?>
            </div>
            <div class="row">
              @endif
              <div class="col-md-4">
                  <!-- BEGIN Portlet PORTLET-->
                  <div class="portlet box blue-hoki">
                      <div class="portlet-title">
                          <div class="caption">
                              <i class="fa fa-gift"></i> {{ $key + 1 }}</div>
                          <div class="actions">
                              <a href="/centerowner/image/room/{{$room->id}}/image/{{$image->id}}/delete" class="btn btn-default btn-sm" title="حذف">
                                  <i class="fa fa-trash"></i>
                                </a>
                          </div>
                      </div>
                      <div class="portlet-body">
                        <img src="/images/{{ $image->picture}}" class="img-responsive" style="margin:0 auto;"/>
                      </div>
                  </div>
                  <!-- END Portlet PORTLET-->
              </div>
              @endforeach
            </div>

          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
    </section>
    </div>
@stop
