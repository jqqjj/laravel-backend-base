@extends("layouts.backend.layout")
@section("title","编辑后台用户")
@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="content">
	<div class="loc">
		<h2><i class="icon"></i>编辑后台用户:<font class="ml5"></font></h2>
	</div>
	<form method="post" action="{{route('adminupdate',['id'=>$admin->admin_id])}}">
		<div class="box">
			<div class="module">
				<table class="dataform">
				<tr>
					<th width="110">
						登录名称
					</th>
					<td>
						<input class="w200 txt" name="name" id="username" type="text" value="{{$admin->name}}"/>
						<p class="c999 mt10">
							可以包含字母、数字或下划线，须以字母开头，长度为4-16个字符
						</p>
					</td>
				</tr>
				<tr>
					<th>
						重设密码
					</th>
					<td>
						<button type="button" class="cbtn sm btn" onclick="resetPwd(this)">点击重新设置密码</button>
						<input type="hidden" name="resetpwd" id="resetpwd" value=""/>
						<p class="c999 mt10">
							如需重设密码请点击以上按钮，否则密码保持不变
						</p>
					</td>
				</tr>
				<tr class="setpwd hide">
					<th>
						密码
					</th>
					<td>
						<input class="w200 txt" name="password" id="password" type="password"/>
						<p class="c999 mt10">
							可以包含字母、数字以及特殊符号，长度为6-32个字符
						</p>
					</td>
				</tr>
				<tr class="setpwd hide">
					<th>
						确认密码
					</th>
					<td>
						<input class="w200 txt" name="repassword" id="repassword" type="password"/>
					</td>
				</tr>
                <tr>
					<th>
						昵称
					</th>
					<td>
						<input class="w200 txt" name="nick_name" id="nick_name" type="text" value="{{$admin->nick_name}}"/>
					</td>
				</tr>
				<tr>
					<th>
						电子邮箱
					</th>
					<td>
						<input class="w200 txt" name="email" id="email" type="text" value="{{$admin->email}}"/>
					</td>
				</tr>
				<tr>
					<th>
						分配角色
					</th>
					<td>
						<div class="ckrow mt5 pad5 cut">
							<ul class="c666">
                                @foreach($role_list as $role)
                                @if(in_array($role->role_id,$admin_roles))
								<li><label><input checked="checked" type="checkbox" name="role_ids[]" value="{{$role->role_id}}"/><font class="ml5">{{$role->role_name}}</font></label></li>
                                @else
                                <li><label><input type="checkbox" name="role_ids[]" value="{{$role->role_id}}"/><font class="ml5">{{$role->role_name}}</font></label></li>
                                @endif
                                @endforeach
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						冻结
					</th>
					<td>
						<div class="ckrow mt5 pad5 cut">
							<ul class="c666">
                                <li style="width: 45px;"><label><input type="radio" @if(!$admin->enabled)checked="checked"@endif name="enabled" value="0"/><font class="ml5">是</font></label></li>
                                <li style="width: 45px;"><label><input type="radio" @if($admin->enabled)checked="checked"@endif name="enabled" value="1"/><font class="ml5">否</font></label></li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						最后登录时间
					</th>
					<td>
						<p class="pad5 c999">
							{{$admin->last_login_time}}
						</p>
					</td>
				</tr>
				<tr>
					<th>
						最后登录IP
					</th>
					<td>
						<p class="pad5 c999">
                            {{$admin->last_login_ip}}
						</p>
					</td>
				</tr>
				<tr>
					<th>
						创建日期
					</th>
					<td>
						<p class="pad5 c999">
							{{$admin->created_at}}
						</p>
					</td>
				</tr>
				</table>
			</div>
			<div class="submitbtn">
                <button type="submit" class="ubtn btn">保存并更新</button>
				<button type="reset" class="fbtn btn">重置表单</button>
                <input type="hidden" name="_referer" value="{{request()->server("HTTP_REFERER")}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
			</div>
		</div>
	</form>
</div>
@endsection

@push("inline")
<script type="text/javascript">
$(document).ready(function(){
    $('form').submit(function(){
        $('#username').vdsFieldChecker({rules:{username:[/^[_a-zA-Z0-9]{4,15}$/.test($('#username').val()), '登录名称不符合格式要求']}});
        if($('#resetpwd').val() == 1){
          $('#password').vdsFieldChecker({rules:{required:[true, '请设置密码'], password:[true, '密码不符合格式要求']}});
        }
        $('#repassword').vdsFieldChecker({rules:{equal:[$('#password').val(), '两次密码不一致']}});
        $('#email').vdsFieldChecker({rules:{required:[true, '电子邮箱不能为空'], email:[true, '无效的电子邮箱地址']}});
        return $('form').vdsFormChecker();
    });
});
function resetPwd(btn){
  $('.setpwd').removeClass('hide');
  $('#resetpwd').val(1);
  $(btn).parentsUntil('tr').parent().addClass('hide');
}
</script>
@endpush