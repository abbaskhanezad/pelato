@extends('layout.users')

@section('content')

    <div class="col-lg-12">
        <section class="panel">

            <header class="panel-heading">
                <a href="{{ route('user.panel.walletLog.index') }}" class="btn btn-primary">تاریخچه کیف پول</a>

                <a href="{{ route('user.panel.wallet.sum') }}" class="btn btn-danger">کیف پول در یک نگاه</a>
            </header>

            <hr>




                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-primary">
                            <div class="panel-heading"> موجودی کیف پول</div>
                            <div class="panel-body">
                                <h1>
                                {{ persianFormat(number_format($sum_wallet)) }}
                                    تومان
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-warning">
                            <div class="panel-heading"> مجموع واریز وجه به کیف پول</div>
                            <div class="panel-body">
                                <h1>
                                    {{ persianFormat(number_format($sum_wallet_money)) }}
                                    تومان
                                </h1>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-info">
                            <div class="panel-heading"> مجموع تبدیل و انتقال امتیاز به کیف پول</div>
                            <div class="panel-body">
                                <h1>
                                    {{ persianFormat(number_format($sum_wallet_point)) }}
                                    تومان
                                </h1>
                            </div>
                        </div>
                    </div>



                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-success">
                            <div class="panel-heading">مجموع رشد کیف پول</div>
                            <div class="panel-body">
                                <h1>
                                    {{ persianFormat(number_format($sum_wallet_increment)) }}
                                    تومان
                                </h1>
                            </div>
                        </div>
                    </div>



                    <div class="col-xs-6 col-md-4">
                        <div class="cardWallet panel panel-danger">
                            <div class="panel-heading">مجموع خرج کرد از کیف پول</div>
                            <div class="panel-body">
                                <h1>
                                    {{ persianFormat(number_format($sum_wallet_decrement)) }}
                                    تومان
                                </h1>
                            </div>
                        </div>
                    </div>



                </div>



        </section>
    </div>



@endsection

