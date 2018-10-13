@extends('layout.user')

@section('content')
@include('layout.user.error')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form">
          <div class="portlet-title">
              <div class="caption">
                  <i class=" icon-pencil font-green"></i>
                  <span class="caption-subject font-green sbold uppercase">ثبت نام</span>
              </div>
          </div>
          <div class="portlet-body text-center">
              <!-- BEGIN FORM-->
              <form action="" method="post" class="form-horizontal">
                  <div class="form-body">
                    {{ csrf_field() }}
                      <div class="row">
                          <div class="form-group form-md-line-input col-md-10 {{ $errors->has('name') ? ' has-error' : '' }}">
                              <label class="col-md-4 control-label" for="name"></label>
                              <label class="col-md-2 control-label" for="name">نام</label>
                              <div class="col-md-4">
                                  <input type="text" name="name" id="name" required="true" class="form-control" placeholder="" value="{{ old('name') }}">
                                  <div class="form-control-focus"> </div>
                                  <span class="help-block">{{$errors->has('name') ? $errors->first('name') : 'فارسی'}}</span>
                              </div>
                          </div>



                      </div>

                      <div class="row">


                          <div class="form-group form-md-line-input col-md-10 {{ $errors->has('password') ? ' has-error' : '' }}">
                              <label class="col-md-4 control-label" for="name"></label>
                              <label class="col-md-2 control-label" for="name">کلمه عبور</label>
                              <div class="col-md-4">
                                  <input type="password" name="password" id="password" required="true" class="form-control" placeholder="" value="{{ old('password') }}">
                                  <div class="form-control-focus"> </div>
                                  <span class="help-block">{{$errors->has('password') ? $errors->first('password') : 'انگلیسی، حداقل 6 کاراکتر '}}</span>
                              </div>
                          </div>

                      </div>

                      <div class="row">
                      </div>
                      <div class="row">
                        <div class="form-group form-md-line-input col-md-10 {{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name"></label>

                            <label class="col-md-2 control-label" for="name">تلفن همراه</label>
                            <div class="col-md-4">
                                <input type="text" name="mobile" id="mobile" required="true" class="form-control" placeholder="" value="{{ old('mobile') }}">
                                <div class="form-control-focus"> </div>
                                <span class="help-block">{{$errors->has('mobile') ? $errors->first('mobile') : 'مثلا: 09120001234'}}</span>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-10 col-md-2">
                              <button class="btn green">ثبت نام</button>
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
