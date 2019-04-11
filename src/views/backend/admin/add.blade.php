@extends("layouts.backend.layout")
@section("title","添加管理员")

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('formvalidation/css/formValidation.min.css')}}" />
@endpush

@push('script')
<script type="text/javascript" src="{{asset('formvalidation/js/formValidation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('formvalidation/js/framework/bootstrap.min.js')}}"></script>
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title pull-left">添加管理员</h4>
    </div>
    <div class="data">
        <form class="form-horizontal" method="post" action="{{route('adminstore')}}">
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">登录名称</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="name" type="text" value="" autocomplete="off" />
                    <small class="help-block">可以包含字母、数字或下划线，须以字母开头，长度为4-16个字符</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">密码</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="password" type="password" autocomplete="off" />
                    <small class="help-block">可以包含字母、数字以及特殊符号，长度为6-32个字符</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">确认密码</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="repassword" type="password" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">昵称</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="nick_name" type="text" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">邮箱</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="email" type="text" autocomplete="off" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3 col-md-2 col-lg-2">是否可用</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <label class=" radio-inline">
                        <input type="radio" name="enabled" value="1" checked="checked" />是
                    </label>
                    <label class=" radio-inline">
                        <input type="radio" name="enabled" value="0" />否
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">分配角色</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    @foreach($role_list as $role)
                    <label class=" checkbox-inline">
                        <input name="role_ids[]" type="checkbox" value="{{$role->role_id}}" /> {{$role->role_name}}
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3 col-md-2 col-lg-2"></label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <button type="submit" class="btn btn-primary btn-sm">提交</button>
                    <a href="{{Referer::match(route("adminlist"))}}" class="btn btn-default btn-sm">返回</a>
                </div>
            </div>
            <input type="hidden" name="_referer" value="{{Referer::match(route("adminlist"))}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
</div>
@endsection

@push("inline")
<script type="text/javascript">
    $(document).ready(function(){
        $('form').bootstrapValidator({
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {
                            min: 4,
                            max: 16,
                            message: '长度必须在4到16位之间'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 32,
                            message: '长度必须在6到32位之间'
                        }
                    }
                },
                repassword:{
                    validators:{
                        notEmpty: {
                            message: '不能为空'
                        },
                        identical: {
                            field: 'password',
                            message: '两次密码输入不一致'
                        }
                    }
                },
                nick_name:{
                    validators:{
                        stringLength: {
                            max: 20,
                            message: '长度不超过20个字符'
                        }
                    }
                },
                email:{
                    validators:{
                        notEmpty:{
                            message:"不能为空"
                        },
                        emailAddress:{
                            message:"格式不正确"
                        }
                    }
                }
            }
        });
    });
</script>
@endpush