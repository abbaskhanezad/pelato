<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('includes.admin-head')

@yield('style')
@stack('top_scripts')
@yield('header')


<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper" style="font-family: IRANSans;">

    @include('includes.user-navgation_bar')

    <div class="content-wrapper text-right" style="padding-top: 100px;" >

        @yield('content')

    </div>
    <div class="main-footer">

        @include('includes.admin-footer')

    </div>
</div>

@yield('script')
@yield('footer')
@yield('bottom_scripts')
@stack('bottom_scripts')

</body>
</html>
