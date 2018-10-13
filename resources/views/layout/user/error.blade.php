@if( Session::has('flash_message'))
<div class="alert alert-{{ Session::get('flash_message_type') }}">{{ Session::get('flash_message') }}</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}<br>
    @endforeach
</div>
@endif
