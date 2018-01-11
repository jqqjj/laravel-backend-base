<div class="navbar-left">
    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div class="text-center avatar"><i class="iconfont icon-group"></i></div>
    <div class="text-center">欢迎，{{ViewHelper::admin()->autoname()}}</div>
    <ul class="menu-list">
        <li class="menu-item">
            <a href="{{route("dashboard")}}" target="main"><i class="iconfont icon-homepage"></i>首页</a>
        </li>
        <li class="menu-item">
            <a href="javascript:;"><i class="iconfont icon-setup"></i>设置</a>
            <ul class="sub-menu-list">
                @permission('cache.clear')
                <li class="sub-menu-item"><a href="{{route("clearsystemcache")}}" target="main">清理缓存</a></li>
                @endpermission
                <li class="sub-menu-item"><a href="{{route("admin-profile")}}" target="main">修改资料密码</a></li>
            </ul>
        </li>
        @permission('admin.list|role.list')
        <li class="menu-item">
            <a href="javascript:;"><i class="iconfont icon-browse"></i>权限管理</a>
            <ul class="sub-menu-list">
                @permission('admin.list')
                <li class="sub-menu-item"><a href="{{route("adminlist")}}" target="main">管理员列表</a></li>
                @endpermission
                @permission('role.list')
                <li class="sub-menu-item"><a href="{{route("rolelist")}}" target="main">角色列表</a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
</div>
@push("inline")
@endpush