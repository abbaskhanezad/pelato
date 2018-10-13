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
                  <span class="caption-subject bold uppercase">لیست انواع ویژگی مراکز</span>
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
                    @foreach($center_attribute_whole as $data)
                      <tr class="odd gradeX">
                          <td> {{$data->id}} </td>
                          <td> {{$data->name}} </td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                      <i class="fa fa-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-left" role="menu">
                                      <li>
                                          <a href="/center_attribute/{{$data->id}}/edit">
                                              <i class="icon-pencil"></i> ویرایش</a>
                                      </li>
                                      <li>
                                          <a href="/center_attribute/{{$data->id}}/delete"  style="color: red">
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
      
	
	  
	     {!! $center_attribute_whole->render() !!}
	  
	  </div>
      <!-- END EXAMPLE TABLE PORTLET-->
  </div>
  <div class="col-md-5">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-plus font-green"></i>
                  <span class="caption-subject font-green sbold uppercase">@if($edit) ویرایش @else ثبت @endif ویژگی مرکز</span>
              </div>
          </div>
          <div class="portlet-body">
              <!-- BEGIN FORM-->
              <form action="@if($edit) /center_attribute/{{$center_attribute->id}}/edit @else /center_attribute/add @endif" method="post" class="form-horizontal">
                  <div class="form-body">
                    {{ csrf_field() }}
                    @if($edit)
                    {{method_field('PATCH')}}
                    @endif
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="name">عنوان</label>
                          <div class="col-md-9">
                              <input type="text" name="name" id="name" required="true" class="form-control" placeholder="" value="{{$center_attribute->name}}">
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
                              <a href="/center_attribute" class="btn default">انصراف</a>
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
@stop
