<ul class="pagination">
    @if ($paginator->onFirstPage())
    <li class="disabled"><a href="javascript:;">上一页</a></li>
    @else
    <li><a href="{{$paginator->previousPageUrl()}}">上一页</a></li>
    @endif
    @foreach ($elements as $element)
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <li class="active"><a href="javascript:;">{{$page}}</a></li>
                @else
                <li><a href="{{$url}}">{{$page}}</a></li>
                @endif
            @endforeach
        @else
        <li class="disabled"><a href="javascript:;">{{$element}}</a></li>
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
    <li><a href="{{$paginator->nextPageUrl()}}">下一页</a></li>
    @else
    <li class="disabled"><a href="javascript:;">下一页</a></li>
    @endif
</ul>
<div class="pagination-count">共 <b>{{$paginator->total()}}</b> 条</div>