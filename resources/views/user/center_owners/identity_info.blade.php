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
    @endpush
    @include('layout.user.error')
    <div class="row">
        <div class="col-md-5 col-md-offset-4">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">
                    <!-- BEGIN FORM-->
                    <div class="row">
                      <div class="col-sm-6">
                          <div class="form-group form-md-line-input col-sm-6">
                              <span class="control-label" for="user_id">نام </span>
                              <input type="text" disabled="disabled" class="form-control"  value="{{ $user->name }}">
                          </div>
                          <div class="form-group form-md-line-input col-sm-6">
                              <span class="ccontrol-label" for="name">نام کاربری</span>
                              <input type="text"  disabled="disabled" class="form-control" value="{{ $user->username }}">
                          </div>
                          <div class="form-group form-md-line-input col-sm-6">
                              <span class="control-label" for="user_id">ایمیل</span>
                              <input type="text" disabled="disabled" class="form-control"  value="{{ $user->email }}">
                          </div>
                          <div class="form-group form-md-line-input col-sm-6">
                              <span class=" control-label" for="name">شماره موبایل</span>
                              <input type="text"  disabled="disabled" class="form-control" value="{{ $user->mobile }}">
                          </div>
                      </div>
                        <div class="col-sm-6">
                            <div class="form-group">
								@if(!empty($user->image->toArray()))
                                    <div id="slideshow-{{$user->id}}" class="carousel slide" data-ride="carousel">
                                        <!-- Indicators -->
                                        <ol class="carousel-indicators">
                                            @foreach($user->image as $kimg => $image)
                                                <li data-target="#slideshow-{{$user->id}}" data-slide-to="{{ $kimg }}" class="active"></li>
                                            @endforeach
                                        </ol>

                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner" role="listbox">
                                            @foreach($user->image as $kimg => $image)
                                                <div class="item @if($kimg == 0)  active @endif">
                                                    <img src="/images/{{ $image->picture}}">
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Left and right controls -->
                                        <a class="right carousel-control" href="#slideshow-{{$user->id}}" role="button" data-slide="prev">
                                            <i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i>
                                            <span class="sr-only">قبلی</span>
                                        </a>
                                        <a class="left carousel-control" href="#slideshow-{{$user->id}}" role="button" data-slide="next">
                                            <i class="glyphicon glyphicon-chevron-left" aria-hidden="true"></i>
                                            <span class="sr-only">بعدی</span>
                                        </a>
                                    </div>
                                @endif
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                             <a href="{{ route('users.center_owner') }}" class="btn btn-sm btn-info pull-right">بازگشت به لیست مرکزداران</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection