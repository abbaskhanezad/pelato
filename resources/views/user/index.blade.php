@extends('layout.user')

@section('bottom_scripts')

    <script>
       // $(".abbas").click(function () {
          //  $('#bookId').val($(this).data('id'));
       //     $('#myModal').modal('show');
       // });
function abbas(data){
   // alert(data);
    document.getElementById('mb').value=data;
}
    </script>


@stop
@section('content')
@include('layout.user.error')
@php
    use  App\OrderRoom;
	use App\User;
	$users_count=User::all()->count();
	$confirmed_user_count=User::where('confirm',1)->count();
@endphp
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="fa fa-users font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست کاربران</span>
                  <a href="#register" class="bnt btn-sm btn-info" style="text-decoration: none">ثبت نام کاربر جدید</a>
              </div>
			  <div class="caption font-dark"style="float:left;">
                  <form action="{{ route('users.index') }}" method="get">
                      <input required="required"  size="35" type="search" style="font-size:14px;" placeholder="قسمتی از موبایل یا نام کاربر" name="keyword">
                      <button type="submit" class="btn btn-sm btn-info">جستجو</button>
                  </form>
              </div>
			    <div class="caption font-dark" style="padding-right:30px;">
                  <form action="{{ route('users.index') }}" method="get">
                      <input type="hidden"  size="35" style="font-size:14px;"  value='2' name="type">
                      <button type="submit" class="btn btn-sm btn-success">نمایش مرکزداران</button>
                  </form>
              </div>
			   {{-- <div class="portlet-title"style="float:left;">
                  <form action="{{ route('users.index') }}" method="get">
                      <button type="submit" class="btn btn-sm btn-success">بازگشت به کاربران</button>
                  </form>
              </div> --}}
          </div>
		    @if(session()->has('message'))
              <div class="alert alert-danger">
                  {{ session()->get('message') }}
              </div>
         	@endif
          <div class="portlet-body">
              <a href="tel:09357081196">سسسسسسسسسسسسسسسسسسس</a>
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                  <thead>
                      <tr>
                          <th> # </th>
                          <th> نام کاربری </th>
                          <th> نام </th>
                          <th> تعداد رزرو </th>
						  <th> جزئیات</th>
                          <th> تلفن همراه </th>
                          <th> نوع </th>
                          <th> زمان ثبت </th>
                          <th> زمان ویرایش </th>
						  <th>وضعیت</th>
                          <th class="abbas">ارسال پیام</th>
                          @if(auth()->user()->type == 3)
                          <th> عملیات </th>
                          @endif
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($user_whole as $data)
                      <tr class="odd gradeX">
                          <td> {{$loop->iteration}} </td>
                          <td> {{$data->username}} </td>
                          <td> {{$data->name}} {{$data->family}} </td>
						  @php
								$count = OrderRoom::where('user_id', $data->id)->where('paid', 1)->count();
						  @endphp
							<td>  <span class="badge"> {{$count}}</span> </td>
                           <td>
                              <a href="/showorders/{{$data->id}}">مشاهده جزئیات</a>
						   </td>
                          <td> {{$data->mobile}} </td>
						    <td> @if($data->type==1) <span>کاربر</span> @elseif($data->type==2) <span class="font-blue">مدیر مرکز</span> @elseif($data->type==3) <span class="font-red" >مدیر کل</span> @else <span style="color: #00a65a"> پشتیبان</span> @endif
						  </td>
                          <td> {{jalali_datetime($data->created_at)}} </td>
                          <td> {{jalali_datetime($data->updated_at)}} </td>
						  <td> @if($data->confirm==1)<p style="color:green;">{{'تایید شده'}}</p> @else <p style="color:red;"> {{'تایید نشده'}}</p>  @endif</td>
                          <td>   <button type="button" onclick="abbas({{$data->mobile}})" class="btn btn-info" user_id="{{$data->id}}" data-toggle="modal" data-target="#myModal">ارسال پیام</button>
                          </td>

                          @if(auth()->user()->type == 3)
                              <td>
                                  <div class="btn-group">
                                      <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                          <i class="fa fa-angle-down"></i>
                                      </button>
                                      <ul class="dropdown-menu pull-left" role="menu">
                                          <li>
                                              <a href="/user/{{$data->id}}/edit">
                                                  <i class="icon-pencil"></i> ویرایش</a>
                                          </li>
                                          <li>
                                              <a href="/user/{{$data->id}}/delete"  style="color: red">
                                                  <i class="icon-trash"  style="color: red"></i> حذف </a>
                                          </li>
                                      </ul>
                                  </div>
                              </td>
                          @endif
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
		  <div class="text-center">
    {!! $user_whole->render() !!}
