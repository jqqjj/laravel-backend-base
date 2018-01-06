@extends("layouts.backend.layout")
@section("title","后台管理系统")

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/index.css')}}" />
@endpush

@push('script')
@endpush

@section("content")
<div>
    @include("layouts.backend.menubar")
    <div class="content navbar-left-margin">
        <div class="top-bar container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ViewHelper::admin()->autoname()}}<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    @permission('cache.clear')
                    <li><a href="{{route("clearsystemcache")}}" target="main">清理缓存</a></li>
                    <li class="divider"></li>
                    @endpermission
                    <li><a href="{{route("admin-profile")}}" target="main">修改资料密码</a></li>
                    <li><a href="{{route("adminlogout")}}">退出登录</a></li>
                </ul>
            </li>
        </ul>
            </div>
        <div>
            <iframe name="main" scrolling="auto" width="100%" height="800" frameborder="0" src="{{route('dashboard')}}"></iframe>
        </div>
    </div>
</div>
@endsection

@push("inline")
<script>
    $(document).ready(function(){
        $('.menu-item').click(function(){
            $(this).addClass('active').siblings().removeClass('active');
        });
        $('.sub-menu-item a').click(function(){
            $('.sub-menu-item a').removeClass('active');
            $(this).addClass('active');
        });
        $('.navbar-toggle').click(function(){
            if($('.navbar-left').hasClass('navbar-left-collapse')){
                $('.navbar-left').removeClass('navbar-left-collapse');
                $('.content').addClass('navbar-left-margin');
            }else{
                $('.navbar-left').addClass('navbar-left-collapse');
                $('.content').removeClass('navbar-left-margin');
            }
        });
        $('.navbar-left .close').click(function(){
            $('.navbar-toggle').trigger('click');
        });
        _resize();
    });
    
    function _resize()
    {
        var height = $(window).height();
        $('.navbar-left').css({
            height:height+'px'
        });
        $('iframe[name="main"]').prop('height',height - 55);
    }
    window.onresize = _resize;
</script>
@endpush