<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>温馨提示</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/verydows.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript">
var countdown = 3;
$(function(){
  $('#countdown').text(countdown);
  window.setInterval(redirect, 1000); 
})  

function redirect(){
  if(countdown <= 0) {window.clearInterval(); return;}
  countdown --;
  $('#countdown').text(countdown);
  if (countdown == 0){
    window.location.href = $('a.link:first').attr('href');
  }
}
</script>
</head>
<body>
<div class="content">
  <div class="loc">
    <h2><i class="icon"></i>系统提示</h2>
  </div>
  <div class="box">
    <div class="prompt">
      <h3 class="{{$type}}">{{$msg}}</h3>
      <p class="c999 mt15">系统将在 <span id="countdown">3</span> 秒后自动跳转到系统指定页面</p>
      <p class="mt15"><a class="link" href="{{$url}}">{{$label}}</a></p>
      @foreach($links as $link)
      <p class="mt5"><a class="link" href="{{$link['url']}}">{{$link['label']}}</a></p>
      @endforeach
    </div>
  </div>
</div>
</body>
</html>