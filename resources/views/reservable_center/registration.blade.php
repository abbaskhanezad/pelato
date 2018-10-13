@extends('layout.user')
@push('top_css')
<link href="{{ asset('/assets/center_registration/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/center_registration/css/form-elements.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/center_registration/css/style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/assets/file_input/css/fileinput.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('assets/global/plugins/leaflet/leaflet.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    @include('layout.user.error')
    <!-- Top content -->
    <div class="top-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 form-box">
                    <form role="form" action="{{ route('reservable_center.storeForm') }}" method="post" class="f1" id="registration" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h3>فرم ثبت نام مرکز داران</h3>
                        <p>لطفا اطلاعات خواسته شده را با دقت وارد نمایید</p>
                        <div class="f1-steps">
                            <div class="f1-progress">
                                <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                            </div>
                            <div class="f1-step active">
                                <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                <p>اطلاعات هویتی </p>
                            </div>
                            <div class="f1-step">
                                <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                                <p>اطلاعات مرکز</p>
                            </div>
                            <div class="f1-step">
                                <div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                                <p> شرایط و قوانین </p>
                            </div>
                        </div>

                        <fieldset>
                            <div class="form-group">
                                <br>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 {{ $errors->has('username') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="username"> نام کاربری </span>
                                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
                                    @if ($errors->has('username'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('username') }}
                                       </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6  {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="name"> نام و نام خانوادگی  </span>
                                    <input type="text" name="name"  class="form-control" id="name"  value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('name') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6  {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="mobile"> تلفن همراه  </span>
                                    <input type="text" name="mobile"  class="form-control" id="mobile"  value="{{ old('mobile') }}">
                                    @if ($errors->has('mobile'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('mobile') }}
                                       </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6  {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="email"> ایمیل </span>
                                    <input type="text" name="email"  class="form-control" id="email"  value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('email') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-sm-6  {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="password"> رمز عبور </span>
                                    <input type="password" name="password"  class="form-control" id="password"  value="{{ old('password') }}">
                                    @if ($errors->has('password'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('password') }}
                                       </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6  {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="password_confirmation">  تایید رمز عبور </span>
                                    <input type="password" name="password_confirmation"  class="form-control" id="password_confirmation"  value="{{ old('password_confirmation') }}">
                                    @if ($errors->has('password_confirm'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('password_confirm') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12  {{ $errors->has('user_images') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" for="user_images"> تصویر کارت ملی و شناسنامه </span>
                                    <input id="user-images" name="user_images[]" type="file" multiple class="file-loading form-control pull-right" placeholder="درباره خود" accept="image/*">
                                    @if ($errors->has('user_images'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('user_images') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
                            <div class="f1-buttons col-sm-12">
                                <button type="button" id="f1-buttons" class="btn btn-next">بعدی</button>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="form-group">
                                <br>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6 {{ $errors->has('center_name') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" > نام مرکز </span>
                                    <input type="text" name="center_name" class="form-control" id="center_name" value="{{ old('center_name') }}">
                                    @if ($errors->has('center_name'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_name') }}
                                       </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6 {{ $errors->has('center_type') ? ' has-error' : '' }}">
                                    <span class="help-block text-left">نوع کاربری مرکز</span>
                                    <select class="form-control" name="center_type" id="center_type" style="height: 44px" >
                                        <option value="" class="form-control"> انتخاب نوع کاربری مرکز.. </option>
                                        @foreach($center_types as $center_type)
                                            <option value="{{$center_type->id}}" @if(old('center_type') == $center_type->id ) selected @endif class="form-control">{{ $center_type->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('center_type'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_type') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
							<div class="row">
                                <div class="form-group col-sm-6">
                                    <span class="help-block text-left">ویژگی های مرکز</span>
                                    <select class="center-attributes form-control" multiple="multiple" name="center_attribute[]" id="center_attribute" style="width: 100%" >
                                        @foreach($center_attributes as $center_attribute)
                                            <option value="{{$center_attribute->id}}" @if(old("center_attribute.$loop->index")==$center_attribute->id) selected @endif class="form-control">{{ $center_attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('center_type'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_type') }}
                                       </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6 {{ $errors->has('center_phone') ? ' has-error' : '' }}">
                                    <span class="help-block text-left" > تلفن مرکز </span>
                                    <input type="text" name="center_phone" class="form-control" id="center_phone" value="{{ old('center_phone') }}">
                                    @if ($errors->has('center_phone'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_phone') }}
                                       </span>
                                    @endif
                                </div>
                            </div>

							<div class="row">
                                <div class=" form-group  has-chair col-sm-4">
                                    <span class="help-block text-left">صندلی دارد؟</span>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <label class="switch switch-text switch-success switch-pill">
                                                <input type="checkbox" class="switch-input" id="has_chair" name="has_chair" checked="true">
                                                <span data-on="On" data-off="Off" class="switch-label" style="background: black"></span>
                                                <span class="switch-handle"></span>
                                            </label><br>
                                        </div>
                                        <input type="number"  id="chair_count" name="center_chairs" value="{{ old('center_chairs') }}" placeholder="تعداد صندلی.." class="form-control" style="height: 48px;">
                                    </div>
                                </div>

                                <div class="form-group  col-sm-4">
                                    <span class="help-block text-left">نوع مالکیت</span>
                                    <div class="col-sm-12  form-md-line-input text-left" style="margin-top: 15px">
                                        <input type="radio" name="ownership" @if(old('ownership') == "rent") checked @endif value="rent"><span class="form-check" style="margin: 5px">استیجاری</span>
                                        <input type="radio" name="ownership" @if(old('ownership') == "owner") checked @endif value="owner"><span style="margin: 5px">مالک</span>
                                    </div>
                                </div>

                                <div class="form-group  col-sm-4">
                                    <span class="help-block text-left">مدت زمان فعالیت</span>
                                    <input id="time_activity"  name="center_time_activity" type="number"  value="{{ old('center_time_activity') }}" class="form-control" placeholder="چند سال، ماه؟" style="height: 44px;">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12 {{ $errors->has('center_address') ? ' has-error' : '' }}">
                                    <span class="help-block text-left">آدرس مرکز</span>
                                    <textarea name="center_address" class="form-control" required id="center_address"> {{old('center_address')}} </textarea>
                                    @if ($errors->has('center_address'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_address') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
							<div class="row">
                                <div class="form-group col-sm-12 {{ $errors->has('center_description') ? ' has-error' : '' }}">
                                    <span class="col-md-2 control-label" for="center_description">توضیحات</span>
                                        <div class="col-md-12">
                                            <textarea name="center_description" id="center_description" rows="10" required="true" class="form-control">
                                                {{ old('center_description') }}
                                            </textarea>
                                            @if ($errors->has('center_description'))
                                                <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_description') }}
                                                </span>
                                            @endif
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 {{ $errors->has('center_image') ? ' has-error' : '' }}">
                                    <span class="help-block text-left">تصویر مرکز</span>
                                    <input id="center_image" name="center_image" type="file" class="file-loading form-control" accept="image/*">
                                    @if ($errors->has('center_image'))
                                        <span class="center-form-error badge badge-danger ">
                                           {{ $errors->first('center_image') }}
                                       </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 {{ $errors->has('user_images') ? ' has-error' : '' }}">
                                    <label class="control-label" for="map">مکان روی نقشه</label>
                                    <div id="map" style="width: 100%;height:300px;"></div>
                                    <input type="hidden" name="google_map_lat" id="map-lat" readonly="yes" value="{{ old('google_map_lat') }}"><br>
                                    <input type="hidden" name="google_map_lon" id="map-lng" readonly="yes" value="{{ old('google_map_lon') }}">
                                </div>
                            </div>
                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous">قبلی</button>
                                <button type="button" class="btn btn-next">بعدی</button>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <span class="help-block text-left">شرایط و قوانین</span>
                                    <textarea id="room-images" class="form-control" cols="50">
لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                    </textarea>
                                </div>
                                <div class="form-group col-sm-6">
                                    <span class="control-label" for="rules" style="float: right">موافقم</span>
                                    <input type="checkbox" id="rules" name="rules" class="" style="float: right">
                                </div>
                            </div>
                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous">قبلی</button>
                                <button type="submit" class="btn btn-submit">ارسال</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('bottom_scripts')
<script src="{{ asset('assets/global/plugins/leaflet/leaflet.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('assets/file_input/js/fileinput.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="{{ asset('assets/center_registration/js/jquery.backstretch.min.js') }}"></script>
<script src="{{ asset('assets/center_registration/js/retina-1.1.0.min.js') }}"></script>
<script src="{{ asset('assets/center_registration/js/scripts.js') }}"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#center_description').summernote({
            height:200,
        });
    });
</script>


<script>
    $(document).ready(function() {
        $("#has_chair").click(function () {
            $("#chair_count").attr('disabled', !this.checked)
        })
    });
</script>

<script>
    $("#user-images").fileinput({
        allowedFileExtensions: ["png", "jpeg", "jpg"],
        minImageWidth: 50,
        minImageHeight: 50,
    });
</script>

<script>
    $("#center_image").fileinput({
        allowedFileExtensions: ["png"],
        minImageWidth: 50,
        minImageHeight: 50,
    });
</script>

<script>
    $(document).ready(function() {
        $('.center-attributes').select2();
    });
</script>

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
@endpush