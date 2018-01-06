@extends("layouts.backend.layout")
@section("title","后台管理系统登录")

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/login.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('formvalidation/css/formValidation.min.css')}}" />
@endpush

@push('script')
<script type="text/javascript" src="{{asset('formvalidation/js/formValidation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('formvalidation/js/framework/bootstrap.min.js')}}"></script>
@endpush

@section("content")
<div class="container-fluid login">
    <div class="container">
        <div class="login-area">
            @if(request()->get('error')=='captcha')
            <div class="alert alert-danger text-center">验证码不正确</div>
            @endif
            @if(request()->get('error')=='account')
            <div class="alert alert-danger text-center">账户或密码错误，请重试。</div>
            @endif
            @if(request()->get('error')=='freeze')
            <div class="alert alert-danger text-center">账号被冻结</div>
            @endif
            <h3 class="text-center">后台管理系统</h3>
            <form method="post" action="{{route("adminlogin")}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div class="form-group">
                    <label>账号</label>
                    <input name="username" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <input name="password" type="password" class="form-control" />
                </div>
                @if($captcha)
                <div class="row">
                    <div class="col-xs-7">
                        <div class="form-group">
                            <label>验证码</label>
                            <input name="captcha" class="form-control" type="text" />
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="form-group">
                            <a title="点击刷新验证码" href="javascript:;">
                                <img class="img-responsive" id="captcha-img" src="" />
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="checkbox">
                    <label><input name="remember" type="checkbox"><small>保持登录</small></label>
                </div>
                <button type="submit" class="btn btn-primary ">登录</button>
            </form>
        </div>
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
                username: {
                    validators: {
                        notEmpty: {
                            message: '账号不能为空'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '密码不能为空'
                        }
                    }
                },
                captcha:{
                    validators:{
                        notEmpty: {
                            message: '验证码不能为空'
                        }
                    }
                }
            }
        });
        $('#captcha-img').click(function(){
            var rand = Math.random();
            var src = "{{route('admincaptcha',['path'=>'adminlogin'])}}&"+rand;
            $('#captcha-img').attr('src', src);
        });
        $('#captcha-img').trigger('click');
        if(self.frameElement && self.frameElement.tagName == "IFRAME"){
            window.parent.location.href = '{{route("adminlogin")}}';
        }
    });
</script>
@endpush