@extends('layout.user')

@section('bottom_scripts')

    <script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
    <script>
        change_state=function(id,value)
        {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
            $.ajax(
                    {
                        url:'<?= url('admin/comment/change_state') ?>',
                        type:'POST',
                        data:'id='+id+'&value='+value,

                        success:function(data)
                        {

                      //    alert(data);
                            if(data=='no')
                            {

                                document.getElementById('comment_'+id).style.border='1px solid green';
                                document.getElementById('comment_'+id).style.backgroundColor='#33ff33';
                                $("#state1_"+id).show();
                                $("#state_"+id).hide();
                            }
                            else if(data=='ok')
                            {


                                document.getElementById('comment_'+id).style.border='1px solid coral';
                                document.getElementById('comment_'+id).style.backgroundColor='#fdc1c1';

                                $("#state1_"+id).hide();
                                $("#state_"+id).show();

                            }
                        }
                    });
        };
        add_comment=function(id)
        {
            $("#a_comment_"+id).toggle();
        };

        function del_row(id)
        {
                    <?php
                    $token=Session::token();
                    ?>
            var route='<?= url("admin/comment")."/" ?>';
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
@stop
@section('content')
    @include('layout.user.error')
    <?php
    $jdf=new \App\Libraries\Jdf();
            use App\Comment;
            use App\User;
    ?>

    <div class="row">
        <div class="col-md-12">
            <div  style="border: 1px solid #EBEBEB;width:85%;margin:50px auto;background:white">





                <div class="panel panel-default">
                    <div class="panel-heading">مدیریت نظرات کاربران</div>
                    <div class="panel-body">




                        <div style="width:97%;margin:40px auto">
                            @foreach($Comment as $key=>$value)

                                <div id="comment_<?= $value['id']; ?>" style="width:100%;;direction:rtl;border-radius: 25px;<?php if($value['state']==0) echo 'border:1px solid coral; background-color:#fdc1c1;'; else echo 'border:1px solid green; background-color:#33ff33;' ?>font-size:13px;float:right; padding: 3px;margin: 2px;">
                                    <div style="width:95%;float:right;text-align:justify;padding-right:20px;padding-bottom:2px;padding-top:4px;">
                                            @if($value['parent_id']!=0)                                        <p style="color:#ff0000"><span>ارسال شده توسط : </span> {{ $value->name.'___' }}{{User::find( $value->user_id)->first()->mobile}}

                                            -
                                                درپاسخ به: {{\App\Comment::where('id',$value['parent_id'])->first()->name}}
                                                -
                                            @endif
                                            <span>در تاریخ : </span> <?= $jdf->jdate('Y/n/j',$value['time']) ?></p>
                                        {!! nl2br(strip_tags($value['comment'])) !!}<br>
                                        <p style="color:#ff0000;padding-top:5px;">ثبت شده در مرکز {{   $value->center['name'] }}</p>


                                        @if($value['parent_id']==0)
                                            <div style="display:none;" id="a_comment_{{$value->id }}">

                                                <form method="post" action="{{ url('admin/comment/create') }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="center_id" value="{{ $value->center_id }}">
                                                    <input type="hidden" name="parent_id" value="{{ $value->id }}">
                                                    <textarea name="comment" style="width:100%;height:200px;background-color: #c3a4ffeb;"></textarea>
                                                    <input type="submit" style="padding-top:0px;padding-bottom:0px;margin-top:20px;margin-bottom:20px;" value="ثبت">
                                                </form>
                                            </div>
                                        @endif


                                        <span id="state_<?= $value->id ?>"  style=" padding-left:10px;color:blue;cursor:pointer;<?php if($value->state==1) echo 'display:none'; ?>" onclick="change_state('<?= $value['id']; ?>',1)">تایید</span>


                                        <span id="state1_<?= $value->id ?>"  style="padding-left:10px;color:blue;cursor:pointer;<?php if($value->state==0) echo 'display:none'; ?>" onclick="change_state('<?= $value['id']; ?>',0)">عدم تایید</span>





                                        @if($value['parent_id']==0)
                                            <span  onclick="add_comment('<?=  $value->id; ?>')" style="padding-left:10px;color:blue;cursor: pointer">ارسال پاسخ</span>
                                        @endif

                                        <span onclick="del_row('<?= $value->id ?>')" style="color:#ff0000;cursor: pointer">حذف</span>
                                    </div>

                                </div>




                            @endforeach


                        </div>
                        <div class="text-center">
                            {{ $Comment->render() }}

                        </div>
                        <div style="clear:both;padding-top:20px;"></div>
                    </div>


                </div>


            </div>
                </div>






 </div>

    @stop