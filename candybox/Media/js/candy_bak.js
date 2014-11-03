document.write('<script type="text/javascript" src="/static/js/moomore.js"></script>');
document.write('<script type="text/javascript" src="/static/js/niftycube.js"></script>');

window.addEvent('domready', function(){
    Nifty("div.corner");
    if($chk($('verify_box'))) _verify();
    
    if($$('.ico_offline').length > 0){
        // 需要调用在线状态
        new Request({
            url: '/public_user/online',
            onSuccess: function(json){
                var hash = new Hash(JSON.decode(json));
                $$('.ico_offline').each(function(el){
                    if(hash.has(el.get('rel')))
                        el.set('class', 'ico_online icon-i');
                });
            }
        }).send();
    }
});

var _date_month = ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'];
var _date_days = ['日','一','二','三','四','五','六'];

function _handler_fade(trigger_class, focus_class, handler_class){
    $$('.'+trigger_class).addEvent('mouseenter', function(){
        this.addClass(focus_class);
        this.getElement('.'+handler_class).fade('in');
    });
    $$('.'+trigger_class).addEvent('mouseleave', function(){
        this.removeClass(focus_class);
        this.getElement('.'+handler_class).fade('out');
    });
}

// tr变色
function _odd(class_name, color_hex){
    $$('.'+class_name+':odd').setStyle('backgroundColor', color_hex);
}

// 关注操作
function _mark(type, val, flag){
    new Request({
        url:'/user_mark/'+flag+'?t='+type+'&v='+val,
        onSuccess:function(data){$('mark_'+val+'_'+flag).set('html', data);
    }}).send();
}

function _fadeout(box_id){
    var box = new Fx.Tween($(box_id), {
        onComplete: function(){$(box_id).dispose();}
    });
    box.start('opacity', [,0]);
}

function _clone_inputs(box_id){
    var clone = $(box_id).clone().inject(box_id, 'after');
    var clone_inputs = clone.getElements('input');
    clone_inputs.each(function(el){
        el.set('value', '');
    });
}

function _autoresize(box_id, width){
    var box_w = $(box_id).getSize().x;
    var imgs = $(box_id).getElements('img');
    imgs.each(function(el){
        if(box_w < el.getSize().x){
            el.setStyle('width', width);
        }
        else
            el.setStyle('width', 'auto');
    });
}

// ckeidtor初始化
function ckeditor_init(text_id, toolbar, width){
    var ck = CKEDITOR.replace(text_id, {
        toolbar: toolbar,
        width: $defined(width) ? width : '98%'
    });
    CKFinder.SetupCKEditor(ck, '/static/ckfinder/');
    return ck;
}

function _nav_qlink(){
    $$('.nav_qlink').each(function(el){
        var cnt = $(el.get('rel'));
        cnt.setStyle('display', 'none');
        el.addEvent('mouseenter', function(){
            this.setStyle('zIndex', 1);
            cnt.setStyle('display', 'block');
        });
        el.addEvent('mouseleave', function(){
            cnt.setStyle('display', 'none');
        });
    });
}

/**
 * 全局验证码
 */
function _verify(){
    if($defined($('verify_box'))) $('verify_box').load('/public_user/verify');
}

/**
 * 类似google的suggest框
 */
