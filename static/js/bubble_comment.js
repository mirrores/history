//发布记录
function post_my_bubble(){
    var text= document.getElementById('textarea_bubble');
    if(text.value=='分享新鲜事...'){
        text.value='';
    }

    var new_bubble=new ajaxForm('blow_form', {
        submitButton:'button_bubble',
        textSending:'正在发送',
        callback:function(){
            reload_my_bubble();
            showPrompt('分享新鲜事 积分+1',1500);
        }
    });
    new_bubble.send();
}

//重载我的最新记录
function reload_my_bubble(){
    var list = new Request({
        url: '/user_home/myBubble',
        method: 'get',
        onSuccess: function(data){
            document.getElementById('last_bubble_guest').innerHTML=data;
            document.getElementById('textarea_bubble').value='';
            document.getElementById('button_bubble').value='发送';
        }
    });
    list.send();
}

//记录评论js代码
function bubble_onfoucs(id){
    document.getElementById('b_textarea_'+id).style.height='40px';
    document.getElementById('b_button_'+id).style.display='';
}

function bubble_onblur(id){
    var obj=document.getElementById('b_textarea_'+id);
    if(obj.value==''){
        obj.style.height='15px';
        document.getElementById('b_button_'+id).style.display='none';
    }
}

function bubble_comment_post(id){
    var comment_bubble = new ajaxForm('bubble_form_'+id, {
        callback:function(){
            reload_bubble_comment(id);
        }
    });
    comment_bubble.send();
}
//重载
function reload_bubble_comment(id){
    var list = new Request({
        url: '/comment/bubbleList?id='+id+'&limit=5',
        method: 'get',
        onSuccess: function(data){
            document.getElementById('buttle_comments_'+id).innerHTML=data;
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