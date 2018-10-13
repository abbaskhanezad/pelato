@extends('layout.user')

@section('bottom_scripts')

@stop
@section('content')
@include('layout.user.error')
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-settings font-dark"></i>
                  <span class="caption-subject bold uppercase">لیست اتاقهای مرکز @if($reservable_center_filter->id) " {{$reservable_center_filter->name}} " @endif</span>
              </div>
          </div>
          <div class="col-sm-10">
              <a href="{{ route('room_attributes.index') }}" class="caption-subject bold uppercase btn btn-info pull-left">ساخت ویژگی برای اتاق ها</a>
          </div>
          <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                  <thead>
                      <tr>
                          <th> # </th>
                          <th> نام مرکز </th>
                          <th> نام اتاق </th>
                          <th> قیمت/ساعت </th>
                          <th> متراژ </th>
                          <th> کف </th>
                          <th> دیوار </th>
                          <th> عملیات </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($room_whole as $data)
                      <tr class="odd gradeX">
                          <td> {{$data->id}} </td>
                          <td> {{$data->reservable_center->name}} </td>
                          <td> {{$data->name}} </td>
                          <td> {{$data->price_per_hour*1000}} </td>
                          <td> {{$data->size}} </td>
                          <td> {{$data->floor_type}} </td>
                          <td> {{$data->wall_type}} </td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                      <i class="fa fa-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-left" role="menu">
                                      <li>
                                          <a href="/room/{{$data->id}}/edit">
                                              <i class="icon-pencil"></i> ویرایش</a>
                                      </li>
									  <li>
                                          <a onclick="if(confirm('آیا با حذف موافق هستید؟'))  href='/room/{{$data->id}}/delete' " style="color: red">
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
</div>
<div class="row">
  <div class="col-md-7">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form">
          <div class="portlet-title">
              <div class="caption">
                  <i class=" icon-layers font-green"></i>
                  <span class="caption-subject font-green sbold uppercase">@if($edit) ویرایش @else ثبت @endif اتاق مرکز</span>
              </div>
          </div>
          <div class="portlet-body">
              <!-- BEGIN FORM-->
              <form action="@if($edit) /room/{{$room->id}}/edit @else /room/add @endif" method="post" class="form-horizontal">
                  <div class="form-body">
                    {{ csrf_field() }}
                    @if($edit)
                    {{method_field('PATCH')}}
                    @endif
                      <div class="form-group form-md-line-input">
                          <label class="col-md-2 control-label" for="reservable_center_id">مرکز</label>
                          <div class="col-md-4">
                              <select name="reservable_center_id" id="reservable_center_id" required="true" class="form-control">
                                @foreach($reservable_center as $rc)
                                <option value="{{$rc->id}}"  @if($rc->id == $reservable_center_filter->id) selected="selected" @endif>{{$rc->name}}</option>
                                @endforeach
                              </select>
                              <div class="form-control-focus"> </div>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="name">عنوان</label>
                          <div class="col-md-5">
                              <input type="text" name="name" id="name" required="true" class="form-control" placeholder="" value="{{$room->name}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block"></span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="size">اندازه</label>
                          <div class="col-md-2">
                              <input type="number" name="size" id="size" required="true" class="form-control" placeholder="" value="{{$room->size}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">متراژ اتاق بر حسب متر مربع</span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="size">تعداد صندلی</label>
                          <div class="col-md-2">
                              <input type="number" name="sandali" id="sandali" class="form-control" placeholder="" value="{{$room->sandali}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">تعداد صندلی</span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="price_per_hour">قیمت</label>
                          <div class="col-md-2">
                              <input type="number" name="price_per_hour" min="1" id="price_per_hour" required="true" class="form-control" placeholder="" value="{{$room->price_per_hour}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block">قیمت بر حسب هزار تومان</span>
                          </div>
                      </div>
                      <?php $room_attributess=[];
                      foreach($room->tags()->get() as $ca){
                          $room_attributess[]=$ca->id;
                      }?>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-2 control-label" for="room_attributes">ویژگی ها</label>
                          <div class="col-md-4">
                              <select name="room_attributes[]" size="10" multiple id="room_attributes"  class="form-control">
                                  @foreach($room_attributes as $attribute)
                                      <option value="{{$attribute->id}}" @if(in_array($attribute->id, $room_attributess)) selected="selected" @endif>{{$attribute->name}}</option>
                                  @endforeach
                              </select>
                              <div class="form-control-focus"> </div>
                              <span class="help-block">برای انتخاب چندین گزینه همزمان با کلیک، کلید Ctrl را نگه دارید</span>
                          </div>
                      </div>

                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="floor_type">جنس کف</label>
                          <div class="col-md-4">
                              <input type="text" name="floor_type" id="floor_type" required="true" class="form-control" placeholder="" value="{{$room->floor_type}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block"></span>
                          </div>
                      </div>
                      <div class="form-group form-md-line-input">
                          <label class="col-md-3 control-label" for="wall_type">جنس دیوار</label>
                          <div class="col-md-4">
                              <input type="text" name="wall_type" id="wall_type" required="true" class="form-control" placeholder="" value="{{$room->wall_type}}">
                              <div class="form-control-focus"> </div>
                              <span class="help-block"></span>
                          </div>
                      </div>
                  </div>
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button class="btn green">@if($edit) ویرایش @else ثبت @endif</button>
                              @if($edit)
                              <a href="/room" class="btn default">انصراف</a>
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
