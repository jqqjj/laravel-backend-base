@extends("layouts.backend.layout")
@section("title","添加新角色")
@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="content">
	<div class="loc">
		<h2><i class="icon"></i>添加新角色</h2>
	</div>
	<form method="post" action="{{route('rolestore')}}">
		<div class="box">
			<div class="module">
				<table class="dataform">
				<tbody>
				<tr>
					<th width="110">角色名</th>
					<td><input class="w200 txt" name="role_name" id="role_name" type="text"></td>
				</tr>
				<tr>
					<th>角色描述</th>
					<td>
						<textarea name="role_desc" id="role_desc" class="txtarea" cols="68" rows="4"></textarea>
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
								<li><label><input type="checkbox" name="role_acl[]" value="{{$key}}"><font class="ml5">{{$item}}</font></label></li>
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
                <button type="submit" class="ubtn btn">保存提交</button>
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
    $('div.ckrow h4 label').click( function(){
        var cbs = $(this).parent().next('ul').children('li').find('input[type="checkbox"]');
        if($(this).find('input[type="checkbox"]').prop('checked')){
          cbs.prop('checked', true);
        }else{
          cbs.prop('checked', false);
        }
    });
    $('form').submit(function(){
        $('#role_name').vdsFieldChecker({rules:{required:[true, '角色名不能为空'], maxlen:[50, '角色名不能超过50个字符']}});
        $('#role_desc').vdsFieldChecker({rules:{maxlen:[240, '角色描述不能超过240个字符']}, tipsPos:'br'});
        return $('form').vdsFormChecker();
    });
});
</script>
@endpush