@extends("layouts.backend.layout")
@section("title","编辑角色")

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('formvalidation/css/formValidation.min.css')}}" />
<style type="text/css">
    .permission{overflow: hidden;padding-bottom: 20px;}
    .permission-label{float: left;width: 100px;}
    .permission-list{float: left;}
</style>
@endpush

@push('script')
<script type="text/javascript" src="{{asset('formvalidation/js/formValidation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('formvalidation/js/framework/bootstrap.min.js')}}"></script>
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title pull-left">编辑角色</h4>
    </div>
    <div class="data">
        <form class="form-horizontal" method="post" action="{{route('roleupdate',['id'=>$detail->role_id])}}">
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">角色名</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="role_name" type="text" value="{{$detail->role_name}}" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">角色描述</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <textarea class="form-control" rows="5" name="role_desc">{{$detail->remark}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">分配权限</label>
                <div class="col-xs-9 col-md-3 col-lg-3">
                    @foreach($permissions as $k=>$group)
                    <div class="permission">
                        <div class="permission-label checkbox-inline">
                            <label>
                                <input class="checkbox-control" data-target="input.role_acl_{{$k}}" type="checkbox" /> {{$group['name']}}
                            </label>
                        </div>
                        <div class="permission-list">
                            @foreach($group['list'] as $key=>$item)
                            <div class="checkbox">
                                <label>
                                    @if(in_array($key,$role_permissions))
                                    <input checked="checked" name="role_acl[]" class="role_acl_{{$k}}" type="checkbox" value="{{$key}}" /> {{$item}}
                                    @else
                                    <input name="role_acl[]" class="role_acl_{{$k}}" type="checkbox" value="{{$key}}" /> {{$item}}
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3 col-md-2 col-lg-2"></label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <button type="submit" class="btn btn-primary btn-sm">提交</button>
                    <a href="{{Referer::match(route("rolelist"))}}" class="btn btn-default btn-sm">返回</a>
                </div>
            </div>
            <input type="hidden" name="_referer" value="{{Referer::match(route("rolelist"))}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
</div>
@endsection

@push('inline')
<script type="text/javascript">
    $(document).ready(function(){
        $('form').bootstrapValidator({
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                role_name: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {
                            max: 16,
                            message: '长度不能超过16位'
                        }
                    }
                },
                role_desc: {
                    validators: {
                        stringLength: {
                            max: 255,
                            message: '长度不能超过255位'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush