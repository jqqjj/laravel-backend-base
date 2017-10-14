<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>后台用户列表</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/verydows.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/verydows.js')}}"></script>
<script type="text/javascript" src="{{asset('js/list.js')}}"></script>
</head>
<body>
<div class="content">
    <div class="loc"><h2><i class="icon"></i>后台用户列表</h2></div>
    <div class="box">
        <div class="doacts">
          <a class="ae add btn" href="{{route("adminadd")}}"><i></i><font>添加</font></a>
          <a class="ae btn" dobatch="confirm" primary="id" method="post" href="{{url("admin/admindeletebatch")}}"><i class="remove"></i><font>删除</font></a>
        </div>
        @if(count($list))
        <div class="module mt5">
            <table class="datalist">
                <tr>
                    <th width="50" colspan="2">{!!ViewHelper::sort()->make($list,"编号","admin_id")!!}</th>
                    <th class="ta-l">{!!ViewHelper::sort()->make($list,"登录名称","name")!!}</th>
                    <th class="ta-l" width="">{!!ViewHelper::sort()->make($list,"昵称","nick_name")!!}</th>
                    <th class="ta-l" width="">{!!ViewHelper::sort()->make($list,"电子邮箱","email")!!}</th>
                    <th width="">{!!ViewHelper::sort()->make($list,"最后登录时间","last_login_time")!!}</th>
                    <th width="">最后登录IP</th>
                    <th width="">{!!ViewHelper::sort()->make($list,"创建时间","created_at")!!}</th>
                    <th width="">{!!ViewHelper::sort()->make($list,"是否冻结","enabled")!!}</th>
                    <th width="200">操作</th>
                </tr>
                @foreach($list as $key=>$admin)
                <tr>
                    <td width="20"><input name="id" type="checkbox" value="{{$admin->admin_id}}" /></td>
                    <td width="30">{{$admin->admin_id}}</td>
                    <td class="ta-l"><a class="blue" href="{{route('adminedit',['id'=>$admin->admin_id])}}">{{$admin->name}}</a></td>
                    <td class="ta-l">{{$admin->nick_name}}</td>
                    <td class="ta-l">{{$admin->email}}</td>
                    <td class="c888">{{$admin->last_login_time}}</td>
                    <td class="c888">{{$admin->last_login_ip}}</td>
                    <td class="c888">{{$admin->created_at}}</td>
                    <td class="c888">{{$admin->enabled?"否":"是"}}</td>
                    <td class="c888">
                        <a class="ae btn" href="{{route("adminedit",['id'=>$admin->admin_id])}}"><i class="edit"></i><font>编辑</font></a>
                        <a class="ae btn" dobatch="confirm" primary="id" value="{{$admin->admin_id}}" method="post" href="{{url("admin/admindeletebatch")}}"><i class="remove"></i><font>删除</font></a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @else
        <div class="nors mt5">未找到相关数据记录...</div>
        @endif
        {!! $list->appends(\Illuminate\Support\Facades\Input::get())->links("layouts.backend.pager") !!}
    </div>
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
</div>
</body>
</html>