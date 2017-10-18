@extends("layouts.backend.layout")
@section("title","角色列表")
@push('css')
@endpush

@push('script')
<script type="text/javascript" src="{{asset('backend/js/list.js')}}"></script>
@endpush

@section("content")
<div class="content">
    <div class="loc"><h2><i class="icon"></i>角色列表</h2></div>
    <div class="box">
        <div class="doacts">
          <a class="ae add btn" href="{{route("roleadd")}}"><i></i><font>添加新角色</font></a>
          <a class="ae btn" dobatch="confirm" primary="id" method="post" msg="确定要删除吗?" href="{{url("admin/roledeletebatch")}}"><i class="remove"></i><font>删除</font></a>
        </div>
        @if(count($list))
        <div class="module mt5">
            <table class="datalist">
                <tr class="even">
                    <th width="50" colspan="2">{!!ViewHelper::sort()->make($list,"编号","role_id")!!}</th>
                    <th width="" class="ta-l">{!!ViewHelper::sort()->make($list,"角色名","role_name")!!}</th>
                    <th class="ta-l">描述</th>
                    <th width="200" class="ta-l">{!!ViewHelper::sort()->make($list,"创建时间","created_at")!!}</th>
                    <th width="200" class="ta-l">{!!ViewHelper::sort()->make($list,"修改时间","updated_at")!!}</th>
                    <th width="250">操作</th>
                </tr>
                @foreach($list as $key=>$item)
                <tr>
                    <td width="20"><input name="id" type="checkbox" value="{{$item->role_id}}"></td>
                    <td width="30">{{$item->role_id}}</td>
                    <td class="ta-l">
                        <a class="blue" href="{{route('roleedit',['id'=>$item->role_id])}}">{{$item->role_name}}</a>
                    </td>
                    <td class="ta-l"><p class="c666">{{$item->remark}}</p></td>
                    <td class="ta-l">{{$item->created_at}}</td>
                    <td class="ta-l">{{$item->updated_at}}</td>
                    <td class="c888">
                        <a class="ae btn" href="{{route("roleedit",['id'=>$item->role_id])}}"><i class="edit"></i><font>编辑</font></a>
                        <a class="ae btn" dobatch="confirm" primary="id" value="{{$item->role_id}}" method="post" href="{{url("admin/roledeletebatch")}}"><i class="remove"></i><font>删除</font></a>
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
@endsection

@push('inline')
@endpush