//全局ajax获取评论参数
var getCommentJson = null;
//登录后调整换页面
var login_redirect = '/user/home';
//页面加载结束后执行的脚本
var readyScript = {};
//判断变量是否定义
function is_defined(obj) {
    if ((typeof obj) != 'undefined' && obj != false) {
        return true;
    } else {
        return false;
    }
}

//获取浏览器及版本信息
function getBrowser() {
    var browser = {
        msie: false, firefox: false, opera: false, safari: false,
        chrome: false, netscape: false, appname: 'unknown', version: 0
    },
    userAgent = window.navigator.userAgent.toLowerCase();
    if (/(msie|firefox|opera|chrome|netscape)\D+(\d[\d.]*)/.test(userAgent)) {
        browser[RegExp.$1] = true;
        browser.appname = RegExp.$1;
        browser.version = RegExp.$2;
    } else if (/version\D+(\d[\d.]*).*safari/.test(userAgent)) { // safari
        browser.safari = true;
        browser.appname = 'safari';
        browser.version = RegExp.$2;
    }
    return {name: browser.appname, version: browser.version};
}

//jquery 异步请求
//setting:http://api.jquery.com/jQuery.ajax/
//dataType
//callback Function Queues:beforeSend, error, dataFilter, success and complete
var Request = function(opts) {
    this.opts = $.extend({}, opts);
};
Request.prototype.send = function() {
    $.ajax(this.opts);
};


