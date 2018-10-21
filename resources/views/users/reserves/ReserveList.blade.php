@extends('layout.users')

@section('style')
    <style>
        .boxContent{
            margin-top: 30px;
        }
    </style>

@endsection




@section('content')



<div class="boxContent">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">لیست روز و ساعات رزرو</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="order_list">
                    <thead>
                    <tr>
                        <th> اتاق</th>
                        <th> روز</th>
                        <th> ساعات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX">
                        <td rowspan="3"> اتاق یک</td>
                        <td rowspan="1"> دوشنبه</td>
                        <td> 10 - 11</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td rowspan="1"> سه شنبه</td>
                        <td> 8 - 10</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td rowspan="1"> پنج شنبه</td>
                        <td> 9 - 10</td>
                    </tr>


                    </tbody>
                </table>
                <div class="row"><span class="pull-right">مبلغ پرداختی: 44000 تومان</span></div>

                <div class="row text-center" style="padding-top:10px;">

                    <div class="col-md-12" id="order_price">
                        <div style="width:90%;margin:auto;;border:1px solid #62b965">
                            <span style="padding-right:5px;line-height:70px;">در صورت داشتن کد تخفیف وارد نمایید</span>

                            <span class="text-center"><input name="discounts" value="" id="discounts" type="text"
                                                             style="border:1px solid #eeeff1;font-size:15px;font-family:Yekan;"></span>

                            <span><input type="button" class="btn btn-success" onclick="check()" value="بررسی"
                                         style="background:#62b965;border:1px solid #62b965;font-size:13px;color:#ffffff;width:80px;margin-right:5px;height:27px;line-height:8px;padding:5px;"></span>
                            <hr>
                            <span style="color: red;" id="show"></span>
                        </div>

                        <div style="width:90%;margin:auto; padding-top: 5px;">
                            <p style="padding-top:10px;"><span style="color:#ff0000">هزینه کل</span> : <span
                                        style="font-family:sans-serif">
                      44,000
                    </span> تومان</p>
                            <p style="padding-top:10px;"><span style="color:#ff0000">هزینه قابل پرداخت</span> :
                                <span style="font-family:sans-serif" id="pardakhti">

                            44,000
                    </span> تومان</p>

                        </div>

                    </div>


                </div>

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

</div>


@endsection

