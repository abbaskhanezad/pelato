@extends('layout.users')

@section('content')

    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading">

                <a href="{{ route('user.panel.walletLog.index') }}" class="btn btn-primary">تاریخچه کیف پول</a>

                <a href="{{ route('user.panel.wallet.sum') }}" class="btn btn-danger">کیف پول در یک نگاه</a>
            </header>

            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i>شناسه</th>
                    <th class="hidden-phone"><i class="icon-question-sign"></i>مبلغ</th>
                    <th><i class="icon-bookmark"></i>روش ایجاد از طریق</th>
                    <th><i class=" icon-edit"></i>افزایش / کاهش</th>
                    <th><i class=" icon-edit"></i>تاریخ</th>
                </tr>
                </thead>
                <tbody>
                @foreach($walletLogs as $walletLog)
                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td class="hidden-phone">{{ persianFormat(number_format($walletLog->price)) }}</td>
                        <td>
                            @foreach($methodsCreateWallet as $key=>$value)
                                @if($key == $walletLog->method_create)
                                    {{ $value }}
                                @endif
                            @endforeach
                        </td>
                        <td><span class="label
                         label-{{ ($walletLog->wallet_operation == \App\WalletLog::INCREMENT) ? 'info' : 'danger'}}
                                    label-mini">
                                 @foreach($walletOperations as $key=>$value)
                                    @if($key == $walletLog->wallet_operation)
                                        {{ $value }}
                                    @endif
                                @endforeach
                             </span></td>
                        <td>
                            {{  persianFormat((string)$walletLog->created_at) }}
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </section>
    </div>



@endsection

