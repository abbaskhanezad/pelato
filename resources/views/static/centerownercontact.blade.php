@extends('layout.admin')

@push('top_scripts')
@endpush

@push('bottom_scripts')
@endpush

@section('content')
@include('layout.user.error')


   <div id="app">
        <section class="content">
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="fa fa-phone font-dark"></i>
                  <span class="caption-subject bold uppercase">تماس با ما</span>
              </div>
          </div>
          <div class="portlet-body">
            <p>
                <span><b>آدرس:</b> تهران، خیابان ولیعصر، روبروی خیابان بزرگمهر، دانشگاه هنر، واحد کارآفرینی دانشگاه هنر  </span><br/>
                <span><b>تلفن:</b> ۰۲۱۴۴۵۹۲۷۶۸</span><br/>
				<span><b>تلفن همراه:</b> ۰۹۱۲۷۹۲۶۲۶</span><br/>
                <span><b>ایمیل:</b> info@pelato.ir</span><br/>
                <span><b>زمان پاسخگویی:</b> از ۸ صبح الی ۲۰ بعد از ظهر</span><br/>
            </p>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
</section>
</div>
@stop
