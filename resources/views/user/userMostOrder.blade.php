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
                        <span class="caption-subject bold uppercase">لیست کاربران بر اساس تعداد رزروها</span>
                    </div>
                    <div class="caption font-dark" style="float:left;">
                        <form action="{{ route('users.index') }}" method="get">
                            <input required="required" size="35" type="search" style="font-size:14px;"
                                   placeholder="قسمتی از موبایل یا نام کاربر" name="keyword">
                            <button type="submit" class="btn btn-sm btn-info">جستجو</button>
                        </form>
                    </div>
                    <div class="caption font-dark" style="padding-right:30px;">
                        <form action="{{ route('users.index') }}" method="get">
                            <input type="hidden" size="35" style="font-size:14px;" value='2' name="type">
                            <button type="submit" class="btn btn-sm btn-success">نمایش مرکزداران</button>
                        </form>
                    </div>

                    <div class="caption font-dark" style="padding-right:30px;">
                        <a href="{{ route('user.notConfirmed') }}" class="btn btn-danger btn-sm">لیست تایید نشده ها</a>
                    </div>

                </div>
                @if(session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif

                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="sample_1">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> نام کاربری</th>
                            <th> نام</th>
                            <th> تعداد رزرو</th>
                            <th>شماره همراه</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="odd gradeX">
                                <td> {{$loop->iteration}} </td>
                                <td> {{$user->username}} </td>
                                <td> {{$user->name}} {{$user->family}} </td>
                                <td><span class="badge"> {{$user->order_room_count}}</span></td>
                                <td> {{$user->mobile}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $users->links() }}

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


@stop
