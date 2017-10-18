$(function(){
  $('.box table tr:even').addClass('even');
  $('.box table tr').vdsRowHover();
});

$(document).ready(function(){
    $('a[do]').click(function(e){
        e.preventDefault();
        var msg = $(this).attr('msg') || "确定操作?";
        var action = $(this).attr('href') || document.location.pathname;
        var primary = $(this).attr("primary") || 'id';
        var value = $(this).attr('value');
        var method = $(this).attr("method") || 'get';
        var data = typeof($(this).attr('data'))==='string' ? JSON.parse($(this).attr('data')) : {};
        
        var collection = [];
        if(value){
            collection = [value];
        }else{
            $("input[name='id']:checked").each(function(){
                if($(this).val()>0)
                    collection.push($(this).val());
            });
            if(collection.length===0){
                return $('body').vdsAlert({msg:'请在列表中选择一项'});
            }
        }
        if(collection.length>1){
            return $('body').vdsAlert({msg:'只能同时从列表中选择一项'});
        }
        
        if($(this).attr('do')==='confirm'){
            $(this).vdsConfirm({
                text: msg,
                confirmed: function(){
                    //创建Form
                    var form = $('<form></form>');
                    //表单属性
                    form.attr('action', action);
                    form.attr('method', method);
                    if(method==='post'){
                        form.append($('input[name="_token"]'));
                    }
                    form.append($('<input type="hidden" name="'+primary+'" value="'+collection[0]+'" />'));
                    //额外的数据
                    for(var i in data){
                        form.append($('<input type="hidden" name="'+i+'" value="'+data[i]+'" />'));
                    }
                    $('body').append(form);
                    form.submit();
                }
            });
        }else{
            //创建Form
            var form = $('<form></form>');
            //表单属性
            form.attr('action', action);
            form.attr('method', method);
            if(method==='post'){
                form.append($('input[name="_token"]'));
            }
            form.append($('<input type="hidden" name="'+primary+'" value="'+collection[0]+'" />'));
            //额外的数据
            for(var i in data){
                form.append($('<input type="hidden" name="'+i+'" value="'+data[i]+'" />'));
            }
            $('body').append(form);
            form.submit();
        }
    });
    $('a[dobatch]').click(function(e){
        e.preventDefault();
        var msg = $(this).attr('msg') || "确定操作?";
        var action = $(this).attr('href') || document.location.pathname;
        var primary = $(this).attr("primary") || 'id';
        var value = $(this).attr('value');
        var method = $(this).attr("method") || 'get';
        var data = typeof($(this).attr('data'))==='string' ? JSON.parse($(this).attr('data')) : {};
        
        var collection = [];
        if(value){
            collection = value.split(',');
        }else{
            $("input[name='id']:checked").each(function(){
                if($(this).val()>0)
                    collection.push($(this).val());
            });
        }
        if(collection.length===0){
            return $('body').vdsAlert({msg:'请在列表中选择至少一项'});
        }
        
        if($(this).attr('dobatch')==='confirm'){
            $(this).vdsConfirm({
                text: msg,
                confirmed: function(){
                    //创建Form
                    var form = $('<form></form>');
                    //表单属性
                    form.attr('action', action);
                    form.attr('method', method);
                    if(method==='post'){
                        form.append($('input[name="_token"]'));
                    }
                    for(var i=0;i<collection.length;i++){
                        form.append($('<input type="hidden" name="'+primary+'[]" value="'+collection[i]+'" />'));
                    }
                    //额外的数据
                    for(var i in data){
                        form.append($('<input type="hidden" name="'+i+'" value="'+data[i]+'" />'));
                    }
                    $('body').append(form);
                    form.submit();
                }
            });
        }else{
            //创建Form
            var form = $('<form></form>');
            //表单属性
            form.attr('action', action);
            form.attr('method', method);
            if(method==='post'){
                form.append($('input[name="_token"]'));
            }
            for(var i=0;i<collection.length;i++){
                form.append($('<input type="hidden" name="'+primary+'[]" value="'+collection[i]+'" />'));
            }
            //额外的数据
            for(var i in data){
                form.append($('<input type="hidden" name="'+i+'" value="'+data[i]+'" />'));
            }
            $('body').append(form);
            form.submit();
        }
    });
});