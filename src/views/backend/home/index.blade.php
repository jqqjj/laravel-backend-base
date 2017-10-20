@extends("layouts.backend.layout")
@section("title","后台管理系统")

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/panel.css')}}" />
@endpush

@push('script')
<script type="text/javascript" src="{{asset('backend/js/panel.js')}}"></script>
@endpush

@section("content")
<!-- 头部开始 -->
<div class="header" id="header">
	<div class="logo fl">
		<a href="{{route("adminindex")}}">CMS</a>
	</div>
	<div class="top-links fr cut">
		<a title="前端首页" class="icon front" target="_blank" href="/">前端首页</a>
		<a title="设置" class="icon sets" href="javascript:;">设置</a>
		<a title="用户信息" class="icon user" onclick="popAc('pop-user')">用户信息</a>
		<a title="清理缓存" class="icon wipe" onclick="popAc('pop-clean')">清理缓存</a>
		<a title="退出登录" class="icon logout" href="{{route("adminlogout")}}">退出登录</a>
	</div>
</div>
<div class="module hdline">
</div>
<div class="acpop hide" id="pop-user">
	<a class="close" onclick="closeUser()">×</a>
	<h2 class="c999">登录用户: <font class="f14 c666 ml5">{{Auth::guard("backend")->user()->name}}</font></h2>
    <form method="post" name="resetpassword" action="{{route("admin-change-password")}}">
        <div class="module poinfo cut">
            <dl>
                <dt>姓名</dt>
                <dd>@if(Auth::guard("backend")->user()->nick_name) Auth::guard("backend")->user()->nick_name @else<font class="c999">未设置</font>@endif</dd>
            </dl>
            <dl>
                <dt>邮箱</dt>
                <dd>@if(Auth::guard("backend")->user()->email) Auth::guard("backend")->user()->email @else<font class="c999">未设置</font>@endif</dd>
            </dl>
            <dl>
                <dt>上次登录时间</dt>
                <dd>{{Session::get("backend_last_login_time")}}</dd>
            </dl>
            <dl>
                <dt>上次登录IP</dt>
                <dd>{{Session::get("backend_last_login_ip")}}</dd>
            </dl>
            <div class="bl">
            </div>
            <div class="pwd mt15 hide" id="pwd">
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
            </div>
        </div>
        <div class="ta-c">
            <input type="hidden" name="_token" value="{{csrf_token()}}" />
            <button type="submit" class="ubtn sm btn hide">确定修改</button>
            <button type="button"class="fbtn sm btn" onclick="resetPwd()">重设密码</button>
            <span class="sep20"></span>
            <button type="button" class="fbtn sm btn" onclick="closeUser()">关闭</button>
        </div>
    </form>
</div>
<div class="acpop hide" id="pop-clean">
	<a class="close" onclick="closeAc('pop-clean')">×</a>
	<h2 class="c999">清理缓存</h2>
	<div class="poinfo cut">
		<ul id="clean-select">
			<li><label onclick="checkAllClean()"><input type="checkbox"/><font>全部清理</font></label></li>
			<li><label><input name="clean" type="checkbox" value="config"/><font>清理配置缓存</font></label></li>
			<li><label><input name="clean" type="checkbox" value="template"/><font>清理模板缓存</font></label></li>
			<li><label><input name="clean" type="checkbox" value="data"/><font>清理数据缓存</font></label></li>
		</ul>
		<div class="cleaning cut hide" id="cleaning">
			<h3 class="c888 f14">正在清理</h3>
			<div class="loading x-auto">
			</div>
		</div>
	</div>
	<div class="ta-c">
		<button type="button" class="ubtn sm btn clearcache">确定清理</button>
		<span class="sep20"></span>
		<button type="button" class="fbtn sm btn" onclick="closeAc('pop-clean')">取消</button>
	</div>
</div>
<!-- 头部结束 -->
<div class="container">
	<!-- 菜单开始 -->
    @include("layouts.backend.menubar")
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
	<p>Powered by CMS © 2017</p>
</div>
@endsection

@push("inline")
<script>
$(document).ready(function(){
    $('#slide').vdsVertical();
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
    $('.clearcache').click(function(){
        var selected = $('#clean-select input[name="clean"]:checked');
        if(selected.size() < 1){
          $('body').vdsAlert({msg:'请选择至少一种您需要清理的类型', time:2});
          return false;
        }
        var clean = [];
        selected.each(function(){
          clean.push($(this).val());
        });
        $.ajax({
          type: 'post',
          dataType: 'json',
          url: "{{route('clearsystemcache')}}",
          data: {clean:clean,_token:"{{csrf_token()}}"},
          beforeSend: function(){$('#clean-select').hide();$('#cleaning').show();},
          success: function(res){
            $('#clean-select').show();
            $('#cleaning').hide();
            if(res.ret === 0){
                closeAc('pop-clean');
                $('body').vdsAlert({msg:res.message, time:1});
            }else{
              $('body').vdsAlert({msg:res.message, time:2});
            }
          },
          error: function(){
            $('#clean-select').show();
            $('#cleaning').hide();
            $('body').vdsAlert({msg:"处理请求时发生错误"});
          }
        });
    });
    $('form[name="resetpassword"]').submit(function(){
        $('#old_password').vdsFieldChecker({rules: {required:[true, '请输入旧密码']}, tipsPos:'br'});
        $('#new_password').vdsFieldChecker({rules: {required:[true, '请设置新密码'], password:[true, '新密码不符合格式要求']}, tipsPos:'br'});
        $('#repassword').vdsFieldChecker({rules: {equal:[$('#new_password').val(), '两次密码不一致']}, tipsPos:'br'});
        return $('form[name="resetpassword"]').vdsFormChecker();
    });
});
</script>
@endpush