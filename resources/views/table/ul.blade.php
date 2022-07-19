<p class="">Total Records : {{ $count }} </p>

@if ($pagination['total_page'] > 1)
    <ul class="pagination pagination-split">

        @if ($pagination['current_page'] != 1)
            <li> <a href="#" class="btn  border border-secondary rounded-pill px-2"
                    data-href="{{ $pagination['current_page'] - 1 }}"><i class="fa fa-angle-left"></i></a>
            </li>
        @endif

        @if ($pagination['current_page'] - 3 > 0)
            @if ($pagination['current_page'] == 1)
                <li class="btn  border border-success rounded-pill active"><span>1</span></li>
            @else
                <li> <a href="#" class="btn  border border-success rounded-pill" data-href="1">1</a> </li>
            @endif
        @endif
        @if ($pagination['current_page'] - 3 > 1)
            <li class="point">. . .</li>
        @endif

        @for ($i = $pagination['current_page'] - 2; $i <= $pagination['current_page'] + 2; $i++)
            @if ($i < 1)
                @continue
            @endif
            @if ($i > $pagination['total_page'])
            @break
        @endif
        @if ($pagination['current_page'] == $i)
            <li class="btn  border border-success rounded-pill active">
                <span>{{ $pagination['current_page'] }}</span>
            </li>
        @else
            <li> <a href="#" class="btn  border border-success rounded-pill"
                    data-href="{{ $i }}">{{ $i }}</a> </li>
        @endif
    @endfor

    @if ($pagination['total_page'] - ($pagination['current_page'] + 2) > 1)
        <li class="point">. . .</li>
    @endif
    @if ($pagination['total_page'] - ($pagination['current_page'] + 2) > 0)
        @if ($pagination['current_page'] == $pagination['total_page'])
            <li class="btn  border border-success rounded-pill active">
                <span>{{ $pagination['current_page'] }}</span>{{ $pagination['total_page'] }}
            </li>
        @else
            <li> <a href="#"
                    data-href="{{ $pagination['total_page'] }}">{{ $pagination['total_page'] }}</a>
            </li>
        @endif
    @endif

    @if ($pagination['current_page'] < $pagination['total_page'])
        <li> <a href="#" class="btn  border border-secondary rounded-pill"
                data-href="{{ $pagination['current_page'] + 1 }}"><i class="fa fa-angle-right"></i></a>
        </li>
    @endif
</ul>
@endif
