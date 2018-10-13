@extends('layout.admin')

@section('content')

    <div id="app">
        <section  class="content">
            <div class="row text-center">
                @include('layout.user.error')
            </div>
            <div  style="border: 1px solid #EBEBEB;width:100%;background:white">

                <div class="content_title" style="width:100%;">
                    <p style="margin-right:20px;padding-top:10px;">افزودن کد تخفیف</p>
                </div>


                <form method="post" action="{{ url('centerowner/discounts') }}">
                    {{ csrf_field() }}
                    <table class="table">

                        <tr>
                            <td style="width:100px;">کد تخفیف: </td>
                            <td><input type="text"  name="discounts_name" class="form-control">
                                @if ($errors->has('discounts_name'))
                                    <small class="help-block">
                                        <strong>{{ $errors->first('discounts_name') }}</strong>
                                    </small>
                                @endif
                            </td>

                        </tr>


                        <tr>
                            <td style="width:100px;">درصد تخفیف: </td>
                            <td><input type="number" name="discounts_value" class="form-control">
                                @if ($errors->has('discounts_value'))
                                    <small class="help-block">
                                        <strong>{{ $errors->first('discounts_value') }}</strong>
                                    </small>
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td style="width:100px;">ظرفیت : </td>
                            <td><input type="number"  name="capacity" class="form-control" value="10">
                                @if ($errors->has('capacity'))
                                    <small class="help-block">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                    </small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:100px;">اولویت : </td>
                            <td>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="0">عمومی</option>
                                    <option value="1">اختصاصی</option>

                                </select>

                                @if ($errors->has('priority'))
                                    <small class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </small>
                                @endif
                            </td>

                        </tr>




                        <tr>
                            <td >
                                <input type="submit" class="btn btn-info"  value="ثبت">
                            </td>
                        </tr>

                    </table>
                </form>



                @if(sizeof($Discounts)>0)
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <table  class="table table-striped text-center" style="font-size:7px;font-weight:bold;" id="tbl_list" style="padding:5px;">
                                <tr style="font-size:11px;">
                                    <th>ردیف</th>
                                    <th>کد تخفیف</th>
                                    <th>مقدار تخفیف</th>
                                    <th>ظرفیت باقی مانده </th>
                                    <th> اولویت  </th>
                                    <th>عملیات</th>
                                </tr>
                                <?php
                                $i=0;
                                ?>
                                @foreach($Discounts as $key=>$value)
                                    <?php
                                    $i++;
                                    ?>
                                    <tr class="text-center"  style=" font-size:15px;">
                                        <td style="border:1px solid black";>{{ $i }}</td>
                                        <td style="border:1px solid black";><?= $value['discounts_name'] ?></td>
                                        <td style="border:1px solid black";><?= $value['discounts_value'] ?></td>
                                        <td style="border:1px solid black";><?= $value['capacity'] ?></td>
                                        <td style="border:1px solid black";><?php if($value['priority']==0){echo "عمومی";} else{ echo "اختصاصی";} ?></td>

                                        <td style="border:1px solid black";>

                                            @php

                                                $user_id=\Illuminate\Support\Facades\Auth::user()->id;
                                                $center=\App\ReservableCenter::where('user_id',$user_id)->first();
                                                $center_name=\App\ReservableCenter::find($center->id)->first();

                                            @endphp
                                            <span onclick="teleShare('{{ $value['discounts_name']}}' ,'{{ $value['discounts_value']}}','{{$center->id}}','{{$center->name}}')" style="color: blue; font-size:26px;" class="fa fa-telegram"></span>
                                            <span onclick="del_row('<?=  $value['id'] ?>')" style="color: red; font-size:17px;" class="glyphicon glyphicon-remove"></span>

                                        </td>
                                    </tr>
                                @endforeach



                            </table>
                        </div>
                    </div>
                @else
                    <div class="row" style="margin:10px;">
                        <div class="alert alert-warning text-center">
                            درحال حاضر کد تخفیفی ثبت نشده است
                        </div>
                    </div>
                @endif
                <div style="clear:both"></div>

            </div>
        </section>
    </div>
@endsection


@section('bottom_scripts')


    <script type="text/javascript">

        function del_row(id)
        {
                    <?php
                    $token=Session::token();
                    ?>
            var route='<?= url("centerowner/discounts")."/" ?>';
            if (!confirm("آیا از حذف این رکورد اطمینان دارید !"))
                return false;
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action",route+id);
            var hiddenField1 = document.createElement("input");
            hiddenField1.setAttribute("name", "_method");
            hiddenField1.setAttribute("value",'DELETE');
            form.appendChild(hiddenField1);
            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("name", "_token");
            hiddenField2.setAttribute("value",'<?= $token ?>');
            form.appendChild(hiddenField2);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

    </script>

    <script type="text/javascript">
        //تابع اشتراک گذاری را تعریف می کنیم
        function teleShare($code,$percent,$id,$name) {

//خط پایین، یک پنجره باز میکند که از کاربر سوال میکند آیا میخواهد آدرس این صفحه را در تلگرام به اشتراک بگذارد؟
            var r = confirm("آیا مایل به اشتراک گذاری این کد در تلگرام هستید؟");

// اگر کاربر روی دکمه اوکی کلیک کرد، کاربر را به اپلیکیشن تلگرام هدایت میکنیم.
//و ازش میخواهیم که یک چت را برای اشتراک گذاری آدرس انتخاب کند
            if (r == true) {
                window.location.replace('tg://msg?url=www.e.pelato.ir/centers/'+$id+'&text=کد تخفیف '+$percent+"  درصدی مرکز "+$name + $code +" می باشد.  ");
            }
        }
    </script>



@endsection