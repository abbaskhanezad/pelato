<header class="main-header" style=" position: fixed; top:0; left:0; width: 100%;">

    <div href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <i class="fa fa-hand-o-left"></i>
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"> پنل کاربری مرکزداران </span>
    </div>

    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" style="height:49px;">
            <span class="sr-only">Toggle Navigation</span>
        </a>
        <div class="navbar-custom-menu pull-right">
        	<ul class="nav navbar-nav">
                <li class="dropdown user user-menu" style="border-right:1px solid #d2d6de;border-left:1px solid #d2d6de">
                    <a href="">
                        <img src="{{url('/img/pelato.png')}}"  class="user-image">
                        <span class="hidden-xs">{{"بازگشت به صفحه ی اصلی"}}</span> 
                    </a>
               </li>
            </ul>
        </div>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- دکمه کنترل ها -->
                <li>
                   
                </li>



                <li class="dropdown messages-menu">
                    <a href="#"  data-toggle="dropdown">
                 
                    </a>
                    <ul class="dropdown-menu">


                        <li class="footer"><a href="#">   </a></li>
                    </ul>

                </li>

                <li class="dropdown notifications-menu">
                    <a href="#"" data-toggle="dropdown">
                      
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu text-right" style="direction: rtl">
                                <li>

                                </li>
                                <li>

                </li>

                <li class="dropdown tasks-menu">




                        </li>
                        <li class="footer">
                            <a href="#"> </a>
                        </li>
                    </ul>
                </li>


            </ul>





                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        @if(1)
                            <img src="{{url('/img/avatar/avatar1.png')}}"  class="user-image">


                        @else
                            <img src="{{url('/img/avatar/avatar1.png')}}"  class="user-image">


                        @endif
                        <span class="hidden-xs"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- هدر کاربر در هدر -->
                        <li class="user-header">

                            @if(1)
                                <img src="{{url('/img/avatar/avatar1.png')}}"  class="image-cover" style="border-radius: 50%;" >
                            @else
                                <img src="{{url('/img/avatar/avatar1.png')}}"  class="image-cover" style="border-radius: 50%;" >
                            @endif

                            <p>
                                <span></span>
                                <small></small>
                            </p>
                        </li>
                        <!-- بدنه کاربر در هدر -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#"></a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">
                                        <i class="fa fa-user-o"></i>
                                        <p> {{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                                    </a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#"> </a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- فوتر کاربر در هدر-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="/centerowner/profile" class="btn btn-github">پروفایل من</a>
                            </div>
                            <div class="pull-left">
                                <a href="/centerlogout" class="btn btn-google">خارج می شوم</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>