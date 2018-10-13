@extends('layout.user')

@include('layout.user.error')
<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">بازیابی کلمه عبور</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/reset/done') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">شماره تلفن همراه</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>


                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    بازیابی کلمه عبور
                                </button>
                            </div>
                        </div>
                    </form>
				  <div><P> <img src="/images/warning.png">ارسال پیامک بازیابی رمز عبور ممکن است چند دقیقه طول بکشد؛ لطفا شکیبا باشید، وقتی پیامک به دستتان رسید از بخش ورود به سایت با رمز جدید لاگین کنید.  </P></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
