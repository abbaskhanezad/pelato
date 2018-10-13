@extends('layout.user')

@section('content')
<div class="row text-center">
    @include('layout.user.error')
</div>
 <div  style="border: 1px solid #EBEBEB;width:85%;margin:50px auto;background:white">

        <div class="content_title" style="width:100%;">
            <p style="margin-right:20px;padding-top:10px;">افزودن کد تخفیف</p>
        </div>


          <form method="post" action="{{ url('admin/discounts') }}">
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
                  <td style="width:100px;">ازطرف : </td>
                  <td>
                      <select  class="form-control" id="center_id" name="center_id">
                          <option value="0">سایت پلاتو</option>
                          @foreach($centers as $center)
                              <option value="{{$center->id}}"> {{$center->name}}</option>


                          @endforeach

                      </select>

                      @if ($errors->has('priority'))
                          <small class="help-block">
                              <strong>{{ $errors->first('priority') }}</strong>
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


    <tr id="showtr">
        <td style="width:100px; ">حالت نمایش: </td>
        <td>
            <select class="form-control" id="Show" name="show">
                <option value="1"> نمایش</option>
                <option value="0">عدم نمایش</option>

            </select>

            @if ($errors->has('Show'))
                <small class="help-block">
                    <strong>{{ $errors->first('Show') }}</strong>
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
        <table  class="table" id="tbl_list">
                    <tr>
                        <th>ردیف</th>
                        <th>کد تخفیف</th>
                        <th>مقدار تخفیف</th>
                        <th> از طرف </th>
                        <th>ظرفیت باقی مانده</th>
                        <th> اولویت  </th>
                        <th>حذف</th>
                    </tr>
                    <?php
                    $i=0;
                    ?>
                    @foreach($Discounts as $key=>$value)
       <?php
                     $i++;
                    ?>
                    <tr class="text-center">
<td>{{ $i }}</td>
                                      <td><?= $value['discounts_name'] ?></td>
                                      <td><?= $value['discounts_value'] ?></td>
                        <td>
                            <?php $center_id=$value['center_id'] ;
                                if($center_id<>0){
                                    $center=\App\ReservableCenter::where('id',$center_id)->first();
                                    echo $center->name;
                                }else{
                                    echo 'pelato.ir';
                                }


                            ?>
                        </td>

                        <td><?= $value['capacity'] ?></td>
                        <td><?php if($value['priority']==0) echo 'عمومی'; if($value['priority']==1) echo "خصوصی"; if($value['priority']==2) echo "خصوصی-غیرقابل نمایش"; ?></td>
                    <td>

                    <span onclick="del_row('<?=  $value['id'] ?>')" style="color: red;" class="glyphicon glyphicon-remove"></span>
                     </td>
</tr>
                    @endforeach



        </table>
        @endif
         <div style="clear:both"></div>

</div>

@endsection


@section('bottom_scripts')


 <script>
     $('#center_id').change(function() {
         if ($( '#center_id').val()==0) {
             $("#showtr").css("visibility","visible");
         }else{
             $("#showtr").css("visibility","hidden");
         }
     });

     $('#center_id').onclick(function() {
         if ($( '#center_id').val()==0) {
             $("#showtr").css("visibility","visible");
         }else{
             $("#showtr").css("visibility","hidden");
         }
     });
 </script>



<script type="text/javascript">

function del_row(id)
{
  <?php
         $token=Session::token();
   ?>
   var route='<?= url("admin/discounts")."/" ?>';
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

@endsection