function _suggest(id, url, delay){

    // 包含查询结果的div id名称
    var box_id = id+'_result';
    // 提取真实数据的input id 一般为hidden类型
    var rel_data_id = id+'_rel';

    // div 元素创建
    var box = new Element('div', {
        'id': box_id,
        'class': 'autocomplete',
        'styles': {
            'opacity': 0,
            'position': 'absolute',
            'z-index': '100'
        },
        'tween': { 
            duration: 'short'
        }
    });

    var set_data = function(el){
        // 真正需要获取的数据
        var rel_data = el.get('rel');
        if($chk(rel_data)){
            $(rel_data_id).set('value', rel_data);
        }
        $(id).set('value', el.get('title'));
    }

    // html 请求创建
    var html_req = new Request.HTML({
        url: url,
        onSuccess: function(tree,el,html){
            if(html != ''){
                box.set('html', html).fade('in');
                var links = box.getElements('a');
                if(links.length > 0){
                    links.addEvent('mouseover', function(){
                        this.addClass('autocomplete_active');
                        set_data(this);
                    });

                    links.addEvent('mouseout', function(){
                        links.removeClass('autocomplete_active');
                    });

                    links.addEvent('click', function(){
                        set_data(this);
                        box.fade('out');
                    });
                }
            } else box.fade('out');
        }
    });

    // 触发函数创建
    var fun = function(){
        if( ! $chk($(box.id)))
            $(id).grab(box, 'after');
        
        html_req.get({ 
            q: $(id).get('value')
        }).send();
    }

    // 事件与元素绑定
    $(id).addEvent('keypress', function(e){

        if(e.code != 40 && e.code != 38 && e.code != 13){
            
            // 一旦文字改动则重置value
            $(rel_data_id).set('value', '');
            fun.delay(delay, this);
        }
        else{
            var actived = box.getElement('.autocomplete_active');
            var first_link = box.getFirst('a');
            var last_link = box.getLast('a');

            // 回车
            if(e.code == 13){
                box.fade('out');
            }

            // 向下
            if(e.code == 40){

                if(actived == last_link){
                    actived.removeClass('autocomplete_active');
                    actived = null;
                }

                if( ! $chk(actived)){
                    first_link.addClass('autocomplete_active');
                    set_data(first_link);
                } else {
                    actived.removeClass('autocomplete_active');
                    var next_link = actived.getNext();
                    next_link.addClass('autocomplete_active');
                    set_data(next_link);
                }

            } else if(e.code == 38) {

                if(actived == first_link){
                    actived.removeClass('autocomplete_active');
                    actived = null;
                }

                if( ! $chk(actived)){
                    last_link.addClass('autocomplete_active');
                    set_data(last_link);
                } else {
                    actived.removeClass('autocomplete_active');
                    var pre_link = actived.getPrevious();
                    pre_link.addClass('autocomplete_active');
                    set_data(pre_link);
                }
            }
        }
    });
}

/**
 * 鼠标mouseover效果
 */
function _hover(oid, li, color){
    var color = $chk(color) ? color : '#f5f5f5';
    if($defined($(oid))){
        var lis = $(oid).getElements(li);
        lis.addEvent('mouseover', function(){
            this.setStyle('background', color);
        });
        lis.addEvent('mouseout', function(){
            this.setStyle('background', 'none');
        });
    }
}

/**
 * 表单ajax提交设置类
 */
var LP_REQ = new Class({
    Implements: Options,
    options: {
        err_tag: 'err#', // 如果返回格式为html时鉴别是否为错误信息的标识
        // 触发器不同状态的文字信息
        btn_post: '请求中',
        btn_err: '请检查数据',
        btn_ok: '提交成功',
        // 信息提示
        tip_tag: 'div',
        tip_err_class: 'error',
        tip_ok_class: 'success',
        tip_pos: 'after',
        tip_wrap: '', // 提示信息外套元素,一般用在format:html
        form_id: '',
        btn_id: '',
        url: '',
        format: 'alert',
        method: 'post',
        redirect: '', // 成功后的跳转
        callback: '', // 成功后执行函数
        delay: 500, // 跳转延迟
        debug: false
    },
    // 构析
    initialize: function(options){
        this.setOptions(options);
    }
});

/**
 * 提交请求函数
 */
