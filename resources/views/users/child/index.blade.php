@extends('layout.users')

@section('content')

    <div class="col-lg-12" id="wallet_history">
        <section class="panel">

            <header class="panel-heading alert alert-info">
                لیست زیرمجموعه های شما و تعداد امتیاز کسب شده از طریق زیرمجموعه ها
            </header>


            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th><i class="icon-bullhorn"></i>شناسه</th>
                    <th class="hidden-phone"><i class="icon-question-sign"></i>نام</th>
                    <th><i class=" icon-edit"></i>تعداد امتیاز کسب شده شما از این زیرمجموعه</th>
                </tr>
                </thead>
                <tbody>
                @foreach($child as $children)
                    <tr>
                        <td>{{ persianFormat($loop->iteration) }}</td>
                        <td>{{ $children->userFullName }}</td>
                        <td>{{ persianFormat(($children->order_room->count()) * ($pointCount_reserve)) }}</td>
                    </tr>
                @endforeach


                </tbody>
            </table>


        </section>
    </div>



@endsection