</div>
<span style="font-size:16px;font-weight:bold;color:green;">تعداد کل کاربران  : </span>
<span style="color:blue;font-size:14px;font-weight:bold;">
{{$users_count}} 
</span>
<br>
<span style="font-size:16px;font-weight:bold;color:green;">تعداد  کاربران تایید شد: </span>
<span style="color:blue;font-size:14px;font-weight:bold;">
{{$confirmed_user_count}} 
</span>
     </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
</div>
@if(auth()->user()->type == 3)
<div class="row">
  <div class="col-md-7">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form">
          <div class="portlet-title">
              <div class="caption">
                  <i class=" icon-layers font-green"></i>
                  <span class="caption-subject font-green sbold uppercase">@if($edit) ویرایش @else ثبت @endif کاربر</span>
              </div>
          </div>
          <div class="portlet-body">
              <!-- BEGIN FORM-->
              <form id="register" action="@if($edit) /user/{{$user->id}}/edit @else /user/add @endif" method="post" class="form-horizontal">
                  <div class="form-body">
                    {{ csrf_field() }}
                    @if($edit)
                    {{method_field('PATCH')}}
                    @endif
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="username">نام کاربری</label>
                          <div class="col-md-9">
                              <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

                              <input type="text" name="username" id="username" required="true" minlength="8" class="form-control" placeholder="" value="{{$user->username}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">انگلیسی، حداقل 8 حرف، غیر تکراری</span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="password">کلمه عبور</label>
                          <div class="col-md-9">
                              <input type="password" name="password" id="password" @if(!$edit) required="true" minlength="8" @endif class="form-control" placeholder="" value="">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">انگلیسی، حداقل 8 حرف</span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="name">نام</label>
                          <div class="col-md-9">
                              <input type="text" name="name" id="name" required="true"  class="form-control" placeholder="" value="{{$user->name}}">
                              <div class="form-control-focus"> </div>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="family">نام خانوادگی</label>
                          <div class="col-md-9">
                              <input type="text" name="family" id="family"  class="form-control" placeholder="" value="{{$user->family}}">
                              <div class="form-control-focus"> </div>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="email">پست الکترونیکی</label>
                          <div class="col-md-9">
                              <input type="email" name="email" id="email"  class="form-control" placeholder="" value="{{$user->email}}">
                              <div class="form-control-focus"> </div>
                             
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="mobile">تلفن همراه</label>
                          <div class="col-md-9">
                              <input type="text" name="mobile" id="mobile" required="true" minlength="11" class="form-control" placeholder="" value="{{$user->mobile}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">مثلا 09129342358</span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="type">نوع</label>
                          <div class="col-md-9">
                              <select  name="type" id="type" required="true" class="form-control">
                                <option value="1" @if($user->type ==1) selected="selected" @endif >کاربر</option>
                                <option value="4" @if($user->type ==4) selected="selected" @endif >پشتیبان پلاتو</option>
                                <option value="2" @if($user->type ==2) selected="selected" @endif >مدیر مرکز</option>
                                <option value="3"  @if($user->type ==3) selected="selected" @endif >مدیر کل</option>
                              </select>
                              <div class="form-control-focus"> </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button class="btn green">@if($edit) ویرایش @else ثبت @endif</button>
                              @if($edit)
                              <a href="/user" class="btn default">انصراف</a>
                              @endif

                          </div>
                      </div>
                  </div>
              </form>
              <!-- END FORM-->
          </div>
      </div>
      <!-- END VALIDATION STATES-->
  </div>
</div>


<!--- modal  -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ارسال پیام</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="mymodal">
                    <form action="/message" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="mb">شماره موبایل</label>
                            <input type="text"  name="mobile" class="form-control" id="mb">
                        </div>

                        <div class="form-group">
                            <label for="message">پیام</label>
                            <textarea  class="form-control" name="message" id="message"></textarea>
                        </div>


                        <button type="submit" class="btn btn-info">ارسال</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

</div>


@endif
@stop
