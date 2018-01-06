$(document).ready(function(){
    $('[dobatch]').click(function(e){
        e.preventDefault();
        var message = $(this).attr('message') || "请确认操作?";
        var action = $(this).attr('href') || document.location.pathname;
        var key = $(this).attr('key') || 'id';
        var value = $(this).attr('value');
        var selector = $(this).attr("selector");
        var method = $(this).attr("method") && $(this).attr("method")==='post' ? 'post' : 'get';
        var data = typeof($(this).attr('data'))==='string' ? JSON.parse($(this).attr('data')) : {};
        
        var collection = [];
        
        //验证数据
        if(!action || typeof(action)!=='string' || action.length===0){
            return $.error("出错啦");
        }
        if(value && typeof(value)==="string"){
            collection = value.split(',');
        }else{
            $(selector).each(function(){
                if($(this).val()>0)
                    collection.push($(this).val());
            });
        }
        if(collection.length===0){
            return $.error("请选择需要操作的数据");
        }
        
        //处理需要发送的数据
        var send_data = {};
        send_data[key] = collection;
        for(var i in data){
            send_data[i] = data[i];
        }
        
        if($(this).attr('dobatch')==='confirm'){
            $.alert({
                title: '提示',
                content: message,
                buttons: {
                    confirm: {
                        text:'删除',
                        btnClass:'btn-danger',
                        keys:['y','enter'],
                        action:function(){
                            $.sendForm(action,method,send_data);
                        }
                    },
                    cancel: {
                        text:'取消',
                        btnClass:'btn-dark',
                        keys:['n']
                    }
                }
            });
        }else{
            $.sendForm(action,method,send_data);
        }
    });
    $('[do]').click(function(e){
        e.preventDefault();
        var message = $(this).attr('message') || "请确认操作?";
        var action = $(this).attr('href') || document.location.pathname;
        var key = $(this).attr('key') || 'id';
        var value = $(this).attr('value');
        var method = $(this).attr("method") && $(this).attr("method")==='post' ? 'post' : 'get';
        var data = typeof($(this).attr('data'))==='string' ? JSON.parse($(this).attr('data')) : {};
        
        //验证数据
        if(!action || typeof(action)!=='string' || action.length===0){
            return $.error("出错啦");
        }
        if(!value || typeof(value)!=='string' || value.length===0){
            return $.error("请选择需要操作的数据");
        }
        
        //处理需要发送的数据
        var send_data = {};
        send_data[key] = value;
        for(var i in data){
            send_data[i] = data[i];
        }
        
        if($(this).attr('do')==='confirm'){
            $.alert({
                title: '提示',
                content: message,
                buttons: {
                    confirm: {
                        text:'删除',
                        btnClass:'btn-danger',
                        keys:['y','enter'],
                        action:function(){
                            $.sendForm(action,method,send_data);
                        }
                    },
                    cancel: {
                        text:'取消',
                        btnClass:'btn-dark',
                        keys:['n']
                    }
                }
            });
        }else{
            $.sendForm(action,method,send_data);
        }
    });
    $('input.checkbox-control').each(function(){
        var children = $(this).attr('data-target');
        $(this).click(function(){
            if($(this).is(":checked")){
                $(this).prop('indeterminate',false);
                $(children).prop('checked',true);
            }else{
                $(this).prop('checked',false);
                $(children).prop('checked',false);
            }
        });
        var cal_status = function(master){
            if($(children+":checked").length>0 && $(children+":checked").length === $(children).length){
                $(master).prop('indeterminate',false);
                $(master).prop('checked',true);
            }
            else if($(children+":checked").length>0){
                $(master).prop('checked',false);
                $(master).prop('indeterminate',true);
            }else{
                $(master).prop('checked',false);
                $(master).prop('indeterminate',false);
            }
        };
        (function(master){
            $(children).click(function(){
                cal_status(master);
            });
        })(this);
        cal_status(this);
    });
    $('[data-toggle="popover"]').click(function(){
        $(this).toggleClass('active');
    }).popover({trigger:"hover click"});
});
$.error = function(msg){
    $.alert({
        title: '错误',
        content: '<font class="text-danger">'+msg+"</font>",
        buttons: {
            confirm: {
                text:'确定',
                btnClass:'btn-danger',
                keys:['enter','space']
            }
        }
    });
};
$.sendForm = function(action,method,data){
    var form = $('<form></form>');
    //表单属性
    form.attr('action', action);
    form.attr('method', method);
    if(method==='post'){
        form.append($('input[name="_token"]'));
    }
    var elements = $.createFormElement("",data);
    for(var i in elements){
        form.append($(elements[i]));
    }
    $('body').append(form);
    form.submit();
};
$.createFormElement = function(prefix,data){
    var elements = [];
    for(var i in data){
        if(typeof(data[i])==='object' || typeof(data[i])==='array'){
            var sub_elements = $.createFormElement(prefix && prefix.length>0 ? prefix+"["+i+"]" : i,data[i]);
            for(var j in sub_elements){
                elements.push(sub_elements[j]);
            }
        }else{
            if(prefix && prefix.length>0){
                elements.push('<input type="hidden" name="'+prefix+'['+i+']'+'" value="'+data[i]+'" />');
            }else{
                elements.push('<input type="hidden" name="'+i+'" value="'+data[i]+'" />');
            }
        }
    }
    return elements;
};
$.fn.subMenu = function(menu){
    var timer_id = 0,hideMenu,delayHideMenu,clearTimer,mouseEvent,clearMouseEvent;
    var btn = this;
    hideMenu = function(){
        clearTimer();
        clearMouseEvent();
        menu.removeClass('show').addClass('hide');
    };
    delayHideMenu = function(){
        clearTimer();
        timer_id = window.setTimeout(function(){
            hideMenu();
        },1000);
    };
    clearTimer = function(){
        if(timer_id>0){
            clearTimeout(timer_id);
            timer_id = 0;
        }
    };
    mouseEvent = function(){
      clearMouseEvent();
      delayHideMenu();
    };
    clearMouseEvent = function(){
        $(document).unbind('mousemove',mouseEvent);
    };

    $(this).click(function(){
        if(menu.hasClass('show')){
            hideMenu();
        }else{
            var postion = $.getPosition(btn,menu);
            menu.css({
              left: postion.left,
              top: postion.top
            }).removeClass('hide').addClass('show');
            $(document).mousemove(mouseEvent);
        }
    });
    menu.mouseleave(function(e){
        if(!$(this).is(":hidden")){
            delayHideMenu();
        }
    });
    menu.mouseenter(function(){
        clearTimer();
    });
    menu.addClass('vds-sub-menu').click(function(){
        hideMenu();
    });
};
$.getPosition = function(source,target){
    var left;var top;
    var scroll_offet_top = window.pageYOffset ||  document.documentElement.scrollTop;
    var scroll_offet_left = window.pageXOffset ||  document.documentElement.scrollLeft;
    if(source.offset().top - scroll_offet_top > target.outerHeight(true)){
        top = source.offset().top + source.outerHeight(true) / 2 - target.outerHeight(true);
    }else{
        top = source.offset().top + source.outerHeight(true) / 2;
    }
    if(source.offset().left - scroll_offet_left > target.outerWidth(true)){
        left = source.offset().left + source.outerWidth(true) / 2 - target.outerWidth(true);
    }else{
        left = source.offset().left + source.outerWidth(true) / 2;
    }
    return {left:left,top:top};
};