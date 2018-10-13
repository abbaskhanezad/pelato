@extends('layout.user')
@section('content')
    @include('layout.user.error')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-users font-dark"></i>
							<span class="caption-subject bold uppercase">لیست مرکزداران</span>
                    </div>
                  {{--  <div class="caption font-dark"style="float:left;">
                        <form action="{{ route('users.index') }}" method="get">
                            <input type="search" required="required" placeholder="شماره موبایل کاربر" name="keyword">
                            <button type="submit" class="btn btn-sm btn-info">جستجو</button>
                        </form>
                    </div> --}}
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> نام کاربری </th>
                            <th> نام </th>
                            <th> پست الکترونیکی </th>
                            <th> تلفن همراه </th>
                            <th> زمان ثبت </th>
							<th> وضعیت کاربر</th>
							  <th> وضعیت مرکز </th>
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
                                <td> {{$data->email}} </td>
                                <td> {{$data->mobile}} </td>
                                <td> {{jalali_datetime($data->created_at)}} </td>
								@if($data->confirm)
                                    <td class="text-center">
                                        <form action="{{ route('users.update.confirm' , ['id' => $data->id]) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('put')}}
                                            <button type="submit" class="btn btn-sm" style="background: none">
                                                <i class="fa fa-check" style="color: #00a65a"></i>
                                            </button>
                                        </form>
                                    </td>
                                @else
                                    <td class="text-center">
                                        <form action="{{ route('users.update.confirm' , ['id' => $data->id]) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('put')}}
                                            <button type="submit" class="btn btn-sm" style="background: none">
                                                <i class="fa fa-ban fa-lg" style="color: red"></i>
                                            </button>
                                        </form>
                                      </td>
                                @endif
								 @if($data->reservable_center->verified)
                                      <td class="text-center"> <i class="fa fa-check" style="color: #00a65a"></i> </td>
                                      @else
                                      <td class="text-center"> <i class="fa fa-ban fa-lg" style="color: red"></i> </td>
                                  @endif
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
                                                    <a href="{{ route('users.center_owner.show', ['id' => $data->reservable_center->id]) }}">
                                                        <i class="icon-trash" ></i> اطلاعات مرکز </a>
                                                </li>
											    <li>
                                                    <a href="{{ route('users.show', ['id' => $data->id]) }}">
                                                        <i class="icon-trash" ></i> اطلاعات هویتی کاربر
													</a>
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
					{{ $user_whole->links() }}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@stop
