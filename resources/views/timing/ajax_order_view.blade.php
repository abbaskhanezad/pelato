<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">جزئیات سفارش #{{ $order->id }}</span>
              </div>
          </div>
          <div class="portlet-body">
              <p>
                <b>اطلاعات سفارش دهنده</b><br/>
                <span>نام:</span> <span>{{ $order->user->name }} {{ $order->user->family }}</span><br/>
                <span>تلفن تماس:</span> <span>{{ $order->user->mobile }}</span><br/>
                <span>پست الکترونیکی:</span> <span>{{ $order->user->email }}</span><br/>
				<span>نحوه پرداخت : </span> <span>{{ \App\StatusPayment::find($order->status_payment_id)->title }}</span> <br/>
				@if(auth()->user()->type==3)
                    @php
                        $statusPayments = \App\StatusPayment::all();
                    @endphp
                  <form action="{{ route('order.update.statusPayment', ['id' => $order->id]) }}" method="post" >
                      {{csrf_field()}}
                      {{method_field('put')}}
                      <input type="hidden" value="4" name="status_payment_id">
                      <button type="submit" class="btn btn-danger btn-sm">حذف سفارش</button>
                  </form>
                @endif
              </p>
              <p><b>لیست ساعات رزرو شده</b><p>
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="order_list">
                  <thead>
                      <tr>
                          <th> اتاق </th>
                          <th> روز</th>
                          <th> ساعات </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($timing_list_to_show as $room_key => $room)
                    <?php $newline = false; ?>
                    <tr class="odd gradeX">
                      <td rowspan="{{ $room_mapper[$room_key]["count"] }}"> {{$room_mapper[$room_key]["name"] }} </td>
                      @foreach($room as $day_key => $day)
                        @if($newline)
                          <tr class="odd gradeX">
                          <?php $newline = false; ?>
                        @endif
                        <td rowspan="{{count($day) }}"> {{$day_mapper[$day_key] }} </td>
                          @foreach($day as $hour)
                            @if($newline)
                              <tr class="odd gradeX">
                              <?php $newline = false; ?>
                            @endif
                            <td> {{$hour["start_hour"] }} - {{$hour["end_hour"] }} </td>
                            </tr>
                            <?php $newline = true; ?>
                          @endforeach
                        </tr>
                        <?php $newline = true; ?>
                      @endforeach
                    </tr>
                    @endforeach
                  </tbody>
              </table>
              <div class="row"><span class="pull-right">مبلغ پرداختی: {{$full_price * 1000 }} تومان</span></div>
          </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
