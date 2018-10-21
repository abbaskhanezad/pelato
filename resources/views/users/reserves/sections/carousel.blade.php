<div class="col-md-4" style="float: left;">
    @if(count($room->image)>0)
        <div id="slideshow-{{$room->id}}" class="carousel slide"
             data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($room->image as $kimg => $image)
                    <li data-target="#slideshow-{{$room->id}}"
                        data-slide-to="{{ $kimg }}" class="active"></li>
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($room->image as $kimg => $image)
                    <div class="item @if($kimg == 0)  active @endif">
                        <img src="/images/{{ $image->picture}}">
                    </div>
                @endforeach
            </div>


            <!-- Left and right controls -->
            <a class="right carousel-control" href="#slideshow-{{$room->id}}"
               role="button" data-slide="prev">
                <i class="glyphicon glyphicon-chevron-right"
                   aria-hidden="true"></i>
                <span class="sr-only">قبلی</span>
            </a>
            <a class="left carousel-control" href="#slideshow-{{$room->id}}"
               role="button" data-slide="next">
                <i class="glyphicon glyphicon-chevron-left"
                   aria-hidden="true"></i>
                <span class="sr-only">بعدی</span>
            </a>
        </div>
    @endif
</div>
