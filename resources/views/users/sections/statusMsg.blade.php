@if(session('statusError'))
    <div class="alert alert-danger">
        <p>{{session('statusError')}}</p>
    </div>
@endif

@if(session('statusSuccess'))
    <div class="alert alert-success">
        <p>{{session('statusSuccess')}}</p>
    </div>
@endif