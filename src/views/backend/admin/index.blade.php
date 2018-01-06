@extends("layouts.backend.layout")
@section("title","管理员列表")

@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-topbar">
        <form class="form-inline" method="get" action="{{route("adminlist")}}">
            <div class="form-group">
                <label class="control-label">关键词</label>
                <input type="text" name="keyword" value="{{request()->input("keyword")}}" class="form-control input-sm" placeholder="输入关键词">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default btn-sm">搜索</button>
            </div>
        </form>
    </div>
    <div class="data-header">
        <h4 class="data-title pull-left">管理员列表</h4>
        <a dobatch="confirm" href="{{route("admindeletebatch")}}" method="post" message="确定要删除吗?" selector="input[name='id']:checked" class="btn btn-danger btn-xs pull-left">删除</a>
        <a href="{{route("adminadd")}}" class="btn btn-success btn-xs pull-left">添加</a>
    </div>
    <div class="data">
        <table class="table table-hover table-striped">
            <tr>
                <th><input class="checkbox-control" data-target="input[name='id']" type="checkbox" /></th>
                <th>{!!ViewHelper::sort()->make($list,"编号","admin_id")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"登录名称","name")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"昵称","nick_name")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"电子邮箱","email")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"最后登录时间","last_login_time")!!}</th>
                <th><span class="text-muted">最后登录IP</span></th>
                <th>{!!ViewHelper::sort()->make($list,"创建时间","created_at")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"是否冻结","enabled")!!}</th>
                <th><span class="text-muted">操作</span></th>
            </tr>
            @if(count($list))
            @foreach($list as $key=>$admin)
            <tr>
                <td><input name="id" type="checkbox" value="{{$admin->admin_id}}" /></td>
                <td>{{$admin->admin_id}}</td>
                <td><a href="{{route('adminedit',['id'=>$admin->admin_id])}}">{{$admin->name}}</a></td>
                <td>{{$admin->nick_name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{$admin->last_login_time}}</td>
                <td>{{$admin->last_login_ip}}</td>
                <td>{{$admin->created_at}}</td>
                <td>{{$admin->enabled?"否":"是"}}</td>
                <td>
                    <a href="{{route("adminedit",['id'=>$admin->admin_id])}}" class="btn btn-xs btn-primary">编辑</a>
                    <a dobatch="confirm" href="{{route("admindeletebatch")}}" method="post" value="{{$admin->admin_id}}" message="确定删除吗" class="btn btn-xs btn-danger">删除</a>
                </td>
            </tr>
            @endforeach
            @else
            <td colspan="10" class="text-muted bg-warning text-center">无记录</td>
            @endif
        </table>
        {!! $list->appends(\Illuminate\Support\Facades\Input::get())->links("layouts.backend.pager") !!}
    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}" />
@endsection

@push("inline")
@endpush