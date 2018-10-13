@section('bottom_scripts')

@stop
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light ">
          <div class="portlet-title">
              <div class="caption font-dark">
                  <i class="icon-{{$metronic->table->title_icon}} font-dark"></i>
                  <span class="caption-subject bold uppercase"> {{$metronic->table->title_name}}</span>
              </div>
              <?php  /*
              <div class="actions">
                  <div class="btn-group btn-group-devided" data-toggle="buttons">
                      <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                          <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                      <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                          <input type="radio" name="options" class="toggle" id="option2">Settings</label>
                  </div>
              </div>
              */  ?>
          </div>
          <div class="portlet-body">
              <div class="table-toolbar">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="btn-group">
                            <a href="@ifempty($metronic->table->button->link)
                              {{$metronic->table->button->link}}
                              @else
                              {{$metronic->table->controller}}/add
                              @endif">
                              <button id="sample_editable_1_new" class="btn sbold blue {{$metronic->table->button->color}}"> {{$metronic->table->button->title}}
                                  <i class="fa fa-plus"></i>
                              </button>
                            </a>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="btn-group pull-right">
                              <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                  <i class="fa fa-angle-down"></i>
                              </button>
                              <ul class="dropdown-menu pull-right">
                                  <li>
                                      <a href="javascript:;">
                                          <i class="fa fa-print"></i> Print </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class="fa fa-file-pdf-o"></i> Save as PDF </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class="fa fa-file-excel-o"></i> Export to Excel </a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                  <thead>
                      <tr>
                        @if($metronic->table->rows_checkbox)
                          <th>
                              <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                  <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                  <span></span>
                              </label>
                          </th>
                        @endif
                        @foreach($metronic->table->column as $column)
                          <th> {{$column[1]}}</th>
                          @endforeach
                          <th> عملیات </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($metronic->table->data as $data)
                      <tr class="odd gradeX">
                        @if($metronic->table->rows_checkbox)
                          <td>
                              <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                  <input type="checkbox" class="checkboxes" value="1" />
                                  <span></span>
                              </label>
                          </td>
                        @endif

                        @foreach($metronic->table->column as $column)
                          <?php $field_name = $column[0]; ?>
                          <td> {{$data->$field_name}} </td>
                        @endforeach
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-cog"></i>
                                      <i class="fa fa-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-left" role="menu">
                                      <li>
                                          <a href="javascript:;">
                                              <i class="icon-pencil"></i> ویرایش</a>
                                      </li>
                                      <li>
                                          <a href=""  style="color: red">
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
