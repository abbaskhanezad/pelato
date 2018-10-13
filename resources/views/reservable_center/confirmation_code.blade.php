@extends('layout.user')
@section('content')
    @include('layout.user.error')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">تایید</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="col-md-12">
                        <p>دوست عزیز، یک پیامک حاوی کد فعالسازی به تلفن همراه شما ارسال شد.</br> لطفا این کد را در قسمت خواسته شده وارد نمایید.</br>
                            <img src="/images/warning.png"> تا وقتی که پیامک به دستتان نرسیده این صفحه را نبندید.</p>                <p>    <h2 id="timer" >
                        </h2>                ثانیه شکیبا باشید.                </p>
                        <script>
                            $(document).ready(function () {
                                var sec = 180;
                                setInterval(function () {
                                    if (sec > 0) {
                                        sec = sec - 1;
                                        $('#timer').text(sec);
                                    }else{
                                        return;
                                    }
                                }, 1000);
                            });
                        </script>
                    </div>
                </div>
                <!-- BEGIN FORM-->
                <form action="{{route('reservable_center.storeForm')}}" method="post" class="form-horizontal">
                    <div class="form-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group form-md-line-input col-md-6 {{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="mobile">تلفن همراه</label>
                                <div class="col-md-8">
                                    <input type="text" name="mobile" id="mobile" min="11" max="11" required="true" {{ ($mobile!="") ? 'readonly="true"' : ''}}
                                    class="form-control" placeholder="" value="{{ $mobile }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{$errors->has('mobile') ? $errors->first('mobile') : ''}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group form-md-line-input col-md-6 {{ $errors->has('confirm_code') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="confirm_code">کد فعالسازی</label>
                                <div class="col-md-8">
                                    <input type="text" name="confirm_code" id="condirm_code" min="5" max="5" required="true" class="form-control" placeholder="" value="{{ old('confirm_code') }}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">{{$errors->has('confirm_code') ? $errors->first('confirm_code') : 'عدد 5 رقمی پیامک شده به تلفن همراه تان'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-10 col-md-2">
                        <button type="submit" class="btn green">تایید</button>
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