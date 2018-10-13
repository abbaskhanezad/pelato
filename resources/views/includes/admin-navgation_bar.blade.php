@include('includes.admin-header')

@include('includes.admin-sidebar')

<!-- پنل تنظیمات و گزارشات پنهان -->
<aside class="control-sidebar control-sidebar-light">

    <!-- تب ها -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li>
            <a href="#control-sidebar-home-tab" class="kir-abbasi-2" data-toggle="tab">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li>
            <a href="#control-sidebar-settings-tab" class="kir-abbasi-2" data-toggle="tab">
                <i class="fa fa-gears"></i>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">فعالیت ها</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">تولد حسنی</h4>
                            <p>20 اسفند</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">آپدیت پروفایل عباس</h4>

                            <p>تلفن جدید: 091300000</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">عباسی پاش بگا رفت</h4>

                            <p>تو سالن فوتبال با ممدی</p>
                        </div>
                    </a>
                </li>

            </ul>

        </div>

        <!-- Settings tab content -->
        <div class="tab-pane text-right" id="control-sidebar-settings-tab">
            <form method="post">

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                      ایمیل
                        <input type="checkbox" class="pull-left" checked>
                    </label>

                    <p>
                        اجازه به کاربران برای ارسال ایمیل
                    </p>
                </div>

                <h3 class="control-sidebar-heading">تنظیمات گفتگوها</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        آنلاین بودن من را نشان نده
                        <input type="checkbox" class="pull-left" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        اعلان ها
                        <input type="checkbox" class="pull-left">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        حذف تاریخچه گفتگوهای من
                        <a href="javascript:void(0)" class="text-red pull-left"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>

    </div>

</aside>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>


