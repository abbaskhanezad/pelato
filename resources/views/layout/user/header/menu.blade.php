<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu  ">
    <ul class="nav navbar-nav">
        <li class="">
            <a href="/"> صفحه اصلی
            </a>
        </li>
        <li class="">
            <a href="/centers/"> لیست مراکز
            </a>
        </li>
        <?php /*
                                  <li class="menu-dropdown clasic-menu-dropdown">
                                      <a href="/centers/"> لیست مراکز
                                      </a>
                                      <ul class="dropdown-menu">
                                        @foreach($center_type_menu as $ctm)
                                          <li class=" ">
                                              <a href="/centers/type/{{ $ctm->id }}" class="nav-link  "> {{ $ctm->name}} ({{ $ctm->reservable_center->count()}})</a>
                                          </li>
                                        @endforeach
                                      </ul>
                                  </li>
                                  */?>
        @if(isset(Auth::user()->type)&&Auth::user()->type == 3)
            <li class="menu-dropdown classic-menu-dropdown ">
                <a href="#"> مدیریت
                    <span class="arrow"></span>
                </a>
                <ul class="dropdown-menu pull-left">

                    <li class="">
                        <a href="/admin/comment"> تایید نظرات
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="dropdown-submenu ">
                        <a href="javascript:;"> مراکز
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class=" ">
                                <a href="/reservable_center" class="nav-link  "> لیست</a>
                            </li>
                            <li class=" ">
                                <a href="/center_type" class="nav-link  "> انواع </a>
                            </li>
                            <li class=" ">
                                <a href="/center_attribute" class="nav-link  "> ویژگی ها</a>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown-submenu ">
                        <a href="javascript:;"> کاربران
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class=" ">
                                <a href="{{ route('users.center_owner') }}" class="nav-link  "> مرکزداران</a>
                            </li>
                            <li class=" ">
                                <a href="/user" class="nav-link  "> همه کاربران </a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="/orders_all"> مشاهده تمام سفارشات
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="/user/mostReserve/list"> مشاهده کاربران بر اساس رزرو
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="">
                        <a href="/admin/discounts"> مدیریت کدهای تخفیف
                            <span class="arrow"></span>
                        </a>
                    </li>

                    <li class="">
                        <a href="/sendmessage"> ارسال پیامک
                            <span class="arrow"></span>
                        </a>
                    </li>


                </ul>
            </li>
        @elseif(isset(Auth::user()->type)&&Auth::user()->type == 2)
            <li class="menu-dropdown classic-menu-dropdown ">
                <a href="/dashboard"> داشبورد مرکز
                    <span class="arrow"></span>
                </a>

            <li class="">
                <a href="/timing"> تنظیم برنامه هفته
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="">
                <a href="/orders_detail"> مشاهده سفارشات ثبت شده از سایت پلاتو
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="">
                <a href="/myorders_detail"> مشاهده سفارشات مرکز
                    <span class="arrow"></span>
                </a>
            </li>

            </li>
        @elseif(isset(Auth::user()->type)&&Auth::user()->type == 4)
            <li class="menu-dropdown classic-menu-dropdown ">
                <a href="#"> مدیریت
                    <span class="arrow"></span>
                </a>
                <ul class="dropdown-menu pull-left">
                    <li class="">
                        <a href="/user"> کاربران
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="dropdown-submenu ">
                        <a href="javascript:;"> مراکز
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li class=" ">
                                <a href="/reservable_center" class="nav-link  "> لیست</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif
        {{-- {{ route('reservable_center.createForm') }} --}}
        <li class="">
            <a href="{{ route('reservable_center.createForm') }}">ثبت مرکز جدید
            </a>
        </li>

        <li class="">
            <a href="/contact"> تماس با ما
            </a>
        </li>

        @if(!\Auth::check())
            <li class="">
                <a href="/login"> ورود</a>
            </li>
            <li class="">
                <a href="/register"> ثبت نام</a>
            </li>
        @endif

    </ul>
</div>
<!-- END MEGA MENU -->
