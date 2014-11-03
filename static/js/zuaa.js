window.addEvent('domready', function(){
    $$('._mark_tigger').each(function(el){
        el.addEvent('click', function(){
            var obj = this.get('title');
            var val = this.get('rel');
            new Request({
                url:'/main/mark',
                method:'get',
                data:'obj='+obj+'&val='+val,
                onSuccess: function(data){
                    el.set('html', data);
                }
            }).send();
        });
    });
    checkOnline();
    //candyFloat('right');
});

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

function candyFloat(position)
{
    var top = new Element('div', {
        'styles': {
            'width': '40px',
            'height': '40px',
            'cursor': 'pointer'
        },
        'events': {
            'click': function(){
                new Fx.Scroll(window).toTop();
            }
        }
    });

    var bottom = new Element('div', {
        'styles': {
            'width': '40px',
            'height': '40px',
            'cursor': 'pointer'
        },
        'events': {
            'click': function(){
                new Fx.Scroll(window).toBottom();
            }
        }
    });

    var btn = new Element('div', {
        'id': 'candyFloat',
        'class': 'candyCorner',
        'styles': {
            'position': 'absolute',
            'z-index': 1000,
            'top': 0,
            'width': '40px',
            'height': '80px',
            'background': 'url(/static/images/arr_tb.gif) no-repeat',
            'opacity': 0
        }
    });

    btn.grab(top);btn.grab(bottom);
    $$('.container').grab(btn, 'after');

    if(position == 'right'){
        $('candyFloat').setStyle('left', window.getSize().x/2+480);
    }

    if(position == 'left'){
        $('candyFloat').setStyle('left', window.getSize().x/2-530);
    }

    window.addEvent('scroll', function(){
       var bd_offset = window.getScroll().y;
       var bd_h = window.getSize().y;

       if(bd_offset == 0){
           $('candyFloat').fade(0);
       } else {
           $('candyFloat').fade(0.4);
           $('candyFloat').setStyles({
               top: bd_h - 200 + bd_offset
           });
       }
    });
}

function refDigg(dig){
    if($$('.digg_num').length > 0){
        var dig_id = $defined(dig) ? dig : 0;
        $$('.digg_num').each(function(el){
            el.load('/news/digg?id='+el.get('rel')+'&dig='+dig_id);
        })
    }
}

function userPrivateSelector(){
    if($$('.user_private').length > 0){
        $$('.user_private').addEvent('change', function(){
            new Request({
                url: '/user/private',
                data: 'name='+this.get('rel')+'&rule='+this.value,
                method: 'post',
                onSuccess: function(data){
                    //alert(data);
                }
            }).send();
        });
    }
}

function checkOnline(){
    if($$('.user_avatar').length > 0){
        // 需要调用在线状态
        new Request({
            url: '/user/online',
            onSuccess: function(json){
                var hash = new Hash(JSON.decode(json));
                $$('.user_avatar').each(function(el){
                    if(hash.has(el.get('rel')))
                        el.addClass('online');
                });
            }
        }).send();
    }
}

function picsRoll(name){
    var np_timer;
    var cur_index = 0;
    // 图片们
    var pics = $$('.candyPicRoll');
    var pn = pics.length;
    var index = [];
    if(pn > 0){
        pics.each(function(el){
            index.extend([el.get('rel')]);
        });
        
        var np_display = function(ix){
            var cur_pic = $$('.candyPicRoll[rel='+index[ix]+']');
            pics.addClass('hide');
            cur_pic.removeClass('hide');
            cur_pic.fade('hide');
            cur_pic.fade('in');
            $(name+'_pics_title').set('html', cur_pic.get('alt'));
            if($defined($(name+'_pics_state')))
            $(name+'_pics_state').set('html', (cur_index+1)+' / '+pn);
        }

        var np_next = function(){
            cur_index++;
            if(cur_index >= pn){
                cur_index = 0;
            }
            np_display(cur_index);
        }

        var np_prev = function(){
            cur_index--;
            if(cur_index < 0){
                cur_index = (pn-1);
            }
            np_display(cur_index);
        }

        if($defined($(name+'_pics_prev')))
        $(name+'_pics_prev').addEvent('click', function(){
            np_prev();
            window.clearTimeout(np_timer);
        });

        if($defined($(name+'_pics_next')))
        $(name+'_pics_next').addEvent('click', function(){
            np_next();
            window.clearTimeout(np_timer);
        });

        $(name+'_pics').addEvent('mouseenter', function(){
            window.clearTimeout(np_timer);
        });
        $(name+'_pics').addEvent('mouseleave', function(){
            np_timer = window.setInterval(np_next, 6000);
        });
    }
    if(pn > 1){
        np_timer = window.setInterval(np_next, 6000);
    }
    np_display(0);
}

