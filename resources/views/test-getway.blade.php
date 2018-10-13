<form action="{{ route('test.getway') }}" method="post">
    {{csrf_field()}}
    <button type="submit" class="btn btn-sm btn-info">
        اتصال
    </button>
</form>