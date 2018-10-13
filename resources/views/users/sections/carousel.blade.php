<div class="row">
    <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
        <div class="MultiCarousel-inner">


            @foreach($items as $item )

                <div class="item">
                    <div class="pad15">
                        <img class="thumbnail" width="100%" height="200" src="/images/{{ $item->image->picture }}"
                             alt="">

                        <div class="caption">


                            <a href="#">
                                <h5><span>{{ $item->name }}</span></h5>
                            </a>
                            <p><span class="glyphicon glyphicon-tag"></span> نوع مرکز :{{ $item->center_type->name }}
                            </p>
                            <p><span class="fa fa-bank"></span> تعداد اتاق:{{ $item->room->count() }} </p>


                            <p style="direction:rtl;">
                                <span class="fa fa-2x fa-map-marker text-green text-bold" style="color: red;"></span>
                                <small class="no-margin" style="display: block; height: 50px; overflow-y: auto;">
                                    <span>آدرس {{ $item->address }}</span>
                                </small>
                            </p>

                            @if($showStar)
                                @include('users.sections.star')
                            @endif
                            <p>
                                <a href="#" class="btn btn-sm btn-success"
                                   style="margin-bottom: 2px; width: 100%;border-radius:5px;">
                                    <span style="border-radius:5px;">مشــاهــده و رزرو مــرکــز</span>
                                </a>

                            </p>
                        </div>

                    </div>
                </div>


            @endforeach


        </div>

        <button class="btn btn-primary rightLst btnCarousel">></button>
        <button class="btn btn-primary leftLst btnCarousel"><</button>

    </div>
</div>
