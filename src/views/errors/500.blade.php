<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500</title>
    <link rel="stylesheet" href="{{asset("bootstrap/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/animate.min.css")}}">
    <style>
        .middle-box{margin-top: 100px;}
        .btn{margin-top: 30px;}
    </style>
</head>
<body>
<div class="middle-box text-center animated fadeInDown" >
    <h1 style="font-size: 100px;">500</h1>
    <h3>抱歉，服务器开了小差！</h3>
    <div>工程师正在努力抢救页面中</div>
    <a href="/" class="btn btn-success btn-sm">返回首页</a>
    @if(0)
    <pre class="text-left" style="display: none;">
{{$error}}
{{$trace}}
    </pre>
    @endif
</div>

<script type="text/javascript" src="{{asset("js/jquery.min.js")}}"></script>
<script type="text/javascript" src="{{asset("bootstrap/js/bootstrap.min.js")}}"></script>
</body>
</html>