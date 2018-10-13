@extends('layout.user')

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
    @include('layout.user.error')
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
                    <p>سابقه رزرومرکز شما از سایت پلاتو:</p>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="order_list">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> کاربر </th>
                            <th> جزئیات رزرو </th>
                            <th> مبلغ پرداختی </th>
                            <th> تاریخ رزرو </th>
                            <th> اسم مرکز </th>
                            <th> نحوه پرداخت </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $c => $o)
                            <tr>
                                @if(\App\ReservableCenter::find(\App\Room::find($o['room_id'])->reservable_center_id)->id==$center->id)






                                <td> {{ $loop->iteration }} </td>
                                <td> {{ \App\User::find($o['user_id'])->name }} <br/> {{\App\User::find($o['user_id'])->mobile}} </td>
                                <td> <a href="myorders/{{$o['id']}}">مشاهده</a> </td>
                                <td> {{ $o['whole_price'] * 1000 }}تومان  </td>
                                <td>{{\Morilog\Jalali\jDate::forge($o['created_at'])->format("H:i")}}  {{ jalali_date($o['created_at']) }}    </td>
                                <td>{{ \App\ReservableCenter::find(\App\Room::find($o['room_id'])->reservable_center_id)->name }} - {{\App\Room::find($o['room_id'])->name}}</td>


                                <td>
                                    @if($o['status_payment_id']==1)
                                        <span>آنلاین</span>
                                    @elseif($o['status_payment_id']==2)
                                        <span>کارت به کارت</span>
                                    @elseif($o['status_payment_id']==3)
                                        <span>حضوری</span>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        {{csrf_field()}}
                        </tbody>
                    </table>
                    {{--{{ $orders->links() }}--}}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@stop
