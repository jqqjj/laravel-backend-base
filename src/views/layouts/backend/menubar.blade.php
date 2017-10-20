<div class="nav fl" id="nav">
    <h2>常用菜单</h2>
    <div class="nochild">
        <ul>
            <li><a href="{{route("dashboard")}}" target="main"><i class="arrow"></i>后台中心</a></li>
        </ul>
    </div>
<!--		<div>
        <h3><a><i class="arrow"></i>商品管理</a></h3>
        <ul>
            <li onclick="jump('c=goods&amp;a=index')"><a><i class="arrow"></i>商品列表</a></li>
            <li onclick="jump('c=goods_cate&amp;a=index')"><a><i class="arrow"></i>商品分类</a></li>
            <li onclick="jump('c=brand&amp;a=index')"><a><i class="arrow"></i>品牌列表</a></li>
            <li onclick="jump('c=goods_optional_type&amp;a=index')"><a><i class="arrow"></i>选项类型</a></li>
            <li onclick="jump('c=goods_review&amp;a=index')"><a><i class="arrow"></i>商品评价</a></li>
        </ul>
    </div>
    <div>
        <h3><a><i class="arrow"></i>订单管理</a></h3>
        <ul>
            <li onclick="jump('c=order&amp;a=index')"><a><i class="arrow"></i>订单列表</a></li>
            <li onclick="jump('c=order_shipping&amp;a=index')"><a><i class="arrow"></i>发货列表</a></li>
            <li onclick="jump('c=order_log&amp;a=index')"><a><i class="arrow"></i>订单日志</a></li>
        </ul>
    </div>-->
    <div>
        <h3><a><i class="arrow"></i>用户管理</a></h3>
        <ul>
            <li><a><i class="arrow"></i>用户列表</a></li>
            <li><a><i class="arrow"></i>用户组</a></li>
            <li><a><i class="arrow"></i>账户日志</a></li>
        </ul>
    </div>
<!--		<div>
        <h3><a><i class="arrow"></i>文章管理</a></h3>
        <ul>
            <li onclick="jump('c=article&amp;a=index')"><a><i class="arrow"></i>资讯列表</a></li>
            <li onclick="jump('c=article_cate&amp;a=index')"><a><i class="arrow"></i>资讯分类</a></li>
            <li onclick="jump('c=help&amp;a=index')"><a><i class="arrow"></i>帮助列表</a></li>
            <li onclick="jump('c=help_cate&amp;a=index')"><a><i class="arrow"></i>帮助分类</a></li>
        </ul>
    </div>
    <div>
        <h3><a><i class="arrow"></i>邮件管理</a></h3>
        <ul>
            <li onclick="jump('c=email_subscription&amp;a=index')"><a><i class="arrow"></i>订阅列表</a></li>
            <li onclick="jump('c=email_tpl&amp;a=index')"><a><i class="arrow"></i>邮件模板</a></li>
            <li onclick="jump('c=email_queue&amp;a=index')"><a><i class="arrow"></i>邮件队列</a></li>
        </ul>
    </div>-->
    <h2>系统核心</h2>
    @permission('admin.list|role.list')
    <div>
        <h3><a><i class="arrow"></i>权限管理</a></h3>
        <ul>
            @permission('admin.list')
            <li><a href="{{route("adminlist")}}" target="main"><i class="arrow"></i>后台用户列表</a></li>
            @endpermission
            @permission('role.list')
            <li><a href="{{route("adminlist")}}" target="main"><i class="arrow"></i>角色列表</a></li>
            @endpermission
        </ul>
    </div>
    @endpermission
    <div>
        <h3><a><i class="arrow"></i>系统配置</a></h3>
        <ul>
            <li><a><i class="arrow"></i>系统设置</a></li>
            <li><a><i class="arrow"></i>导航设置</a></li>
            <li><a><i class="arrow"></i>配送方式</a></li>
            <li><a><i class="arrow"></i>支付方式</a></li>
            <li><a><i class="arrow"></i>物流承运商</a></li>
        </ul>
    </div>
<!--		<div>
        <h3><a><i class="arrow"></i>系统工具</a></h3>
        <ul>
            <li onclick="jump('c=file&amp;a=index')"><a><i class="arrow"></i>文件管理</a></li>
            <li onclick="jump('c=database&amp;a=backup')"><a><i class="arrow"></i>数据库</a></li>
            <li onclick="jump('c=cleaner&amp;a=index')"><a><i class="arrow"></i>系统清理</a></li>
        </ul>
    </div>-->
</div>
@push("inline")
@endpush