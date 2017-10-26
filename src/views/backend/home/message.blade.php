@extends("layouts.backend.layout")
@section("title","系统提示")
@push('css')
@endpush

@push('script')
@endpush

@section("content")
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
@endsection

@push("inline")
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
      var href = $('a.link:first').attr('href');
      if(href){
          window.location.href = $('a.link:first').attr('href');
      }else{
          window.history.back();
      }
  }
}
</script>
@endpush