//ajaxForm表单提交
var ajaxForm = function(form_id, opts) {

    if (!is_defined(form_id)) {
        alert('未指定表单id');
        return false;
    }
    ;
    this.form = $('#' + form_id);
    if (this.form.length < 0) {
        alert('未找到' + form_id + '表单对象！');
        return false;
    }
    ;
    //默认值
    var def = {
        formid: form_id,
        action: false,
        method: 'post',
        data_type: 'html',
        timeout: 10000,
        url: false,
        clearForm: false,
        errorDisplayType: 'formError',
        loading: false,
        btn: false,
        redirect: false,
        callback: false,
        before: false,
        error: false,
        statusTools: false,
        submitButton: 'submit_button',
        textSuccess: '成功发送',
        textSending: '发送中',
        textError: '重试'
    };
    //继承参数
    this.opts = $.extend({}, def, opts);
};
//ajaxSubmit提交前执行
ajaxForm.prototype.before = function() {

    //提交前先执行用户定义的方法
    if (typeof this.opts.before == 'function') {
        this.opts.before();
    }

    if (!this.opts.url) {
        this.opts.url = this.form.attr('action');
    }

    //优先在当前表单寻找提交按钮
    this.opts.btn = this.form.find('#' + this.opts.submitButton);
    if (!this.opts.btn.length) {
        this.opts.btn = $("#aui_buttons").find(".aui_state_highlight");
    }
    if (!this.opts.btn.length) {
        this.opts.btn = $("#" + this.opts.submitButton);
    }

    //状态提示框
    this.opts.statusTools = $('#' + this.opts.formid + 'statusTools');
    if (this.opts.statusTools.length == 0) {
        this.form.after('<div id="' + this.opts.formid + 'statusTools" style="clear:both;margin:5px;padding:5px;"><img src="/static/images/loading.gif"></div>');
        this.opts.statusTools = $('#' + this.opts.formid + 'statusTools');
    }
    else {
        this.opts.statusTools.removeClass('candy_form_err');
        this.opts.statusTools.html('<img src="/static/images/loading.gif">');
        this.opts.statusTools.fadeIn(200);
    }

    //让提交按钮暂时不可用，并显示发送状态
    if (this.opts.btn.get(0).tagName == 'INPUT') {
        this.opts.btn.attr('disabled', true);
        this.opts.btn.attr('value', this.opts.textSending);
    } else {
        this.opts.btn.attr('disabled', true);
        this.opts.btn.html(this.opts.textSending);
    }
};
//ajax提交表单
ajaxForm.prototype.send = function() {
    this.before();
    this.opts.success = function(data) {
        var is_keerect = false;
        var errorString = false;
        //返沪json格式
        if (this.data_type == 'json') {
            if (data.status == 1) {
                is_keerect = true;
            }
            else {
                errorString = data.error;
            }
        }
        //返回html格式
        else if (this.data_type == 'html') {
            if (data.indexOf("err#") >= 0) {
                errorString = data.replace("err#", "");
            }
            else {
                is_keerect = true;
            }
        }
        //返回内容为空
        else {
            is_keerect = true;
        }

        //返回正确内容-----------------------------------------------------
        if (is_keerect) {
            //重置按钮
            if (this.btn.get(0).tagName == 'INPUT') {
                this.btn.attr('value', this.textSuccess);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.html(this.textSuccess);
            }
            else {
            }
            //移除消息框
            this.statusTools.html('');
            //成功后调整到某一个页面
            if (this.redirect) {
                window.location.href = this.redirect;
                return false;
            }
            //用户自定义成功后方法
            if (typeof this.callback == 'function') {
                this.callback(data);
            }
        }
        //返回错误信息---------------------------------
        else {
            if (this.btn.get(0).tagName == 'INPUT') {
                this.btn.attr('disabled', false);
                this.btn.attr('value', this.textError);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.attr('disabled', false);
                this.btn.html(this.textError);
            }
            else {
            }

            //在表单底部提示错误
            if (this.errorDisplayType == 'formError') {
                this.statusTools.addClass('candy_form_err');
                this.statusTools.html(errorString);
                this.statusTools.hide();
                this.statusTools.fadeIn(400);
                var statusTools = this.statusTools;
                setTimeout(function() {
                    statusTools.fadeOut(400);
                }, 3000);
            }
            //系统弹出窗口
            else if (this.errorDisplayType == 'alert') {
                this.statusTools.html('');
                alert(errorString);
            }
            //facebox弹出窗
            else if (this.errorDisplayType == 'dialogbox') {
                this.statusTools.html('');
                errorAlert(errorString);
            }
            else {
            }
        }

        //重新激活重试提交
        this.btn.attr('disabled', false);
    };
    //请求错误信息
    this.opts.error = function(xhr) {

        if (xhr.readyState == 4 && xhr.status == 0) {
            this.statusTools.html('很抱歉，请求超时，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 200) {
            this.statusTools.html('程序出错，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 404) {
            this.statusTools.html('很抱歉，请求文件不存在!');
        }
        else if (xhr.readyState == 4 && xhr.status == 500) {
            this.statusTools.html('很抱歉，服务器遇到了意料不到的情况，请与管理员联系！');
        }
        else if (xhr.readyState == 0 && xhr.status == 0 && xhr.statusText == 'timeout') {
            this.statusTools.html('很抱歉，内容发送超时，请刷新浏览器或稍后重试！');
        }
        else {
            this.statusTools.html('很抱歉，数据发送失败，可能是程序有问题，请重试或与管理员联系！');
        }
        this.opts.btn.attr('disabled', false);
        this.btn.attr('value', this.textError);
    };
    this.opts.dataType = this.opts.data_type;
    this.form.ajaxSubmit(this.opts);
    return false;
};


//Facebox对话框
function Facebox(json) {

    var self = this;
    //待返回的dialogbox对象
    this.obj = null;
    //窗口对象
    this.cancel = json.cancel ? json.cancel : true;
    this.cancel = this.cancel == 'hidden' ? null : this.cancel;
    //打开artdialog窗口
    this.show = function() {

        //初始化窗口
        this.obj = art.dialog({
            id: json.id ? json.id : 'my_dialogbox',
            padding: json.padding ? json.padding : '10px',
            title: json.title ? json.title : '消息提示',
            top: json.top ? json.top : '40%',
            left: json.left ? json.left : '45%',
            icon: json.icon ? json.icon : false,
            width: json.width ? json.width : '320px',
            height: json.height ? json.height : '70px',
            minWidth: json.minWidth ? json.minWidth : null,
            minHeight: json.minHeight ? json.minHeight : null,
            button: json.button ? json.button : null,
            lock: json.lock ? json.lock : false,
            follow: json.follow ? json.follow : null,
            ok: json.ok ? json.ok : null,
            okVal: json.okVal ? json.okVal : '确定',
            cancel: self.cancel,
            cancelVal: json.cancelVal ? json.cancelVal : '取消',
            time: json.time ? json.time : null,
            content: '<img src="/static/images/user/loading6.gif">'
        });
        //初始化内容
        if (json.message) {
            this.obj.content(json.message);
        }

        //加载网页视图
        else if (json.url) {
            new Request({
                url: json.url,
                success: function(data) {
                    self.obj.content(data);
                }
            }).send();
        }
        else {
            this.obj.content('您想做什么呢？');
        }

        //返回窗口对象，以便其他对象操作artdialog窗口
        return this.obj;
    };
    this.close = function() {
    };
}


//成功提示框
function okAlert(message) {
    new Facebox({
        id: 'okFacebox',
        title: '操作提示',
        icon: 'succeed',
        cancel: 'hidden',
        cancelVal: '关闭',
        message: message,
        time: 5
    }).show();
}

//警告提示框
function faceboxAlert(opts) {
    new Facebox($.extend({}, {
        id: 'faceboxAlert',
        title: '温馨提示',
        icon: 'succeed',
        cancelVal: '关闭',
        message: '',
        time: 5
    }, opts)).show();
}

//成功提示框
function errorAlert(message) {
    new Facebox({
        id: 'errorFacebox',
        title: '操作提示',
        icon: 'error',
        cancelVal: '关闭',
        message: message
    }).show();
}

//发送站内信
function sendMsg(uid, reply_id) {
    var reply = reply_id || null;
    var sendmsg_facebox = new Facebox({
        title: '短消息',
        icon: 'mail2_send',
        url: '/user/sendmsg?uid=' + uid + '&reply_id=' + reply,
        okVal: '发送',
        ok: function() {
            //提交表单
            new ajaxForm('msg_form', {
                callback: function() {
                    setTimeout(function() {
                        sendmsg_facebox.close();
                    }, 1000);
                }
            }).send();
            return false;
        }
    }).show();
}

//检查短消息
function check_pm_notice() {
    $.ajax({
        url: '/user_msg/faceboxmsg',
        type: 'get',
        success: function(data) {
            if (data) {
                var jsondata = eval('(' + data + ')');
                new faceboxNotice({
                    'title': jsondata.title,
                    'width': 250,
                    'okVal': '查看或回复',
                    'icon': 'social_email',
                    'ok': function() {
                        sendMsg(jsondata.user_id, jsondata.msg_id);
                    },
                    'cancel': function() {
                        $.ajax({
                            url: '/user_msg/setReaded?msg_id=' + jsondata.msg_id
                        });
                        this.close();
                    },
                    'time': 87600,
                    'message': jsondata.msg_content
                }).open();
            }
        }
    });
}

//facebox通知
var faceboxNotice = function(json) {
    var self = this;
    this.cancel = json.cancel ? json.cancel : function() {
    },
            this.ok = json.ok ? json.ok : function() {
                window.location.href = '/user_msg?action=show';
                return false;
            },
            this.open = function() {
                art.dialog.notice({
                    title: json.title ? json.title : '短消息',
                    width: json.width ? json.width : 250,
                    cancelVal: json.cancelVal ? json.cancelVal : '关闭',
                    cancel: self.cancel,
                    okVal: json.okVal ? json.okVal : '查看',
                    ok: self.ok,
                    content: json.message,
                    icon: json.icon ? json.icon : 'social_email',
                    time: json.time ? json.time : 360
                });
            };
};
//artDialog用户登录窗口
function loginForm(redirect) {
    login_redirect = redirect;
    dialogbox = new Facebox({
        title: '登录帐号',
        top: '50%',
        left: '45%',
        width: '450px',
        cancel: 'hidden',
        url: '/user/login'
    }).show();
}

//facebook询问框
var candyConfirm = function(json) {
    var self = this;
    this.textSuccess = json.textSuccess ? json.textSuccess : '发送成功',
            this.textSending = json.textSending ? json.textSending : '发送中';
    this.open = function() {
        new Facebox({
            id: 'candyConfirm',
            title: json.title ? json.title : '删除确认！',
            message: json.message ? json.message : '确定要删除该内容吗？注意删除后不可再恢复！',
            icon: json.icon ? json.icon : 'question',
            ok: function() {
                var $aui_buttons = $("#aui_buttons");
                var faceboxButton = $aui_buttons.find(".aui_state_highlight");
                faceboxButton.html(self.textSending);
                new Request({
                    url: json.url,
                    data: json.data,
                    type: 'post',
                    success: function(data) {
                        faceboxButton.html(self.textSuccess);
                        if (json.removeDom) {
                            candyDel(json.removeDom);
                        }
                        if (json.redirect) {
                            window.location.href = json.redirect;
                        }
                        if (json.callback) {
                            json.callback(data);
                        }
                    }
                }).send();
            }
        }).show();
    };
};
//检查刚刚参加过的活动
function checkjoinevent() {
    new Request({
        url: '/event/userjoin',
        success: function(eid) {
            if (eid > 0) {
                eventVote(eid);
            }
        }
    }).send();
}

//发表活动体会
var event_vote_facebox = null;
function eventVote(eid) {
    event_vote_facebox = new Facebox({
        title: '分享活动体会',
        width: '580px',
        url: '/event/vote?eid=' + eid,
        okVal: '立即分享',
        ok: function() {
            new ajaxForm('apply_form', {
                callback: function() {
                    event_vote_facebox.close();
                    setTimeout(function() {
                        showPrompt('谢谢分享体会:) 参加活动 积分+6', 2000);
                    }, 600);
                }
            }).send();
            return false;
        }
    }).show();
}

//参加活动但不发表评论
function signedEvent(eid) {
    new Request({
        url: '/event/votesub?event_id=' + eid + '&is_present=yesnocmt',
        type: 'post',
        success: function(data) {
            event_vote_facebox.close();
            setTimeout(function() {
                showPrompt('参加活动 积分+5', 2000);
            }, 600);
        }
    }).send();
}

//没有参加活动
function notsignEvent(eid) {
    new candyConfirm({
        message: '您真的真的没有去参加吗？您确定？',
        url: '/event/votesub?event_id=' + eid + '&is_present=no',
        callback: function(data) {
            event_vote_facebox.close();
        }
    }).open();
}

//活动星星评分
function selectvote(i) {
    selectedVote = i;
    votemsng = document.getElementById("voteSelectMsg");
    document.getElementById("postvote").value = i;
    switch (i) {
        case 1:
            votemsng.innerHTML = '差';
            break;
        case 2:
            votemsng.innerHTML = '一般';
            break;
        case 3:
            votemsng.innerHTML = '好';
            break;
        case 4:
            votemsng.innerHTML = '很好';
            break;
        case 5:
            votemsng.innerHTML = '非常好';
            break;
        default:
            votemsng.innerHTML = '尚未选择';
            break;
    }
}

//活动滑动星星
function  changevote(i) {
//离开选择
    if (i == 0) {
        for (j = 5; j > selectedVote; j--) {
            document.getElementById('vote' + j).className = 'notselected';
        }
        for (j = 1; j <= selectedVote; j++) {
            document.getElementById('vote' + j).className = 'selected';
        }
        return;
    }

    for (j = 5; j > i; j--) {
        document.getElementById('vote' + j).className = 'notselected';
    }

    for (j = 1; j <= i; j++) {
        document.getElementById('vote' + j).className = 'selected';
    }
}

//删除
function candyDel(id) {
    var removeObj = $('#' + id);
    document.getElementById(id).style.backgroundColor = '#FCB4C6';
    removeObj.fadeOut(400);
    setTimeout(function() {
        removeObj.remove();
    }, 500);
}

//删除
function candyOk(id) {
    var removeObj = $('#' + id);
    document.getElementById(id).style.backgroundColor = '#A2E3A2';
    removeObj.fadeOut(400);
    setTimeOut(function() {
        removeObj.remove();
    }, 500);
}

//登录
function loginsub() {
    new ajaxForm('userLogin', {
        textSending: '登录中',
        textError: '重试',
        loading: true,
        textSuccess: '登录成功',
        callback: function(nextOrUid) {
            var next = $('#next').val();
            if (next) {
                window.location.href = nextOrUid;
            }
            else {
                window.location.href = login_redirect;
            }

        }
    }).send();
}

//关注某校友
function markUser(mark_id) {
    var markButton = document.getElementById('markButton');
    markButton.disabled = true;
    markButton.value = '发送中';
    new Request({
        url: '/user/markUser?mark_id=' + mark_id,
        success: function(data) {
            if (data == '互关注') {
                markButton.className = 'markMutual';
                markButton.value = '互关注';
                markButton.title = '取消关注';
            }
            else if (data == '互不关注') {
                markButton.className = 'markUser';
                markButton.value = '关注';
                markButton.title = '点击关注';
            }
            else if (data == '已关注') {
                markButton.className = 'marked';
                markButton.value = '已关注';
                markButton.title = '取消关注';
            }
            else if (data == '关注了我') {
                markButton.className = 'markMe';
                markButton.value = '关注';
                markButton.title = '点击关注';
            }
            else {
            }
            markButton.disabled = false;
        }
    }).send();
}


//user
function userDetail(uid) {
    new Facebox({
        okVal: '发消息',
        ok: function() {
            this.close();
            sendMsg(uid);
            return false;
        },
        cancelVal: '关闭',
        cancel: function() {
        },
        url: '/user/userDetail?id=' + uid,
        width: 500
    }).show();
}

//判断变量是否定义
function is_defined(obj) {
    if (typeof (obj) != 'undefined' && obj != false) {
        return true;
    }
    else {
        return false;
    }
}

//评论翻页
function cmtpage(page) {
    var new_json = getCommentJson;
    new_json.page = page;
    new_json.scrollTo = 'get_comment_list';
    get_comment(new_json);
}

//获取论坛评论
function get_comment(json) {

    var query = json.query;
    //滚动到屏幕某一位置
    if (is_defined(json.scrollTo)) {
        scrollTo(json.scrollTo, 500);
    }
//指定某一页
    if (is_defined(json.page)) {
        query += '&page=' + json.page;
    }

    if (is_defined(json.uid)) {
        query += '&reply=' + json.uid;
    }

//获取某一条评论
    if (is_defined(json.cmt_id)) {
        query += '&cmt_id=' + json.cmt_id;
    }

//异步获取
    new Request({
        url: json.getUrl,
        data: query,
        success: function(data) {
            if (is_defined(json.cmt_id)) {
                //是修改删除以前的
                var $old_cmt_box = $("#comment_" + json.cmt_id);
                if ($old_cmt_box.length >= 1) {
                    $old_cmt_box.remove();
                }
                $("#comment_page_box").before(data);
                $("#comment_" + json.cmt_id).fadeTo(0, 0);
                $("#comment_" + json.cmt_id).fadeTo(300, 1);
            }
            else {
                $('#get_comment_list').html(data);
            }
        }
    }).send();
}

//发布评论
function post_comment(json) {
    if (!ueditor.hasContents()) {
        ueditor.setContent('<p></p>');
    }
    ueditor.sync();
    new ajaxForm(json.form, {
        textSending: '发送中',
        textError: '发布失败',
        loading: true,
        textSuccess: '发表成功',
        callback: function(id) {

            //清空之前内容
            ueditor.setContent('<p></p>');
            if ($('#cmt_id').val() == '') {
                $('#not_cmt').remove();
                setTimeout(function() {
                    showPrompt('发表评论 积分+1', 1200);
                }, 600);
            }
            else {
                $('#cmt_id').attr('value', '');
            }
            $('#quote_id').attr('value', '');
            $('#quote_box').html('').hide();
            //获取最新评论或最后一条评论
            get_comment({
                'page': 'last',
                'scrollTo': false,
                'uid': false,
                'query': json.query,
                'getUrl': json.getUrl,
                'cmt_id': id
            });
        }
    }).send();
}

//修改评论
function modify_comment(id) {
    scrollTo('comment_form', 300);
    $('#cmt_id').attr('value', id);
    var submit_button = $('#submit_button');
    submit_button.attr('value', '保存修改');
    submit_button.attr('disabled', true);
    submit_button.addClass('button_disabled');
    $('#quote_id').attr('value', '');
    $('#quote_box').html('');
    ueditor.setContent('<span style="color:#999">正在载入，请稍候...</span>');
    new Request({
        url: '/comment/modifycontent?id=' + id,
        type: 'get',
        success: function(data) {
            ueditor.setContent('' + data + '');
            submit_button.attr('disabled', false);
            submit_button.removeClass('button_disabled');
            submit_button.addClass('button_blue');
        }
    }).send();
}

//引用引用
function quote_comment(id) {

    var quote_box = document.getElementById('quote_box');
    var user = $('#comment_author_' + id).text();
    var postdate = $('#comment_postdate_' + id).text();
    quote_box.style.display = 'block';
    quote_box.innerHTML = '<span><b>引用</b> ' + user + "&nbsp;" + postdate + '&nbsp;发布的评论&nbsp;</span><img src="/static/images/cancel.gif" style="vertical-align: middle" onclick="cancel_quote()" title="取消引用">';
    $('#quote_id').attr('value', id);
    $('#cmt_id').attr('value', '');
    if (ueditor.hasContents()) {
        ueditor.setContent('<p></p>');
    }
    scrollTo('comment_form', 500);
}

//取消引用
function cancel_quote() {
    var quote_box = document.getElementById('quote_box');
    document.getElementById('quote_id').value = '';
    quote_box.innerHTML = '';
    quote_box.style.display = 'none';
}

//滚动到指定位置
function scrollTo(id, speed) {
    $.scrollTo('#' + id, speed);
}

//实时显示剩余字数
function countChar(textobj, spanName, maxlength) {
    var obj = document.getElementById(textobj);
    var obj_count = obj.value.length;
    if (obj_count <= maxlength) {
        document.getElementById(spanName).innerHTML = maxlength - obj_count;
    }
    else {
        obj.value = obj.value.substring(0, maxlength);
    }
}

//加入收藏夹
function AddFavorite(sURL, sTitle) {
    try {
        window.external.addFavorite(sURL, sTitle);
    } catch (e) {
        try {
            window.sidebar.addPanel(sTitle, sURL, "");
        } catch (e) {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

//感兴趣投票
function interested(event_id, interested_num) {
    var interested_box = document.getElementById('interested_box');
    interested_box.innerHTML = '提交中...';
    new Request({
        url: '/event/interested?id=' + event_id,
        type: 'post',
        success: function(data) {
            if (data == 'ed') {
                alert('您已经透过票啦~');
                interested_box.innerHTML = '感兴趣(' + interested_num + ')';
            }
            else {
                interested_box.innerHTML = data;
            }
        }
    }).send();
}

//返回顶部
function getToTop() {
    var $go_btn = $('#go2top');
    $('#go2top').click(function() {
        $("html,body").animate({scrollTop: 0}, 200);
        return false;
    });
    //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $go_btn.fadeIn(400);
        }
        else
        {
            $go_btn.fadeOut(400);
        }
    });
}

//运行内联脚本
function runReadyScript() {
    var statrTime;
    $.each(readyScript, function(name, script) {
        statrTime = new Date().getTime();
        script();
        //candylog('run ' + name + ':' + (new Date().getTime() - statrTime) / 1000 + 's');
    });
}
;