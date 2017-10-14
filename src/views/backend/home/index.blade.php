<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/verydows.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/panel.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/verydows.js')}}"></script>
<script type="text/javascript" src="{{asset('js/panel.js')}}"></script>
</head>
<body>
<!-- 头部开始 -->
<div class="header" id="header">
	<div class="logo fl">
		<a href="/index.php?m=backend&c=main&a=panel">Verydows Panel</a>
	</div>
	<div class="top-links fr cut">
		<a title="前端首页" class="icon front" target="_blank" href="/">前端首页</a>
		<a title="设置" class="icon sets" href="/index.php?m=backend&c=setting&a=index">设置</a>
		<a title="用户信息" class="icon user" onclick="popAc('pop-user')">用户信息</a>
		<a title="清理缓存" class="icon wipe" onclick="popAc('pop-clean')">清理缓存</a>
		<a title="退出登录" class="icon logout" href="{{route("adminlogout")}}">退出登录</a>
	</div>
</div>
<div class="module hdline">
</div>
<div class="acpop hide" id="pop-user">
	<a class="close" onclick="closeUser()">×</a>
	<h2 class="c999">登录用户: <font class="f14 c666 ml5">admin</font></h2>
	<div class="module poinfo cut">
		<dl>
			<dt>姓名</dt>
			<dd><font class="c999">未设置</font></dd>
		</dl>
		<dl>
			<dt>邮箱</dt>
			<dd>jqqjj@qq.com</dd>
		</dl>
		<dl>
			<dt>上次登录时间</dt>
			<dd>2017-07-26 13:54:11</dd>
		</dl>
		<dl>
			<dt>上次登录IP</dt>
			<dd>127.0.0.1</dd>
		</dl>
		<div class="bl">
		</div>
		<div class="pwd mt15 hide" id="pwd">
			<form method="post" action="/index.php?m=backend&c=main&a=reset_password">
				<dl>
					<dt>原密码</dt>
					<dd><input class="txt" name="old_password" id="old_password" type="password"/></dd>
				</dl>
				<dl>
					<dt>新密码</dt>
					<dd><input class="txt" name="new_password" id="new_password" type="password"/></dd>
				</dl>
				<dl>
					<dt>确认新密码</dt>
					<dd><input class="txt" name="repassword" id="repassword" type="password"/></dd>
				</dl>
			</form>
		</div>
	</div>
	<div class="ta-c">
		<button type="button" class="ubtn sm btn hide" onclick="submitPwd()">确定修改</button>
		<button type="button"class="fbtn sm btn" onclick="resetPwd()">重设密码</button>
		<span class="sep20"></span>
		<button type="button" class="fbtn sm btn" onclick="closeUser()">关闭</button>
	</div>
</div>
<div class="acpop hide" id="pop-clean">
	<a class="close" onclick="closeAc('pop-clean')">×</a>
	<h2 class="c999">清理缓存</h2>
	<div class="poinfo cut">
		<ul id="clean-select">
			<li><label onclick="checkAllClean()"><input type="checkbox"/><font>全部清理</font></label></li>
			<li><label><input name="clean" type="checkbox" value="data"/><font>清理数据缓存</font></label></li>
			<li><label><input name="clean" type="checkbox" value="template"/><font>清理模板缓存</font></label></li>
			<li><label><input name="clean" type="checkbox" value="static"/><font>清理静态缓存</font></label></li>
		</ul>
		<div class="cleaning cut hide" id="cleaning">
			<h3 class="c888 f14">正在清理</h3>
			<div class="loading x-auto">
			</div>
		</div>
	</div>
	<div class="ta-c">
		<button type="button" class="ubtn sm btn" onclick="cleanCache('/index.php?m=backend&c=cleaner&a=wiping')">确定清理</button>
		<span class="sep20"></span>
		<button type="button" class="fbtn sm btn" onclick="closeAc('pop-clean')">取消</button>
	</div>
</div>
<!-- 头部结束 -->
<div class="container">
	<!-- 菜单开始 -->
	<div class="nav fl" id="nav">
		<h2>常用菜单</h2>
		<div class="nochild">
			<ul>
				<li onclick="jump('dashboard')"><a><i class="arrow"></i>面板首页</a></li>
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
				<li onclick="jump('c=user&amp;a=index')"><a><i class="arrow"></i>用户列表</a></li>
				<li onclick="jump('c=user_group&amp;a=index')"><a><i class="arrow"></i>用户组</a></li>
				<li onclick="jump('c=user_account_log&amp;a=index')"><a><i class="arrow"></i>账户日志</a></li>
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
				<li onclick="jump('{{route("adminlist")}}')"><a><i class="arrow"></i>后台用户列表</a></li>
                @endpermission
                @permission('role.list')
				<li onclick="jump('{{route("rolelist")}}')"><a><i class="arrow"></i>角色列表</a></li>
                @endpermission
			</ul>
		</div>
        @endpermission
		<div>
			<h3><a><i class="arrow"></i>系统配置</a></h3>
			<ul>
				<li onclick="jump('c=setting&amp;a=index')"><a><i class="arrow"></i>系统设置</a></li>
				<li onclick="jump('c=nav&amp;a=index')"><a><i class="arrow"></i>导航设置</a></li>
				<li onclick="jump('c=shipping_method&amp;a=index')"><a><i class="arrow"></i>配送方式</a></li>
				<li onclick="jump('c=payment_method&amp;a=index')"><a><i class="arrow"></i>支付方式</a></li>
				<li onclick="jump('c=shipping_carrier&amp;a=index')"><a><i class="arrow"></i>物流承运商</a></li>
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
	<!-- 菜单结束 -->
    <div class="fl gap on" id="gap" style="height: 212px;"></div>
	<!-- 主体开始 -->
	<div class="rwrap">
		<iframe name="main" id="main" scrolling="auto" width="100%" height="700" frameborder="0" src="{{route('dashboard')}}">
		</iframe>
	</div>
	<!-- 主体结束 -->
    <div id="slide" class="slide on"></div>
</div>
<!-- 页脚开始 -->
<div class="footer" id="footer">
	<p>
		Powered by CRM © 2017
	</p>
</div>
<!-- 页脚结束-->
<script>
function jump(uri){
  parent.$('#main').attr('src', uri);
}
$(document).ready(function(){
    $("#slide").click(function(){
        if($(this).hasClass('on')){
            $(this).removeClass('on');
            $('#gap').removeClass('on');
            $('#nav').hide();
        }else{
            $(this).addClass('on');
            $("#gap").addClass('on');
            $('#nav').show();
        }
        $(this).blur();
    });
});
</script>
</body>
</html>