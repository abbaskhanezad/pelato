@extends('layout.user')

@push('top_scripts')
@endpush

@push('bottom_scripts')
@endpush

@section('content')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">خطا 1111</span>
              </div>
          </div>
          <div class="portlet-body">
            <p>مرکز مورد نظر یافت نشد</p>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
@stop