function news_tab(flag, delay){
    var run = function(){
        $$('.news_item').each(function(el){
            if(el.hasClass(flag+'_news_tr')){
                el.setStyle('display', 'block');
            } else {
                el.setStyle('display', 'none');
            }
        });
        $$('#news_table a[rel!='+flag+']').removeClass('cur');
        $$('#news_table a[rel='+flag+']').addClass('cur');
    }
    news_tab_timer = run.delay(delay);
}


function event_tab(flag, delay){
    var run = function(){
        $$('.event_item').each(function(el){
            if(el.hasClass(flag+'_event_tr')){
                el.setStyle('display', 'block');
            } else {
                el.setStyle('display', 'none');
            }
        });
        $$('#event_table a[rel!='+flag+']').removeClass('cur');
        $$('#event_table a[rel='+flag+']').addClass('cur');
    }
    event_tab_timer = run.delay(delay);
}

// 说明 ：用 Javascript 实现锚点(Anchor)间平滑跳转
    // 转换为数字
    function intval(v)
    {
        v = parseInt(v);
        return isNaN(v) ? 0 : v;
    }

    // 获取元素信息
    function getPos(e)
    {
        var l = 0;
        var t  = 0;
        var w = intval(e.style.width);
        var h = intval(e.style.height);
        var wb = e.offsetWidth;
        var hb = e.offsetHeight;
        while (e.offsetParent)
        {
            l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
            t += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
            e = e.offsetParent;
        }
        l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
        t  += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
        return {x:l, y:t, w:w, h:h, wb:wb, hb:hb}; }

   // 获取滚动条信息
    function getScrolls()
    {
        var t, l, w, h;
        if (document.documentElement && document.documentElement.scrollTop)
        {
            t = document.documentElement.scrollTop;
            l = document.documentElement.scrollLeft;
            w = document.documentElement.scrollWidth;
            h = document.documentElement.scrollHeight;
        }
        else if (document.body)
        {
            t = document.body.scrollTop;
            l = document.body.scrollLeft;
            w = document.body.scrollWidth;
            h = document.body.scrollHeight;
        }
        return { t: t, l: l, w: w, h: h };
    }

    // 锚点(Anchor)间平滑跳转
    function scroller(el, duration)
    {
        if(typeof el != 'object')
        {
            el = document.getElementById(el);
        }
        if(!el) return;
        var z = this;
        z.el = el;
        z.p = getPos(el);
        z.s = getScrolls();
        z.clear = function()
        {
            window.clearInterval(z.timer);z.timer=null
        };
        z.t=(new Date).getTime();
        z.step = function()
        {
            var t = (new Date).getTime();
            var p = (t - z.t) / duration;
            if (t >= duration + z.t)
            {
                z.clear();
                window.setTimeout(function(){z.scroll(z.p.y, z.p.x)},13);         }
            else {
                st = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.y-z.s.t) + z.s.t;
                sl = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.x-z.s.l) + z.s.l;
                z.scroll(st, sl);
            }
        };
        z.scroll = function (t, l){window.scrollTo(l, t)};
        z.timer = window.setInterval(function(){z.step();},13);
    }