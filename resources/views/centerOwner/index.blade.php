@extends('layout.admin')

@section('content')
    <div id="app">
        <section class="content">
            <div class="row">

<a href="/centerowner/selectday">
            <div class="col-md-3 col-xs-12"style="border-radius:10px;">
			
                     <div class="info-box"style="border-radius:10px;">
					 
                        <span class="info-box-icon bg-red" style="border-bottom-right-radius: 10px;border-top-right-radius: 10px;"><i class="glyphicon glyphicon-time"></i></span>
                    
						<div class="info-box-content text-center"style="border-radius:10px;">
                            <span class="info-box-text"> زمانبندی</span>
                            <small class="info-box-text" style="font-size: 10px;">برای تنظیم زمانبندی مرکز کلیک نمایید</small>
                            <span class="info-box-number" style="direction: rtl">
                            </a>
                            <small>  <a href="/centerowner/selectday">ورود به زمانبندی</a></small>
                        </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xs-12" style="border-radius:10px;">
                    <div class="info-box" style="border-radius:10px;">
                        <span class="info-box-icon bg-yellow" style="border-bottom-right-radius: 10px;border-top-right-radius: 10px;"><i class="glyphicon glyphicon-star"></i></span>
                        <div class="info-box-content text-center" style="border-radius:10px;">
                            <span class="info-box-text">امتیاز مرکز شما</span>
                            <small class="info-box-text" style="font-size: 10px;">میانگین امتیاز کاربران به مرکز شما</small>
                            <span class="info-box-number" style="direction: rtl">
                            <span>

                                <?php
                                    use App\Starrating;
                                // $star=round(Starrating::where('center_id',$reservable_center->id)->avg('star'));
                                $nezafat=round(Starrating::where('center_id',$reservable_center->id)->avg('nezafat'));
                                $tajhizat=round(Starrating::where('center_id',$reservable_center->id)->avg('tajhizat'));
                                $khadamat=round(Starrating::where('center_id',$reservable_center->id)->avg('khadamat'));
                                $star=floor(($nezafat+$khadamat+$tajhizat)/3);
                                $count=Starrating::where('center_id',$reservable_center->id)->count();
                                // echo $reservable_center->id;
                                // $star=3;
                                ?>
                                @for($r=0;$r<5;$r++)

                                    @if($r<$star)
                                        <span style="font-size: large; font-weight: bold; color:gold;" data-value="{{$r}}" class="fa fa-star check"></span>
                                    @else
                                        <span  style="font-size: large; font-weight: bold;" data-value="{{$r}}" class="fa fa-star-o"></span>
                                    @endif
                                @endfor


                            </span>
                            <small></small>
                        </span>
                            <span>   {{'('}}
                                {{'از    '}}{{$count}}{{'  رای'}}
                                {{')'}}
</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12" style="border-radius:10px;">
                    <div class="info-box" style="border-radius:10px;">
                        <span class="info-box-icon bg-aqua" style="border-bottom-right-radius: 10px;border-top-right-radius: 10px;"><i class="glyphicon glyphicon-comment"></i></span>
                        <div class="info-box-content text-center" style="border-radius:10px;">
                            <span class="info-box-text">کامنت ها</span>
                            <small class="info-box-text" style="font-size: 10px;">نظرات ثبت شده برای شما</small>
                            <span class="info-box-number" style="direction: rtl">
                            <span>{{$commentcount}}</span>
                            <small>{{"نظر "}}</small>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12"style="border-radius:10px;">
                    <div class="info-box"style="border-radius:10px;">
                        <span class="info-box-icon bg-green" style="border-bottom-right-radius: 10px;border-top-right-radius: 10px;"><i class="glyphicon glyphicon-list-alt"></i></span>
                        <div class="info-box-content text-center"style="border-radius:10px;">
                            <span class="info-box-text">   ساعات رزرو شده</span>
                            <small class="info-box-text" style="font-size: 10px;">تعداد کل ساعات رزروشده</small>
                            <span class="info-box-number" style="direction: rtl">
                            <span>{{$timecount}}</span>
                            <small>{{"ساعت "}}</small>
                        </span>
                        </div>
                    </div>
                </div>
              

            </div>
			<div class="row">
  <div class="col-md-3 col-xs-12"style="border-radius:10px;">
                    <div class="info-box"style="border-radius:10px;">
                        <span class="info-box-icon bg-orange"  style="border-bottom-right-radius: 10px;border-top-right-radius: 10px;"><i class="glyphicon glyphicon-usd"></i></span>
                        <div class="info-box-content text-center"style="border-radius:10px;">
                            <span class="info-box-text"> درآمد</span>
                            <small class="info-box-text" style="font-size: 10px;">درآمد شما از سایت پلاتو</small>
                            <span class="info-box-number" style="direction: rtl">
                            <span>{{number_format($income)}}</span>
                            <small>{{"تومان "}}</small>
                        </span>
                        </div>
                    </div>
                </div>

			
			</div>
        </section>
    </div>
@endsection