function lp_req(valid){
    var options = valid.options;
    var form = $(options.form_id);
    var tip_wrap = $chk(options.tip_wrap) ? $(options.tip_wrap) : form;
    var btn = $chk(options.btn_id) ? $(options.btn_id) : form.getElement('input[type=submit]');
    var url = $chk(options.url) ? options.url : form.get('action');
    var data = $chk(options.data) ? form.toQueryString()+'&'+options.data : form;
    var jumper = function(){ 
        window.location.href = arguments[0];
    };
    // 阻止提交
    if(form.get('tag') == 'form')
        form.addEvent('submit', function(e){
            e.stop();
        });
    // btn tag判断
    if($defined(btn))
        var btn_set_attr = (btn.get('tag') == 'input') ? 'value' : 'html';
    var req = new Request({
        method: options.method,
        url: url,
        data: data,
        onRequest: function(){
            // 清除已有提示信息
            $$(options.tip_tag+'.'+options.tip_err_class+', '+options.tip_tag+'.'+options.tip_ok_class).destroy();
            // 改变触发器text
            if($defined(btn)){
                btn.set(btn_set_attr, options.btn_post);
                if(options.debug == false){
                    btn.set('disabled', true);
                }
            }
        },
        onSuccess: function(data){
            if(options.debug == true){
                alert(data);
            }
            var result = data;
            var right = false;
            if(result.contains(options.err_tag)){
                var output = result.replace(options.err_tag, '');
                if(options.format == 'html'){
                    tip_wrap.grab(new Element(options.tip_tag, {
                        'id': 'tip_err',
                        'class': options.tip_err_class,
                        'html': output,
                        'styles': {
                            'opacity': 0
                        }
                    }), options.tip_pos);
                    new Fx.Scroll(window).toElement('tip_err');
                    $('tip_err').fade('in');
                }
                else {
                    var facebox = new Facebox({
                        title: '信息提示',
                        message: output,
                        submitValue: false,
                        cancelValue: '关闭'
                    });
                    if( ! $type(facebox)){
                        alert(output);
                    }
                    else{
                        facebox.show();
                    }
                }
            } else {
                right = true;
            }

            if(right == false){
                if($defined(btn)) btn.set(btn_set_attr, options.btn_err);
            } else {
                if($defined(btn)) btn.set(btn_set_attr, options.btn_ok);
                // 跳转
                if($chk(options.redirect)) {
                    jumper.delay(options.delay, this, options.redirect);
                }
                // 回调函数
                if($chk(options.callback)){
                    var callback_type = $type(options.callback);
                    if(callback_type == 'string')
                        eval(options.callback);
                    if(callback_type == 'function'){
                        options.callback.delay(options.delay, this, result);
                    }
                }
            }

            if($defined(btn))
                btn.set('disabled', false);
        }
    });
    req.send();
}

/**
 * 对Date的扩展，将 Date 转化为指定格式的String
 * 月(M)、日(d)、12小时(h)、24小时(H)、分(m)、秒(s)、周(E)、季度(q) 可以用 1-2 个占位符
 * 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
 * eg:
 * (new Date()).fmt("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
 * (new Date()).fmt("yyyy-MM-dd E HH:mm:ss") ==> 2009-03-10 二 20:09:04
 * (new Date()).fmt("yyyy-MM-dd EE hh:mm:ss") ==> 2009-03-10 周二 08:09:04
 * (new Date()).fmt("yyyy-MM-dd EEE hh:mm:ss") ==> 2009-03-10 星期二 08:09:04
 * (new Date()).fmt("yyyy-M-d h:m:s.S") ==> 2006-7-2 8:9:4.18
 */
Date.prototype.fmt=function(fmt) {
	var o = {
	"M+" : this.getMonth()+1, //月份
	"d+" : this.getDate(), //日
	"h+" : this.getHours()%12 == 0 ? 12 : this.getHours()%12, //小时
	"H+" : this.getHours(), //小时
	"m+" : this.getMinutes(), //分
	"s+" : this.getSeconds(), //秒
	"q+" : Math.floor((this.getMonth()+3)/3), //季度
	"S" : this.getMilliseconds() //毫秒
	};
	var week = {
	"0" : "\u65e5",
	"1" : "\u4e00",
	"2" : "\u4e8c",
	"3" : "\u4e09",
	"4" : "\u56db",
	"5" : "\u4e94",
	"6" : "\u516d"
	};
	if(/(y+)/.test(fmt)){
		fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
	}
	if(/(E+)/.test(fmt)){
		fmt=fmt.replace(RegExp.$1, ((RegExp.$1.length>1) ? (RegExp.$1.length>2 ? "\u661f\u671f" : "\u5468") : "")+week[this.getDay()+""]);
	}
	for(var k in o){
		if(new RegExp("("+ k +")").test(fmt)){
			fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
		}
	}
	return fmt;
}

function mousePosition(ev){
    if(ev.pageX || ev.pageY){
        return {x:ev.pageX, y:ev.pageY};
    }
    return {
        x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
        y:ev.clientY + document.body.scrollTop  - document.body.clientTop
    };
} 