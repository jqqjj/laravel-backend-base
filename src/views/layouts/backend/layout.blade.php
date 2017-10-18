<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>@yield('title')</title>
<meta name="keywords" content="@yield('keyword')"/>
<meta name="description" content="@yield('description')"/>
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/backend.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/main.css')}}" />
@stack('css')
</head>
<body>
    @yield('content')
    <script type="text/javascript" src="{{asset('backend/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/backend.js')}}"></script>
    @stack('script')
    @stack('inline')
</body>
</html>
