@extends('layout.user')

@section('bottom_scripts')

@stop
@section('content')
    @include('layout.user.error')
    <div class="row">
        <div class="col-md-7">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-tag font-dark"></i>
                        <span class="caption-subject bold uppercase">لیست انواع ویژگی اتاق ها</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> نام </th>
                            <th> عملیات </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($room_attributes as $data)
                            <tr class="odd gradeX">
                                <td class="text-center"> {{$data->id}} </td>
                                <td class="text-center"> {{$data->name}} </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" role="menu">
                                            <li>
                                                <a href="{{ route('room_attributes.edit' , ['id' => $data->id]) }}">
                                                    <i class="icon-pencil"></i> ویرایش</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('room_attributes.delete' , ['id' => $data->id]) }}"  style="color: red">
                                                    <i class="icon-trash"  style="color: red"></i> حذف </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        <div class="col-md-5">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plus font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">@if($edit) ویرایش @else ثبت @endif ویژگی اتاق</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="@if($edit) {{route('room_attributes.update', ['id' => $room_attribute->id])}} @else {{ route('room_attributes.store') }} @endif" method="post" class="form-horizontal">
                        <div class="form-body">
                            {{ csrf_field() }}
                            @if($edit)
                                {{method_field('PATCH')}}
                            @endif
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="name">عنوان</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" id="name" required="true" class="form-control" placeholder="" value="{{$room_attribute->name}}">
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block">مثلا: آینه، اینترنت و ...</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green">@if($edit) ویرایش @else ثبت @endif</button>
                                    @if($edit)
                                        <a href="{{ route('room_attributes.index') }}" class="btn default">انصراف</a>
                                    @endif
                                        <a href="{{ route('room.index') }}" class="btn btn-info">بازگشت به لیست اتاق ها</a>
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
@stop
