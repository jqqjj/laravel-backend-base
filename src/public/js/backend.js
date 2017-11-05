//格式化Unix时间戳
function formatTimestamp(time, format) {
  var d = new Date(parseInt(time) * 1000), month = d.getMonth() + 1, day = d.getDate(), hour = d.getHours(), minute = d.getMinutes(), second = d.getSeconds();
  format = format.replace(/y/, d.getFullYear());
  if(month < 10) month = '0' + month;
  format = format.replace(/m/, month);
  if(day < 10) day = '0' + day;
  format = format.replace(/d/, day);
  if(hour < 10) hour = '0' + hour;
  format = format.replace(/h/, hour);
  if(minute < 10) minute = '0' + minute;
  format = format.replace(/i/, minute);
  if(second < 10) second = '0' + second;
  format = format.replace(/s/, second);
  return format;
}

(function($){
    $.fn.isPlaceholderSupport = function(){  
        return 'placeholder' in document.createElement('input');  
    };
  //字段验证
  $.fn.vdsFieldChecker = function(options){
    var defaults = {
      rules: {},
      tipsPos: '',
    }, opts = $.extend(defaults, options);
    
    var field = this, val = this.val() || '';
    
    var inRules = function(rule, right){
      switch(rule){
        case 'required': return right === (val.length > 0); break;
        case 'minlen': return right <= val.length; break;
        case 'maxlen': return right >= val.length; break;
        case 'email': return right === /.+@.+\.[a-zA-Z]{2,4}$/.test(val); break;
        case 'password': return right === /^$|^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{6,31}$/.test(val); break;
        case 'equal': return right == val; break;
        case 'nonegint': return right === /^$|^(0|\+?[1-9][0-9]*)$/.test(val); break;
        case 'decimal': return right === /^$|^(0|[1-9][0-9]{0,9})(\.[0-9]{1,2})?$/.test(val); break;
        case 'mobile': return right === /^$|^1[3|4|5|7|8]\d{9}$/.test(val); break;
        case 'zip': return right === /^$|^[0-9]{6}$/.test(val); break;
        case 'seq': return right === /^$|^([1-9]\d|\d)$/.test(val); break;
        default: if(typeof(right) == 'boolean') return right; alert('Validation Rule "'+rule+'" is incorrect!');
      }
    };
    
    var tips = $("<span class='vdsfielderr'></span>").css({
          display: 'inline-block',
          'margin-left': '5px',
          'line-height': '12px',
          border: '1px solid #ff3366',
          'border-radius': '3px',
          background: '#ffdfdf',
        });

    if(opts.tipsPos == 'abs'){
      tips.css({
        'margin-left': 0,
        position: 'absolute',
        left: field.offset().left + field.outerWidth() + 5,
        top: field.offset().top,
        'z-index': 999,
      });
    }else if(opts.tipsPos == 'br'){
      tips.css({display:'table', margin:'8px 0 0 0', 'border-collapse':'separate'});
    }else if(opts.tipsPos == 'cr'){
      tips.css({display:'table', margin:'8px auto 0 auto', 'border-collapse':'separate'});
    }
			
    field.next('span.vdsfielderr').remove();

    var res = null;
    $.each(opts.rules, function(k, v){
      if(!inRules(k, v[0])){
        var font = $("<font></font>").css({display:'block', color:'#911', 'font-size':'12px', padding:'6px 10px'});
        font.text(v[1]).appendTo(tips);
        field.after(tips);
        res = v[1];
        return false;
      }
    });
    return res;
  };
  //表单验证
  $.fn.vdsFormChecker = function(options){
    var defaults = {
      beforeSubmit: function(){},
    }, opts = $.extend(defaults, options);
    
    var form = this;
    
    if(form.find('span.vdsfielderr').size() === 0){
        if($.isFunction(opts.beforeSubmit)){
          opts.beforeSubmit.apply(this, arguments);
        }
        return true;
    }
    return false;
  };
  //loading条窗口
  $.vdsLoadingBar = function(sw){
    if(sw){
      var loading = $('<div id="vdsloadingbar" class="loading absol"></div>');
      loading.css({'box-shadow':'0 0 8px #888'});
      loading.appendTo($('body'));
      $('div#vdsloadingbar').vdsHorizontal().vdsVertical();
      $.vdsMasker(true);
    }else{
      $('div#vdsloadingbar').remove();
      $.vdsMasker(false);
    }
  };
  //窗口加载
  $.vdsLoadingWindow = function(options){
      var defaults = {    
        label: "",
        url: "",
        width:800,
        height:480,
        ok:function(){},
        btn:"确定",
        cancel:function(){},
        autoClose:false,
      }, opts = $.extend(defaults, options);
      $.vdsMasker(true);
      $('#vdsloadingwindow').remove();
      var window = $('<div id="vdsloadingwindow" class="pop-media"><h2 class="c999 vds-label">'+opts.label+'</h2><a class="close">×</a><div class="module vds-content"></div></div>');
      $('body').append(window);
      $('#vdsloadingwindow .vds-content').css({
          width:opts.width+'px',
          height:opts.height+'px'
      });
      $('#vdsloadingwindow div.vds-content').addClass('loading').html('<iframe src="'+opts.url+'" frameborder="0" scrolling="no" width="100%"></iframe>');
      $("#vdsloadingwindow").vdsHorizontal().vdsVertical().show();
      $('#vdsloadingwindow .close').off('click').click(function(){
          opts.cancel();
          $('#vdsloadingwindow').remove();
          $.vdsMasker(false);
      });
      $('#vdsloadingwindow iframe').load(function(){
          $('#vdsloadingwindow div.vds-content').removeClass('loading')
      });
  };
  //遮罩层
  $.vdsMasker = function(sw){
    if(sw){
      var masker = $('<div id="vdsmasker" class="masker fullscreen"></div>');
      $('body').append(masker);
      masker.vdsFullScreen();
    }else{
      $('div#vdsmasker').remove();
    }
  };
  //提示窗口
  $.fn.vdsAlert = function(options){
    var defaults = {    
      msg: null,
      time: 3,
    }, opts = $.extend(defaults, options);
		
    opts.time = opts.time * 1000;
		
    //this.remove('#vds-alert');
    $('#vds-alert').remove();
    $("<div id='vds-alert'></div>").html(opts.msg).appendTo(this).css({
      position: 'fixed',
      width: 300,
      'text-align': 'center',
      top: 80,
      left: ($(window).width() - 300) / 2,
      color: '#CC3300',
      'font-size': '14px',
      padding: '30px 20px',
      'line-height': '150%',
      border: '3px solid #ffcc33',
      background: '#fff',
      'box-shadow': '2px 2px 2px #ccc',
      'z-index': 9999
    }).delay(opts.time).fadeOut(1000);
  };
  //确认窗口
  $.fn.vdsConfirm = function(options){
    var defaults = {text: '', left: 0, top: 0, confirmed: function(){}}, opts = $.extend(defaults, options), btn = this, obj;

    if($('#vds-confirm').size() == 0){
      var html = "<p class='pad5'>"+opts.text+"</p><div class='mt10' style='min-width:122px;'><button type='button' class='ubtn sm btn'>确定</button><span class='sep10'></span><button type='button' class='fbtn sm btn'>取消</button></div>";
      obj = $('<div></div>', {'class':'vds-confirm cut', 'id':'vds-confirm'}).html(html).appendTo($('body'));
    }
    else{
      obj = $('#vds-confirm');
      obj.find('p').html(opts.text);
    }
    
    var left;var top;
    var scroll_offet_top = window.pageYOffset ||  document.documentElement.scrollTop;
    var scroll_offet_left = window.pageXOffset ||  document.documentElement.scrollLeft;
    if(btn.offset().top - scroll_offet_top > obj.outerHeight(true)){
        top = btn.offset().top + btn.outerHeight(true) / 2 - obj.outerHeight(true);
    }else{
        top = btn.offset().top + btn.outerHeight(true) / 2;
    }
    if(btn.offset().left - scroll_offet_left > obj.outerWidth(true)){
        left = btn.offset().left + btn.outerWidth(true) / 2 - obj.outerWidth(true);
    }else{
        left = btn.offset().left + btn.outerWidth(true) / 2;
    }
    
    obj.show().css({ 
      left: left,
      top: top
    }).find('button').unbind('click').on('click', function(){
      if($(this).index() == 0) opts.confirmed();
      obj.hide();
    });
  };
	
  //行变换class
  $.fn.vdsRowHover = function(cls){
    cls = cls || 'hover';
    this.hover(function(){$(this).addClass(cls);}, function(){$(this).removeClass(cls);}); 
  };
  //选项卡切换
  $.fn.vdsTabsSwitch = function(options){
    var defaults = {sw: 'li', maps: '.swcon'}, opts = $.extend(defaults, options);
    this.find(opts.sw).click(function(){
      var i = $(this).index();
      $(this).addClass('cur').siblings().removeClass('cur');
      $(opts.maps).hide().eq(i).show();
    });
  };
  $.fn.vdsFullScreen = function(){
      if(!$(this).hasClass('vds-full-screen')){
        $(this).addClass('vds-full-screen');
      }
      $(this).css({
          width:Math.max($(window).width(),$("body").width())+"px",
          height:Math.max($(window).height(),$("body").height())+"px",
      });
      return this;
  };
  $.fn.vdsVertical = function(){
      if(!$(this).hasClass('vds-vertical-box')){
        $(this).addClass('vds-vertical-box');
      }
      var window_height = $(window).height();
      var box_height = $(this).height();
      if($(this).css("position")==='absolute' || $(this).css("position")==='relative' || $(this).css("position")==='fixed'){
        if(box_height<window_height){
          $(this).css({top:Math.floor((window_height - box_height) / 3)+'px'});
        }else{
          $(this).css({top:"0"});
        }
      }else{
        if(box_height<window_height){
          $(this).css({marginTop:Math.floor((window_height - box_height) / 3)+'px'});
        }else{
          $(this).css({marginTop:"0"});
        }
      }
      return this;
  };
  $.fn.vdsHorizontal = function(){
      if(!$(this).hasClass('vds-horizontal-box')){
        $(this).addClass('vds-horizontal-box');
      }
      var window_width = $(window).width();
      var box_width = $(this).width();
      if($(this).css("position")==='absolute' || $(this).css("position")==='relative' || $(this).css("position")==='fixed'){
        if(box_width<window_width){
          $(this).css({left:Math.floor((window_width - box_width) / 2)+'px'});
        }else{
          $(this).css({left:"0"});
        }
      }else{
        if(box_width<window_width){
          $(this).css({marginLeft:Math.floor((window_width - box_width) / 2)+'px'});
        }else{
          $(this).css({marginLeft:"0"});
        }
      }
      return this;
  };
  $(window).resize(function(){
      $('.vds-full-screen').each(function(){
          $(this).vdsFullScreen();
      });
      $('.vds-vertical-box').each(function(){
          $(this).vdsVertical();
      });
      $('.vds-horizontal-box').each(function(){
          $(this).vdsHorizontal();
      });
  });
  if(!$(document).isPlaceholderSupport()){
    jQuery('[placeholder]').focus(function() {
      var input = jQuery(this);
      if (input.val() == input.attr('placeholder') && input.attr('type')==="text") {
        input.val('');
        input.removeClass('placeholder');
      }
    }).blur(function() {
      var input = jQuery(this);
      if ((input.val() == '' || input.val() == input.attr('placeholder')) && input.attr('type')==="text") {
        input.addClass('placeholder');
        input.val(input.attr('placeholder'));
      }
    }).blur().parents('form').submit(function() {
      jQuery(this).find('[placeholder]').each(function() {
        var input = jQuery(this);
        if (input.val() == input.attr('placeholder') && input.attr('type')==="text") {
          input.val('');
        }
      })
    });
  }
})(jQuery);