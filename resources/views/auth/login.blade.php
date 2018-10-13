@extends('layout.user')

@section('content')
@include('layout.user.error')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form">
          <div class="portlet-title">
              <div class="caption">
                  <i class=" icon-login font-green"></i>
                  <span class="caption-subject font-green sbold uppercase">ورود</span>
              </div>
          </div>
          <div class="portlet-body">
              <!-- BEGIN FORM-->
              <form action="" method="post" class="form-horizontal">
                  <div class="form-body">
                    {{ csrf_field() }}
                      <div class="row">
                        <div class="form-group form-md-line-input col-md-6 {{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="username">نام کاربری یا شماره تماس </label>
                            <div class="col-md-8">
                                <input type="text" name="username" id="username" min="6" required="true" class="form-control" placeholder="" value="{{ old('username') }}">
                                <div class="form-control-focus"> </div>
                                <span class="help-block">انگلیسی، حداقل 6 کاراکتر</span>
                            </div>
                        </div>
                        <div class="form-group form-md-line-input col-md-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="name">کلمه عبور</label>
                            <div class="col-md-8">
                                <input type="password" name="password" id="password" required="true" class="form-control" placeholder="" value="{{ old('password') }}">
                                <div class="form-control-focus"> </div>
                                <span class="help-block">انگلیسی، حداقل 6 کاراکتر</span>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-10 col-md-2">
                              <button class="btn green">ورود</button>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-10 col-md-offset-1">
                              <a href="/register"><div>هنوز ثبت نام نکرده اید؟ اقدام کنید</div></a>
                              <a href="/password/reset"><div>رمز خود را فراموش کرده اید؟ بازیابی کلمه عبور</div></a>
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
