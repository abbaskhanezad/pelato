@extends('layout.user')

@section('content')
    <div class="row text-center">
        @include('layout.user.error')
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">ارسال پیامک</div>
        <div class="panel-body">

            <form action="/message" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="mobile">شماره موبایل</label>
                    <input type="text"  name="mobile" class="form-control" id="mobile">
                </div>

                <div class="form-group">
                    <label for="message">پیام</label>
                    <textarea  class="form-control" name="message" id="message"></textarea>
                </div>


                <button type="submit" class="btn btn-info">ارسال</button>
            </form>
        </div>
    </div>

@endsection