@extends('layout.admin')

@push('bottom_scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $( "select.statusPayment" ).change(function () {
            var status = $(this).find('option:selected').val();
            if (status == '4')
            {
                if (confirm('آیا از حذف مطمئن هستید؟'))
                {
                    var id = $(this).data('id');
                    var url = "{{ route('order.update.statusPayment', "id") }}";
                    url = url.replace('id', id);
                    $.ajax({
                        data: {
                            'status_payment_id':status,
                            '_token': $('input[name=_token]').val(),
                            '_method' : 'PUT'
                        },
                        url: url,
                        type: 'PUT',
                        success: function () {
                            alert("بروز رسانی با موفقیت انجام شد.");
                            location.reload();
                        },
                        error: function(){
                            alert('هنگام بروز رسانی خطایی رخ داده است، لطفا دوباره تلاش کنید.');
                        }
                    });
                }
            }
            else
            {
                var id = $(this).data('id');
                var url = "{{ route('order.update.statusPayment', "id") }}";
                url = url.replace('id', id);
                $.ajax({
                    data: {
                        'status_payment_id':status,
                        '_token': $('input[name=_token]').val(),
                        '_method' : 'PUT'
                    },
                    url: url,
                    type: 'PUT',
                    success: function () {
                        alert("بروز رسانی با موفقیت انجام شد.");
                        location.reload();
                    },
                    error: function(){
                        alert('هنگام بروز رسانی خطایی رخ داده است، لطفا دوباره تلاش کنید.');
                    }
                });
            }
        });
    });
</script>
@endpush
@section('content')

    <div id="app">
        <section class="content">

            <div id="message" class="text-center" style="font-weight:bold;">
                @include('layout.user.error')
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-ticket font-dark"></i>
                                <span class="caption-subject bold uppercase">لیست رزروها</span>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <p>سابقه رزرومرکز شما برای مشتریان مرکز:</p>
                            <div class="col-md-12" style="overflow-x: scroll">
                                <div class="col-xs-12 hidden-lg hidden-md">


                                    <span class="badge badge-warning"></span>


                                </div>
                                @if(count($orders)==0)
                                    <div class="alert alert-warning" role="alert">
                                        رزروی از طرف مرکز ثبت نشده است
                                    </div>
                                @else
                                    <table class="table  table-bordered table-hover table-checkable order-column hidden-lg hidden-md" id="order_list" style="font-size:7px;font-weight:bold;">
                                        <thead>
                                        <tr>
                                            <th> کاربر </th>
                                            <th> مبلغ پرداختی </th>
                                            <th> تاریخ رزرو </th>
                                            <th> اسم مرکز </th>
                                            <th> نحوه پرداخت </th>
                                            <th> عملیات  </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders as $c => $o)
                                            <tr>
                                                @if(\App\ReservableCenter::find(\App\Room::find($o['room_id'])->reservable_center_id)->id==$center->id)






                                                    <td> {{ \App\User::find($o['user_id'])->name }} <br/> {{\App\User::find($o['user_id'])->mobile}} </td>
                                                    <td> {{ $o['whole_price'] * 1000 }}تومان  </td>
                                                    <td>{{\Morilog\Jalali\jDate::forge($o['created_at'])->format("H:i")}}  {{ jalali_date($o['created_at']) }}    </td>
                                                    <td> {{\App\Room::find($o['room_id'])->name}}</td>


                                                    <td>
                                                        @if($o['status_payment_id']==1)
                                                            <span>آنلاین</span>
                                                        @elseif($o['status_payment_id']==2)
                                                            <span>کارت به کارت</span>
                                                        @elseif($o['status_payment_id']==3)
                                                            <span>حضوری</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="/centerowner/{{$o['id']}}/delete">حذف سفارش</a>

                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        {{csrf_field()}}
                                        </tbody>
                                    </table>
                                @endif

                                <div class="col-xs-12 hidden-lg hidden-md">


                                    <span class="badge badge-warning"></span>


                                </div>
                            </div>

                            {{--{{ $orders->links() }}--}}
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </section>
    </div>
@stop
