<p class="rating-input" style="direction: rtl;">

    <span style="font-size: large; font-weight: bold;">میانگین امتیازات این مرکز:</span>
    @for($r=0;$r<5;$r++)

        @if($r < $item->avgAll )
            <span style="font-size: large; font-weight: bold; color: #ffe68b;" data-value="{{$r}}"
                  class="fa fa-star check"></span>
        @else
            <span style="font-size: large; font-weight: bold;" data-value="{{$r}}"
                  class="fa fa-star-o"></span>
        @endif
    @endfor

    {{'('}}
    {{'از    '}}
    {{$item->countStarRate}}
    {{'  رای'}}
    {{')'}}

</p>
