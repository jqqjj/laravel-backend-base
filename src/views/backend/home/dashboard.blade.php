@extends("layouts.backend.layout")
@section("title","后台中心")

@push('css')
@endpush

@push('script')
@endpush

@section("content")
<div class="container-fluid">
    <div class="data-header">
        <h4 class="data-title">系统信息</h4>
    </div>
    <!-- 系统信息开始 -->
    <div class="data">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <th width="20%">服务器操作系统</th>
                    <td width="30%">{{PHP_OS}}</td>
                    <th width="20%">服务器软件</th>
                    <td width="30%">{{Request::server("SERVER_SOFTWARE")}}</td>
                </tr>
                <tr>
                    <th>PHP 版本</th>
                    <td>{{PHP_VERSION}}</td>
                    <th>数据库版本</th>
                    <td>{{$db_version}}</td>
                </tr>
                <tr>
                    <th>文件上传最大限制</th>
                    <td>{{ini_get("post_max_size")}}</td>
                    <th>文件资源大小</th>
                    <td>{{$format_size}}</td>
                </tr>
                <tr>
                    <th width="13%">服务器 IP</th>
                    <td>{{Request::server("SERVER_ADDR")}}</td>
                    <th>默认时区设置</th>
                    <td>{{date_default_timezone_get()}}</td>
                </tr>
            </tbody>
        </table>
    </div>
<!-- 系统信息结束 -->
</div>
@endsection