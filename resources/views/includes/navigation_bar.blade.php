
<!-- برای هدربالایی ک قرار است فیکس شود -->
<nav class="navbar navbar-default top-nav-fixed">
    <div class="container">
        <ul class="navbar-header navbar-right">
            <!-- دکمه باز شو-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" style="border-left: 1px solid #5bc0de;">
                {{ config('app.name', 'Laravel') }}
            </a>
            <img src="{{asset('images/logo.jpg')}}" class="navbar-logo">
        </ul>

        <ul class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;<!-- Authentication Links -->
                @if (Auth::check())
					<?php $user= \App\User::find(Auth::user()->id); ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            @if(count($user->image) >=1 )
                                <img src={{url('uploads_photo').'/'.$user->image->name}}  class="user-image">
                            @else
                                <img src={{url('image/dr.jpg')}}  class="user-image">
                            @endif
                            <span class="hidden-xs">{{$user->name}}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <!-- هدر کاربر در هدر -->
                            <li class="user-header">

                                @if(count($user->image) >=1 )
                                    <img src={{url('uploads_photo').'/'.$user->image->name}}  class="image-cover" style="border-radius: 50%;">
                                @else
                                    <img src={{url('image/dr.jpg')}}  class="image-cover" style="border-radius: 50%;">
                                @endif

                                <p>
                                    <a href="{{route('user.home')}}" class="btn btn-danger text-black" style="background-color: transparent">
                                        {{"ورود به پورتال من"}}
                                    </a>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{Route('profile.index')}}" class="btn btn-github">پروفایل من</a>
                                </div>
                                <div class="pull-left">
                                    <a href="{{ route('logout') }}" class="btn btn-yahoo"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span>خارج می شوم</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                @elseif(session()->has('doctor-id'))
                    <?php $doctor= \App\Doctor::find(session('doctor-id')); ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class=" btn btn-github dropdown-toggle" style="background-color: transparent" data-toggle="dropdown" aria-expanded="true">
                            @if($doctor->doctor_image)
                                <img src="{{url('uploads_photo').'/'.$doctor->doctor_image}}"  class="user-image">
                            @else
                                <img src="{{url('image/dr.jpg')}}"  class="user-image">
                            @endif
                            <span class="hidden-xs">{{$doctor->name}}</span>
                        </a>

                        <ul class="dropdown-menu" style="border: 1px solid #f7ebeb;">
                            <!-- هدر کاربر در هدر -->
                            <li class="user-header">

                                @if($doctor->doctor_image != null)
                                    <img src="{{url('uploads_photo').'/'.$doctor->doctor_image}}"  class="image-cover" style="border-radius: 50%;" >
                                @else
                                    <img src="{{url('image/dr.jpg')}}"  class="image-cover" style="border-radius: 50%;" >
                                @endif

                                <p>
                                    <a href="{{route('doctorHome')}}" class="btn btn-warning text-black" style="background-color: transparent">
                                        {{"ورود به پورتال من"}}
                                    </a>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{Route('Profile.index')}}" class="btn btn-github">پروفایل من</a>
                                </div>
                                <div class="pull-left">
                                    <a href="{{route('docLogout')}}" class="btn btn-google">خارج می شوم</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <span>{{"ورود"}}</span>
                        </a>
                        <ul class="dropdown-menu" style="border: 1px solid #f7ebeb;">
                            <li class="user-header">
                                <p>
                                    <small class="text-danger">سلامتی شما آرزوی ماست</small>
                                </p>
                                <img src={{url('images/logo.jpg')}}  class="image-cover" style="padding:10px;">
                            </li>
                            <!-- بدنه کاربر در هدر -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a class="btn btn-primary" style="background-color: transparent" href="{{asset('login')}}">کاربر</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a class="btn btn-danger" style="background-color: transparent" href="{{Route('docLogin')}}">پزشک</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>

                        </ul>

                    </li>

                    <li class="dropdown user user-menu">
                        <a class="btn btn-default sign-up-button" href="#" data-toggle="dropdown">
                            <i class="ion ion-android-arrow-dropdown" aria-hidden="true"></i>
                            <span style="font-size: 14px;"> ثبت نام </span>
                            <i class="ion ion-compose"></i>
                        </a>
                        <ul class="dropdown-menu" style="border: 1px solid #f7ebeb;">
                            <li class="user-header">
                                <p>
                                    <small class="text-danger">با ما همراه شوید</small>
                                </p>
                                <img src={{url('images/logo.jpg')}}  class="image-cover" style="padding:10px;">
                            </li>
                            <li class="user-body" style="background-color: #f3ffe8">
                                <div class="row text-center">
                                    <div class="col-sm-4">
                                        <div>
                                            <a href="{{Route('docRegister')}}" class="btn btn-primary text-black" style="background-color: transparent">
                                                <i class="ion ion-heart"></i>
                                                {{"پزشک"}}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-4">
                                        <div>
                                            <a href="{{Route('register')}}" class="btn btn-warning text-black"style="background-color: transparent">
                                                <i class="ion ion-person-stalker"></i>
                                                {{"کاربر"}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{route('workus')}}">
                        <span>{{"همکاری با ما"}}</span>
                        <i class="fa fa-handshake-o text-green"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('about')}}">
                        <span>{{"درباره ما"}}</span>
                        <i class="fa fa-bullhorn text-green"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('roles')}}">
                        <span>{{"قوانین و مقررات"}}</span>
                        <i class="fa fa-envelope-open-o  text-green"></i>
                    </a>
                </li>
            </ul>

        </ul>
    </div>
</nav>