@extends("layouts.backend.layout")
@section("title","角色列表")

@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title pull-left">角色列表</h4>
        @permission("role.delete")
        <a dobatch="confirm" href="{{route("roledeletebatch")}}" method="post" message="确定要删除吗?" selector="input[name='id']:checked" class="btn btn-danger btn-xs pull-left">删除</a>
        @endpermission
        @permission("role.add")
        <a href="{{route("roleadd")}}" class="btn btn-success btn-xs pull-left">添加</a>
        @endpermission
    </div>
    <div class="data">
        <table class="table table-hover table-striped">
            <tr>
                <th><input class="checkbox-control" data-target='input[name="id"]' type="checkbox" /></th>
                <th>{!!ViewHelper::sort()->make($list,"编号","role_id")!!}</th>
                <th>{!!ViewHelper::sort()->make($list,"角色名","role_name")!!}</th>
                <th><span class="text-muted">描述</span></th>
                <th class="hidden-xs">{!!ViewHelper::sort()->make($list,"创建时间","created_at")!!}</th>
                <th class="hidden-xs">{!!ViewHelper::sort()->make($list,"修改时间","updated_at")!!}</th>
                <th><span class="text-muted">操作</span></th>
            </tr>
            @foreach($list as $key=>$item)
            <tr>
                <td><input name="id" type="checkbox" value="{{$item->role_id}}"></td>
                <td>{{$item->role_id}}</td>
                <td>
                    @permission("role.edit")
                    <a href="{{route('roleedit',['id'=>$item->role_id])}}">{{$item->role_name}}</a>
                    @else
                    {{$item->role_name}}
                    @endpermission
                </td>
                <td>
                    <p class="info">{{$item->remark}}</p>
                    @if($item->remark)
                    <i class="iconfont icon-infocircle" data-toggle="popover" data-content="{{$item->remark}}"></i>
                    @endif
                </td>
                <td class="hidden-xs">{{$item->created_at}}</td>
                <td class="hidden-xs">{{$item->updated_at}}</td>
                <td>
                    @permission("role.edit")
                    <a href="{{route("roleedit",['id'=>$item->role_id])}}" class="btn btn-xs btn-primary">编辑</a>
                    @endpermission
                    @permission("role.delete")
                    <a dobatch="confirm" href="{{route("roledeletebatch")}}" method="post" value="{{$item->role_id}}" message="确定删除吗" class="btn btn-xs btn-danger">删除</a>
                    @endpermission
                </td>
            </tr>
            @endforeach
        </table>
        @if(!count($list))
        <div class="table-no-data text-muted bg-warning text-center">无记录</div>
        @endif
        {!! $list->appends(\Illuminate\Support\Facades\Input::get())->links("layouts.backend.pager") !!}
    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}" />
@endsection

@push('inline')
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="popover"]').click(function(){
            $(this).toggleClass('active');
        }).popover({trigger:"hover click"});
    });
</script>
@endpush