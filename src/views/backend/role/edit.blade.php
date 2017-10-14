<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>编辑角色</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/verydows.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/verydows.js')}}"></script>
</head>
<body>
<script type="text/javascript">
$(function(){
  $('div.ckrow h4 label').click( function(){
    var cbs = $(this).parent().next('ul').children('li').find('input[type="checkbox"]');
    if($(this).find('input[type="checkbox"]').prop('checked')){
      cbs.prop('checked', true);
    }else{
      cbs.prop('checked', false);
    }
  });
});
function submitForm(){
  $('#role_name').vdsFieldChecker({rules:{required:[true, '角色名不能为空'], maxlen:[50, '角色名不能超过50个字符']}});
  $('#role_desc').vdsFieldChecker({rules:{maxlen:[240, '角色描述不能超过240个字符']}, tipsPos:'br'});
  $('form').vdsFormChecker();
}
</script>
<div class="content">
	<div class="loc">
		<h2><i class="icon"></i>编辑角色</h2>
	</div>
	<form method="post" action="{{route('roleupdate',['id'=>$detail->role_id])}}">
		<div class="box">
			<div class="module">
				<table class="dataform">
				<tbody>
				<tr>
					<th width="110">角色名</th>
                    <td><input class="w200 txt" name="role_name" id="role_name" value="{{$detail->role_name}}" type="text"></td>
				</tr>
				<tr>
					<th>角色描述</th>
					<td>
						<textarea name="role_desc" id="role_desc" class="txtarea" cols="68" rows="4">{{$detail->remark}}</textarea>
					</td>
				</tr>
				<tr>
					<th>分配权限</th>
					<td>
                        @foreach($permissions as $group)
						<div class="ckrow pad5 cut">
							<h4 class="c666"><label><input type="checkbox"><font class="ml5">{{$group['name']}}</font></label></h4>
							<ul class="c666 mult">
                                @foreach($group['list'] as $key=>$item)
                                @if(in_array($key,$role_permissions))
                                <li><label><input type="checkbox" checked name="role_acl[]" value="{{$key}}"><font class="ml5">{{$item}}</font></label></li>
                                @else
                                <li><label><input type="checkbox" name="role_acl[]" value="{{$key}}"><font class="ml5">{{$item}}</font></label></li>
                                @endif
                                @endforeach
							</ul>
						</div>
                        @endforeach
					</td>
				</tr>
				</tbody>
				</table>
			</div>
			<div class="submitbtn">
				<button type="button" class="ubtn btn" onclick="submitForm()">保存并提交</button>
				<button type="reset" class="fbtn btn">重置表单</button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
			</div>
		</div>
	</form>
</div>
</body>
</html>