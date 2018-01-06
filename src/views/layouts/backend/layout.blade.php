<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keyword')"/>
    <meta name="description" content="@yield('description')"/>
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('jquery-confirm/jquery-confirm.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/common.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('iconfont/iconfont.css')}}" />
    @stack('css')
  </head>
<body>
    @yield('content')
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jquery-confirm/jquery-confirm.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/common.js')}}"></script>
    @stack('script')
    @stack('inline')
</body>
</html>
