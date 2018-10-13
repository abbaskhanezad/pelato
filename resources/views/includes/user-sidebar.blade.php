
<aside class="main-sidebar" style="direction: rtl" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">

            <div class="pull-right image">
                @if(1)
                    <img src="{{url('/img/avatar/avatar1.png')}}" class="img-circle image-cover-0">


                @else
                    <img src=""  class="img-circle" style="height: 80px;">


                @endif
            </div>


            <div style="padding:0px 10px;">

            </div>

        </div>
        <div style="padding:0px 10px;">

            <a href="#"><i class="fa fa-circle text-success"></i>  {{\Illuminate\Support\Facades\Auth::user()->name}}  عزیز، خوش آمدی </a>




        </div>
        <!--
                <form action="#" method="get" class="sidebar-form">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <input type="text" id="sidebar-nav-doc-search" class="form-control" placeholder="جستجو">
                    </div>
                </form>
        -->
        <ul class="sidebar-menu" id="sidebar-nav-doc" data-widget="tree" style="direction:rtl;">
            <li class="header" style="font-widget:bold;color:green;font-size:16px;">منوی انتخاب</li>

            <li class="active">
                <a href="/centerowner/panel">
                    <i class="fa fa-dashboard"></i>
                    <span>داشبورد</span>
                    <small class="label pull-left bg-green">جدید</small>
                </a>
            </li>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-h-square"></i>
                    <span>  منو اول</span>
                    <span class="pull-left-container">
                        <i class="fa fa-angle-right pull-left"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href=""><i class="fa fa-circle"></i>  زیرمنو اول </a></li>
                    <li><a href=""><i class="fa fa-circle"></i>  زیر منو دوم  </a></li>
                </ul>
            </li>
            -->

            <li>
                <a href="/centerowner/dashboard">
                    <i class="fa fa-eye"></i>
                    <span> مشاهده مرکز </span>
                    <span class="pull-left-container">

                    </span>
                </a>
            </li>
            <li>
                <a href="/centerowner/selectday">
                    <i class="fa fa-clock-o"></i>
                    <span>  زمانبندی مرکز </span>

                </a>
            </li>

            <li >
                <a href="/centerowner/discounts">
                    <i class="fa fa-money"></i>
                    <span> کدهای تخفیف</span>

                </a>
            </li>




        </ul>

    </section>
</aside>
