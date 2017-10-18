<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="{{asset('backend/js/jquery.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/login.css')}}" />
<title>后台管理系统登录</title>
<script type="text/javascript" src="{{asset('backend/js/ani.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/backend.js')}}"></script>
</head>
<body>
<div class="frontHome page" id="loginbox">
	<div class="wrap-container">
		<div id="home_container" class="clearfix">
			<div id="home_main">
				<div class="inner-main">
					<div class="login_box">
						<div class="form-title">
							<h3>登录</h3>
							<h4>LOGIN</h4>
						</div>
						<form class="well form-horizontal" method="post" action="{{route("adminlogin")}}" style="background:#FFF">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
							<div class="logininput">
								<fieldset>
									<div id="div_id_username" class="clearfix control-group">
										<label for="username" class="control-label requiredField">帐号
										<span class="asteriskField">*</span>
										</label>
										<div class="controls">
											<input class="textinput textInput" id="username" maxlength="30" name="username" placeholder="用户名" type="text"/>
										</div>
									</div>
									<div id="div_id_password" class="clearfix control-group">
										<label for="password" class="control-label requiredField">密码
										<span class="asteriskField">*</span>
										</label>
										<div class="controls">
											<input class="textinput textInput" id="password" name="password" placeholder="密码" type="password"/>
										</div>
									</div>
                                    @if($captcha)
                                    <div id="div_id_captcha" class="clearfix control-group">
										<label for="password" class="control-label requiredField">验证码
										<span class="asteriskField">*</span>
										</label>
										<div class="controls">
                                            <input class="textinput textInput" id="captcha" name="captcha" placeholder="验证码" type="text"/>
										</div>
                                        <div class="captchaImage">
                                            <a title="点击刷新验证码" href="javascript:;">
                                                <img id="captcha-img" src="{{route("admincaptcha",['path'=>'adminlogin'])}}" />
                                            </a>
                                        </div>
									</div>
                                    @endif
									<div id="div_id_remember" class="clearfix control-group">
										<div class="controls">
											<label for="id_remember" class="checkbox ">
                                                <input style="vertical-align: middle;" class="checkboxinput" id="id_remember" name="remember" type="checkbox"/>保持登录
											</label>
										</div>
									</div>
								</fieldset>
							</div>
							<fieldset class="form-actions" style="position:relative; margin-top:15px;">
								<div class="lfAutoLogin">
									<div class="form-field form-field-rc">
										<label><a href="javascript:void(0)">忘记密码？</a></label>
									</div>
								</div>
								<div class="loginFormBtn clearfix">
									<button class="login_btn js_login_btn" type="submit" style="width:100%;">登录</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="container" class="mpage">
	<div id="anitOut" class="anitOut"></div>
</div>
<script type="text/javascript">
    $(window).resize(function(){
        resize();
    });
    $(document).ready(function(){
        resize();
        $('form').submit(function(){
            $('#username').vdsFieldChecker({rules: {required:[true, '请输入登录名']}, tipsPos:'abs'});
            $('#password').vdsFieldChecker({rules: {required:[true, '请输入密码']}, tipsPos:'abs'});
            if($('#captcha').size() > 0){
              $('#captcha').vdsFieldChecker({rules: {required:[true, '请输入验证码']}, tipsPos:'abs'});
            }
            return $('form').vdsFormChecker({
              beforeSubmit: function(){
                $(".login_btn").addClass('disabled').text('正在登录').prop('disabled', true);
              }
            });
        });
        $('#captcha-img').click(function(){
            var rand = Math.random();
            var src = "{{route('admincaptcha',['path'=>'adminlogin'])}}&"+rand;
            $('#captcha-img').attr('src', src);
        });
    });
    function resize(){
        var box_height = $('#home_container').height();
        var window_height = $(window).height();
        if(box_height<window_height){
            $('#home_container').css({paddingTop:Math.floor((window_height - box_height) / 3)+'px'});
        }else{
            $('#home_container').css({paddingTop:"0"});
        }
    }
</script>
</body>
</html>