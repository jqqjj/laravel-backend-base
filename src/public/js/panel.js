$(function(){
    $('#nav li').click(function(){
      $('#nav li.on').removeClass('on');
      $(this).addClass('on');
    });
    $('#nav h3').click(function(){
      if($(this).hasClass('on')) $(this).removeClass('on').next('ul').slideUp(); else $(this).addClass('on').next('ul').slideDown();
    });
    resize();
    window.onresize = resize;
});

function resize()
{
    var ph = $('body').height() - $('#header').outerHeight() - $('#footer').outerHeight() - 10;
    $('#nav').height(ph);
    $('#main').height(ph);
    $('#gap').height(ph);
}

function closeUser(){
  $.vdsMasker(false);
  $('#pop-user').hide();
  $('#pwd').hide();
  $('#pop-user div.ta-c button').eq(0).hide();
  $('#pop-user div.ta-c button').eq(1).show();
}

function resetPwd(){
  $('#pwd').slideDown(200);
  $('#pop-user div.ta-c button').eq(0).show();
  $('#pop-user div.ta-c button').eq(1).hide();
}

function popAc(id){
  $.vdsMasker(true);
  $('#'+id).show().vdsVertical().vdsHorizontal();
}

function closeAc(id){
  $.vdsMasker(false);
  $('#'+id).hide();
}

function checkAllClean(){
  var allBtn = $('#clean-select li:first input');
  if(allBtn.prop('checked')){
    $('#clean-select').find('input[type="checkbox"]').prop('checked', true);
  }else{
    $('#clean-select').find('input[type="checkbox"]').prop('checked', false);
  }
}