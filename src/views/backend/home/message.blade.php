@extends("layouts.backend.layout")
@section("title","系统提示")

@push('css')
<style type="text/css">
    i.icon-success , i.icon-fail , i.icon-info{font-size: 60px;}
</style>
@endpush

@push('script')
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title">系统提示</h4>
    </div>
    <div class="data text-center">
        @if($type=="success")
        <div><i class="iconfont icon-success text-success"></i></div>
        <h3 class="text-success">{{$msg}}</h3>
        @elseif($type=="error")
        <div><i class="iconfont icon-fail text-danger"></i></div>
        <h3 class="text-danger">{{$msg}}</h3>
        @else
        <div><i class="iconfont icon-info text-info"></i></div>
        <h3 class="text-info">{{$msg}}</h3>
        @endif
        <p><span id="countdown">{{$type=="error"?5:3}}</span> 秒后自动跳转到第一个链接</p>
        <div><a class="btn btn-sm btn-link" href="{{$url?:"javascript:window.history.back();"}}">{{$label}}</a></div>
        @foreach($links as $link)
        <div><a class="btn btn-sm btn-link" href="{{$link['url']}}">{{$link['label']}}</a></div>
        @endforeach
    </div>
</div>
@endsection

@push("inline")
<script type="text/javascript">
$(function(){
    window.setInterval(redirect, 1000); 
})  

function redirect(){
    var countdown = parseInt($('#countdown').html());
    if(isNaN(countdown) || countdown <= 0) {window.clearInterval(); return;}
    countdown --;
    $('#countdown').text(countdown);
    if (countdown == 0){
        var href = $('a.btn-link:first').attr('href');
        if(href && href.indexOf("javascript:")===-1){
            window.location.href = $('a.btn-link:first').attr('href');
        }else{
            window.history.back();
        }
    }
}
</script>
@endpush