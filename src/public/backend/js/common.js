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
                        text:'确定',
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
                        text:'确定',
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
                $(children).prop('checked',true).trigger('change');
            }else{
                $(this).prop('checked',false);
                $(children).prop('checked',false).trigger('change');
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
});
$.checkIDNo = function(idcode){
    // 加权因子
    var weight_factor = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];
    // 校验码
    var check_code = ['1', '0', 'X' , '9', '8', '7', '6', '5', '4', '3', '2'];

    var code = idcode + "";
    var last = idcode[17];//最后一个

    var seventeen = code.substring(0,17);

    // ISO 7064:1983.MOD 11-2
    // 判断最后一位校验码是否正确
    var arr = seventeen.split("");
    var len = arr.length;
    var num = 0;
    for(var i = 0; i < len; i++){
        num = num + arr[i] * weight_factor[i];
    }

    // 获取余数
    var resisue = num%11;
    var last_no = check_code[resisue];

    // 格式的正则
    // 正则思路
    /*
    第一位不可能是0
    第二位到第六位可以是0-9
    第七位到第十位是年份，所以七八位为19或者20
    十一位和十二位是月份，这两位是01-12之间的数值
    十三位和十四位是日期，是从01-31之间的数值
    十五，十六，十七都是数字0-9
    十八位可能是数字0-9，也可能是X
    */
    var idcard_patter = /^[1-9][0-9]{5}([1][9][0-9]{2}|[2][0][0|1][0-9])([0][1-9]|[1][0|1|2])([0][1-9]|[1|2][0-9]|[3][0|1])[0-9]{3}([0-9]|[X])$/;

    // 判断格式是否正确
    var format = idcard_patter.test(idcode);

    // 返回验证结果，校验码和格式同时正确才算是合法的身份证号码
    return last === last_no && format ? true : false;
};
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