@include('layout.user.head')
    <body class="page-container-bg-solid page-md">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                  @include('layout.user.header')
                </div>
            </div>
            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                  @include('layout.user.content')
                </div>
            </div>
            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                  @include('layout.user.footer')
                </div>
            </div>
        </div>
        @include('layout.user.scripts')
        @yield('bottom_scripts')
    </body>
</html>
