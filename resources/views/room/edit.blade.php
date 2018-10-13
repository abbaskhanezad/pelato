@extends('layout.user')


@section('content')
    @include('layout.user.error')
    <script>
        $(document).ready(function () {
            $(".btnDeleteImage").click(function (event) {
                event.preventDefault();
                var $this = $(this);
                var room_id = $this.data('roomid');
                var image_id = $this.data('imageid');

                $.ajax({
                    url: '/room/image/delete',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        room_id: room_id,
                        image_id : image_id
                    }
                    ,
                    success: function (response) {
                        element = "image-"+image_id+"-room-"+room_id;
                        $('#'+element).hide(1000);
                    }
                    ,
                    error: function () {

                    }


                });
            });
        });
    </script>



    <style>
        .img-wrap {
            position: relative;
            display: inline-block;
        }
        .img-wrap .close {
            position: absolute;
            top: 2px;
            left: 100px;
            z-index: 100;
            border: 1px solid black;
            border-right: 0;
            font-size: 30px;
        }
    </style>

    <script src="/js/dropzone.js"></script>
    <link rel="stylesheet" href="/css/dropzone.css">


    <script src="/js/dropzone.js"></script>
    <link rel="stylesheet" href="/css/dropzone.css">


    <div class="row">
        <div class="col-md-7">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">ویرایش اتاق مرکز {{ $room->reservable_center->name }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{ route('room.update',$room->id) }}" method="post" class="form-horizontal">
                        <div class="form-body">
                            {{ csrf_field() }}

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="name">عنوان</label>
                                <div class="col-md-5">
                                    <input type="text" name="name" id="name" required="true" class="form-control"
                                           placeholder="" value="{{$room->name}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="size">اندازه</label>
                                <div class="col-md-2">
                                    <input type="number" name="size" id="size" required="true" class="form-control"
                                           placeholder="" value="{{$room->size}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block">متراژ اتاق بر حسب متر مربع</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="size">تعداد صندلی</label>
                                <div class="col-md-2">
                                    <input type="number" name="sandali" id="sandali" class="form-control" placeholder=""
                                           value="{{$room->sandali}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block">تعداد صندلی</span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="price_per_hour">قیمت</label>
                                <div class="col-md-2">
                                    <input type="number" name="price_per_hour" min="1" id="price_per_hour"
                                           required="true" class="form-control" placeholder=""
                                           value="{{$room->price_per_hour}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block">قیمت بر حسب هزار تومان</span>
                                </div>
                            </div>
                            <?php /*$room_attributess=[];
                            foreach($room->tags()->get() as $ca){
                                $room_attributess[]=$ca->id;
                            }*/?>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="room_attributes">ویژگی ها</label>
                                <div class="col-md-4">
                                    <select name="room_attributes[]" size="10" multiple id="room_attributes"
                                            class="form-control">
                                        @foreach($allAttributes as $attID=>$attName)
                                            <option value="{{$attID}}"
                                                    @if(in_array($attID,array_keys($tags))) selected="selected" @endif>{{$attName}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-focus"></div>
                                    <span class="help-block">برای انتخاب چندین گزینه همزمان با کلیک، کلید Ctrl را نگه دارید</span>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="floor_type">جنس کف</label>
                                <div class="col-md-4">
                                    <input type="text" name="floor_type" id="floor_type" required="true"
                                           class="form-control" placeholder="" value="{{$room->floor_type}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="wall_type">جنس دیوار</label>
                                <div class="col-md-4">
                                    <input type="text" name="wall_type" id="wall_type" required="true"
                                           class="form-control" placeholder="" value="{{$room->wall_type}}">
                                    <div class="form-control-focus"></div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green">ثبت تغییرات</button>

                                    <a href="/room" class="btn default">انصراف</a>

                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- END FORM-->
                </div>

            </div>
            <!-- END VALIDATION STATES-->
        </div>

        <div class="col-md-5">
            <div class="portlet light portlet-fit portlet-form">
                <div class="portlet-title">

                    <form action="{{ route('room.upload.image',$room->id) }}" class="dropzone"
                          id="my-awesome-dropzone" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="fallback">
                            <input name="file" type="file" multiple/>
                        </div>

                    </form>



                    @if(isset($images) && sizeof($images))
                        @foreach($images as $image)
                            <div class="img-wrap" id="image-{{$image->id}}-room-{{ $room->id }}">
                                <a  href="#" class="btn btn-danger close btnDeleteImage" data-imageID="{{$image->id}}" data-roomID="{{$room->id}}">&times;</a>
                                <img src="/images/{{ $image->picture }}" width="100" height="100" alt="" >
                            </div>
                        @endforeach
                    @endif







                </div>
            </div>
        </div>
    </div>
@stop
