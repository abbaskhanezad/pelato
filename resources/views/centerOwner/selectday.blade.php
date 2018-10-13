@extends('layout.admin')
@php
    use App\RoomTiming;

@endphp
    @section('content')
        <div id="app">
            <section class="content">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="form-group text-center">
                            <label for="selectweek">انتخاب هفته</label>
                            <select class="form-control text-center" id="selectweek" name="week" style="text-align: center;!important;">
                                @foreach($week as $data)
                                    <?php
                                    if(($data->id)< ($current_week_id)){
                                        continue;

                                    }
                                    if($data->id >= ($current_week_id+8)){
                                        break;

                                    }
                                    ?>
                                    <option value="{{$data->id}}" style="text-align: center;font-size: 16px;font-weight: bold;@if($data->id==$current_week_id){{'color:white;background-color:blue;'}} @endif"> {{jalali_date($data->start_date)}}ــــ{{jalali_date($data->end_date)}} @if($data->id==$current_week_id) {{'   هفته جاری     '}} @endif</option>

                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>



              <div class="row">

                  <form action="" method="post" name="time_form" id="frm0">
                      {{csrf_field()}}
                      <div class="col-md-12 col-sm-12 col-xs-10 col-xs-offset-1" style="padding-bottom: 10px;">
                          <input type="hidden" name="dayid" value="1">
                          <button  style="width: 90%; border-radius: 20px;" onclick="weektime(0);">
                              <span class="info-box-icon bg-green" style="width: 100%; border-radius: 20px;font-size: 20px;font-weight: bold;">زمانبندی کل هفته</span>
                          </button>

                      </div>
                  </form>
              </div>



                <div class="row">
                    <form action="/centerowner/setdaytime" method="post" id="frm1">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="1">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(1);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 20px;font-weight: bold;">شنبه</span>
                            </button>

                        </div>
                    </form>




                    <form action="/centerowner/setdaytime" method="post" id="frm2">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="2">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(2);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 20px;font-weight: bold;">یکشنبه</span>
                            </button>

                        </div>
                    </form>
                    <form action="/centerowner/setdaytime" method="post" id="frm3">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="3">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(3);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 20px;font-weight: bold;">دوشنبه</span>
                            </button>

                        </div>
                    </form>

                    <form action="/centerowner/setdaytime" method="post" id="frm4">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="4">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(4);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 18px;font-weight: bold;">سه شنبه</span>
                            </button>

                        </div>
                    </form>
                    <form action="/centerowner/setdaytime" method="post" id="frm5">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="5">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(5);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 17px;font-weight: bold;">چهارشنبه</span>
                            </button>

                        </div>
                    </form>
                    <form action="/centerowner/setdaytime" method="post" id="frm6">
                        {{csrf_field()}}
                        <div class="col-md-4 col-sm-4 col-xs-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="6">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(6);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 16px;font-weight: bold;">پنج شنبه</span>
                            </button>

                        </div>
                    </form>





                </div>
                <div class="row">
                    <form action="/centerowner/setdaytime" method="post" id="frm7">
                        {{csrf_field()}}
                        <div class="col-xs-4 col-xs-offset-4" style="padding-bottom: 10px;">
                            <input type="hidden" name="dayid" value="7">
                            <button  style="width: 90%; border-radius: 20px;" onclick="send(7);">
                                <span class="info-box-icon bg-aqua" style="width: 100%; border-radius: 20px;font-size: 20px;font-weight: bold;">جمعه</span>
                            </button>

                        </div>
                    </form>


                </div>
            </section>
        </div>
    @endsection

@section('script')
    <script>
        function send($dayid) {
           // alert('a');
            var weekid= document.getElementById('selectweek').value;

            var input = document.createElement("input");

            input.setAttribute("type", "hidden");

           input.setAttribute("name", "weekid");

           input.setAttribute("value",weekid);

          $frmid='frm'+$dayid;
            document.getElementById($frmid).appendChild(input);
            document.getElementById($frmid).submit();
            //alert(weekid);

        }
    </script>


    <script>
        function weektime($id) {
            // alert('a');
            $frmid='frm'+$id;
           // document.getElementById($frmid).action='/ss/ss';
           // document.getElementById($frmid).submit();
            var $weekid=document.getElementById('selectweek').value;
            document.time_form.action = "/centerowner/timing/week/"+ $weekid+"/set/";
            document.getElementById($frmid).submit();


        }
    </script>


    @endsection



