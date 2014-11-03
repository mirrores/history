//发布记录(个人主页首页)
function post_newthing_home(){
    var text= $('#textarea_newthing');
    if(text.val()=='分享新鲜事...'){
        text.val('');
    }
    new ajaxForm('newthing_form', {
        submitButton:'button_newthing',
        textSending:'正在发送',
        callback:function(){
            reload_newthing();
            showPrompt('分享新鲜事 积分+1',1500);
        }
    }).send();
}

//发布记录
function post_newthing(){
    var text= $('#textarea_newthing');
    if(text.val()=='分享新鲜事...'){
        text.val(null);
    }
    new ajaxForm('newthing_form', {
        submitButton:'button_newthing',
        textSending:'正在发送',
        callback:function(){
            showPrompt('分享新鲜事 积分+1',1500);
            setTimeout(function(){
               window.location.href=window.location.href;
            },1000)
        }
    }).send();
}

//重载我的最新记录
function reload_newthing(){
    var list = new Request({
        url: '/user_home/myBubble',
        method: 'get',
        onSuccess: function(data){
            $('#last_newthing_guest').html(data);
            $('#textarea_newthing').val();
            $('#button_newthing').val('发布');
        }
    });
    list.send();
}

//记录评论js代码
function newthing_onfoucs(id){
    document.getElementById('b_textarea_'+id).style.height='40px';
    document.getElementById('b_button_'+id).style.display='';
}

function newthing_onblur(id){
    var obj=document.getElementById('b_textarea_'+id);
    if(obj.value==''){
        obj.style.height='15px';
        document.getElementById('b_button_'+id).style.display='none';
    }
}

function newthing_comment_post(id){
    var comment_newthing = new ajaxForm('newthing_form_'+id, {
        callback:function(){
            reload_newthing_comment(id);
        }
    });
    comment_newthing.send();
}
//重载
function reload_newthing_comment(id){
    var list = new Request({
        url: '/comment/newthingList?id='+id+'&limit=5',
        method: 'get',
        onSuccess: function(data){
            document.getElementById('newthing_comments_'+id).innerHTML=data;
            document.getElementById('b_textarea_'+id).value='';
            document.getElementById('b_textarea_'+id).style.height='15px';
            document.getElementById('b_button_'+id).style.display='none';
        }
    });
    list.send();
}

//统计字数
function countChar(textobj,spanName)
{
    var obj=document.getElementById(textobj);
    var obj_count=obj.value.length;
    if(obj_count<=140){
        document.getElementById(spanName).innerHTML=140-obj_count;
    }
    else{
        obj.value = obj.value.substring(0,140);
    }
}