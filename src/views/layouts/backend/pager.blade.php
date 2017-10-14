@if ($paginator->hasPages())
<div class="libom mt5">
<div class="paging">
	<span class="tot">共计<b>{{$paginator->total()}}</b>项</span>
    @if ($paginator->onFirstPage())
    <span class="disabled">上一页</span>
    @else
    <a href="{{$paginator->previousPageUrl()}}">上一页</a>
    @endif
    
    @foreach ($elements as $element)
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span class="cur">{{$page}}</span>
                @else
                <a href="{{$url}}">{{$page}}</a>
                @endif
            @endforeach
        @else
            <a href="javascript:;">{{$element}}</a>
        @endif
    @endforeach
    
    @if ($paginator->hasMorePages())
    <a href="{{$paginator->nextPageUrl()}}">下一页</a>
    @else
    <span class="disabled">下一页</span>
    @endif
    <span class="pct">页码 <b>{{$paginator->currentPage()}}</b> / {{$paginator->lastPage()}}</span>
</div>
</div>
@endif