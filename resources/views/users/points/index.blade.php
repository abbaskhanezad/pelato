@extends('layout.users')

@section('content')

    <div class="col-lg-12">
        <section class="panel">

            @include('users.sections.errorMsg')
            @include('users.sections.statusMsg')
            <header class="panel-heading">
                <button href="" id="changePointToWallet" class="btn btn-block btn-warning">درخواست انتقال
                    امتیازها به کیف پول</button>
                <div class="formCountPoint" id="formCountPoint">
                    <div class="panel-body">

                        <form action="{{ route('user.panel.points.changeToWallet') }}" method="get" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="countPoint">تعداد امتیازی که می خواهید به کیف پول انتقال یابد را وارد نمایید</label>
                                <input type="text" id="countPoint"  name="countPoint" class="form-control">
                            </div>
                            <button  class="btn btn-success">انتقال به کیف پول</button>
                            <span class="pricePoints" id="pricePoints"></span>

                        </form>






                    </div>
                </div>

            </header>

            <hr>


            <div class="row">



                <div class="col-xs-12 col-md-4 col-md-offset-4">
                    <div class="cardWallet panel panel-warning">
                        <div class="panel-heading">مجموع کل امتیازهای شما
                        </div>
                        <div class="panel-body">
                            <h1>
                                {{ $totalPoints }}
                            </h1>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

            @foreach($sumPointsArray as $sumPointID=>$sumPointValue)
                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-primary">
                            <div class="panel-heading">مجموع امتیازهای شما از
                            {{ $allPointItems[$sumPointID] }}
                            </div>
                            <div class="panel-body">
                                <h1>
                                    {{ $sumPointValue }}
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>


        </section>
    </div>



@endsection

