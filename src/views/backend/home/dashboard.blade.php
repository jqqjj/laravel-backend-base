<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="verydows-baseurl" content="http://verydows.me">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>面板</title>
<link rel="stylesheet" type="text/css" href="{{asset('css/verydows.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/dashboard.css')}}" />
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('js/verydows.js')}}"></script>
</head>
<body>
<div class="content">
  <div class="loc"><h2><i class="dashboard icon"></i>面板首页</h2></div>
  <div class="box">
    <div class="notice" id="notice"></div>
    <!-- 数据统计开始 -->
    <div class="module cut">
      <div class="divid">
        <div class="bw-row mr5 pad5">
          <h3 class="th ta-c">数据统计</h3>
          <div class="module mt5 cut" id="totals-tbl">   <table class="stbl">     <tbody><tr><th width="100">订单总数</th><td><b>0</b>个</td></tr>     <tr><th>总营收额</th><td><b>0.00</b>元</td></tr>     <tr><th>注册用户</th><td><b>1</b>个</td></tr>     <tr><th>商品总数</th><td><b>1</b>个</td></tr>     <tr><th>广告总数</th><td><b>1</b>条</td></tr>     <tr><th>资讯总数</th><td><b>0</b>条</td></tr>   </tbody></table> </div>
        </div>
      </div>
      <div class="divid">
        <div class="bw-row mr5 pad5">
          <h3 class="th ta-c">今日新增</h3>
          <div class="module mt5 cut" id="today-tbl">   <table class="stbl">     <tbody><tr><th width="100">订单数量</th><td><b>0</b>个</td></tr>     <tr><th>今日营收</th><td><b>0.00</b>元</td></tr>     <tr><th>新注册用户</th><td><b>0</b>个</td></tr>     <tr><th>售后申请</th><td><b>0</b>个</td></tr>     <tr><th>咨询反馈</th><td><b>0</b>条</td></tr>     <tr><th>今日浏览量</th><td><b>1</b>次</td></tr>   </tbody></table> </div>
        </div>
      </div>
      <div class="divid">
        <div class="bw-row mr5 pad5">
          <h3 class="th ta-c">待处理事项</h3>
          <div class="module mt5" id="pending-tbl">   <table class="stbl">     <tbody><tr><th width="100">待发货订单</th><td><b>0</b>个</td></tr>     <tr><th>待处理售后</th><td><b>0</b>个</td></tr>     <tr><th>待审核评价</th><td><b>0</b>条</td></tr>     <tr><th>待回复反馈</th><td><b>0</b>个</td></tr>     <tr><th>到期广告</th><td><b>1</b>条</td></tr>     <tr><th>待确认订阅</th><td><b>0</b>个</td></tr>   </tbody></table> </div>
        </div>
      </div>
      <div class="divid">
        <div class="bw-row pad5">
          <h3 class="th ta-c">在线后台用户</h3>
          <div class="actives module">
            <table class="stbl">
              <tbody><tr class="thd">
                <th width="50%">登录名称 / 姓名</th>
                <th class="ta-r">登录时间</th>
              </tr>
              <tr>
                <th>admin<font class="caaa">[未设置]</font></th>
                <td>2017-07-28 08:25:15</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- 数据统计结束 -->
    <!-- 系统信息开始 -->
    <div class="bw-row mt5 pad10 cut">
      <h3 class="th ta-c">系统信息</h3>
      <div class="module cut" id="sysinfo-tbl">
          <table class="dataform">
              <tbody>
                  <tr>
                      <th width="13%">服务器操作系统</th>
                      <td width="33%">{{PHP_OS}}</td>
                      <th width="13%">服务器软件</th>
                      <td width="33%">{{Request::server("SERVER_SOFTWARE")}}</td>
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
    </div>
    <!-- 系统信息结束 -->
  </div>
</div>

</body>