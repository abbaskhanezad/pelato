<!DOCTYPE html>
<html lang="en">
<head>
  <title>ورود به پنل مدیران مراکز</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="/img/icons/favicon.ico"/>
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="/fonts/iconic/css/material-design-iconic-font.min.css">

  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="/vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="/css/util.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('fonts/sans/iransans.css')}}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="limiter">
  <div class="container-login100" style="background-image: url('img/bg-01.jpg');">
    <div class="wrap-login100" style="direction:rtl;">

      <div class="text-center" style="font-size: 18px;font-weight: bold;">
        @include('layout.user.error')

      </div>






        <span class="login100-form-logo">
						<img src="/img/avatar-01.jpg" class="img-circle" alt="AVATAR">
					</span>



        <div style="font-family: IRANSans;font-size:25px;font-weight:bold;padding:10px; color:white;" class="text-center">
بازیابی کلمه عبور
        </div>

      <form class="form-horizontal" role="form" method="POST" action="{{ url('/centerowner/reset/done') }}">
        {{ csrf_field() }}


      <div class="wrap-input100 validate-input" data-validate = "شماره موبایل را وارد نمایید">
          <input  class="input100  text-center" style="font-weight:bold;font-size:18px;font-family:'IRANSans'; " type="text" name="phone" id="phone" placeholder=" شماره موبایل را وارد نمایید">
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>




        <div class="container-login100-form-btn">
          <button type="submit" class="login100-form-btn" style="font-weight:bold;font-size:20px;">
            بازیابی
          </button>
        </div>
        </form>
      <div><P> <img src="/images/warning.png">ارسال پیامک بازیابی رمز عبور ممکن است چند دقیقه طول بکشد؛ لطفا شکیبا باشید، وقتی پیامک به دستتان رسید از بخش ورود به سایت با رمز جدید لاگین کنید.  </P></div>

        <div class="text-center p-t-90">
          <a class="txt1" href="#"  style="color:black;">
            رمز عبور را فراموش کرده اید؟
          </a>
        </div>
    </div>
  </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->


<!--===============================================================================================-->
<!--===============================================================================================-->
<!--===============================================================================================-->
<!--===============================================================================================-->
<script src="/js/main.js"></script>

</body>
</html>