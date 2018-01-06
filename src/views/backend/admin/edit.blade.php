@extends("layouts.backend.layout")
@section("title","编辑管理员")

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
        <h4 class="data-title pull-left">编辑管理员</h4>
    </div>
    <div class="data">
        <form class="form-horizontal" method="post" action="{{route('adminupdate',['id'=>$admin->admin_id])}}">
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">登录名称</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="name" type="text" value="{{$admin->name}}"/>
                    <small class="help-block">可以包含字母、数字或下划线，须以字母开头，长度为4-16个字符</small>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label"></label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <button type="button" class="btn btn-default btn-sm reset-password">重新设置密码</button>
                </div>
            </div>
            <div class="form-group hidden">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">密码</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="password" type="password" />
                    <small class="help-block">可以包含字母、数字以及特殊符号，长度为6-32个字符</small>
                </div>
            </div>
            <div class="form-group hidden">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">确认密码</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="repassword" type="password" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">昵称</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="nick_name" type="text" value="{{$admin->nick_name}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">邮箱</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <input class="form-control input-sm" name="email" type="text" value="{{$admin->email}}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3 col-md-2 col-lg-2">冻结</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <label class=" radio-inline">
                        @if(!$admin->enabled)
                        <input type="radio" checked="checked" name="enabled" value="0" />是
                        @else
                        <input type="radio" name="enabled" value="0" />是
                        @endif
                    </label>
                    <label class=" radio-inline">
                        @if($admin->enabled)
                        <input type="radio" checked="checked" name="enabled" value="1" />否
                        @else
                        <input type="radio" name="enabled" value="1" />否
                        @endif
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">分配角色</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    @foreach($role_list as $role)
                    <label class=" checkbox-inline">
                        @if(in_array($role->role_id,$admin_roles))
                        <input name="role_ids[]" checked="checked" type="checkbox" value="{{$role->role_id}}" /> {{$role->role_name}}
                        @else
                        <input name="role_ids[]" type="checkbox" value="{{$role->role_id}}" /> {{$role->role_name}}
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">最后登录时间</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <p class="form-control-static">{{$admin->last_login_time}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">最后登录IP</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <p class="form-control-static">{{$admin->last_login_ip}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 col-md-2 col-lg-2 control-label">创建日期</label>
                <div class="col-xs-6 col-md-3 col-lg-3">
                    <p class="form-control-static">{{$admin->created_at}}</p>
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
        $('.reset-password').click(function(){
            $(this).parents('.form-group').addClass('hidden').siblings().removeClass('hidden');
        });
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