var sHome = {};


//切换tab
sHome.setTab = function(name, cursel, n) {
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var con = document.getElementById("con_" + name + "_" + i);
        menu.className = i == cursel ? "cur" : "";
        con.style.display = i == cursel ? "block" : "none";
    }
};

//左右滚动
sHome.toleft = function(demo, demo1, demo2, speed, flag) {
    demo = document.getElementById(demo);
    demo1 = document.getElementById(demo1);
    demo2 = document.getElementById(demo2);
    demo2.innerHTML = demo1.innerHTML;
    function Marquee() {
        if (demo2.offsetWidth - demo.scrollLeft <= 0) {
            demo.scrollLeft -= demo1.offsetWidth;
        }
        else {
            demo.scrollLeft++;
        }
    }
    ;
    flag = setInterval(Marquee, speed);
    demo.onmouseover = function() {
        clearInterval(flag);
    };
    demo.onmouseout = function() {
        flag = setInterval(Marquee, speed);
    };
}

//焦点新闻
sHome.focusNews = function(options) {
    var def = {titles: '',
        imgs: '',
        urls: '',
        pw: 663,
        ph: 185,
        sizes: 14,
        Times: 4000,
        umcolor: 0xFFFFFF,
        btnbg: 0xFF7E00,
        txtcolor: 0xFFFFFF,
        txtoutcolor: 0x000000};
    var config = $.extend({}, def, options);
    var flash = new SWFObject('/static/focus65.swf', 'mymovie', config.pw, config.ph, '7', '');
    flash.addParam('allowFullScreen', 'true');
    flash.addParam('allowScriptAccess', 'always');
    flash.addParam('quality', 'high');
    flash.addParam('wmode', 'Transparent');
    flash.addVariable('pw', config.pw);
    flash.addVariable('ph', config.ph);
    flash.addVariable('sizes', config.sizes);
    flash.addVariable('umcolor', config.umcolor);
    flash.addVariable('btnbg', config.btnbg);
    flash.addVariable('txtcolor', config.txtcolor);
    flash.addVariable('txtoutcolor', config.txtoutcolor);
    flash.addVariable('urls', config.urls);
    flash.addVariable('Times', config.Times);
    flash.addVariable('titles', config.titles);
    flash.addVariable('imgs', config.imgs);
    flash.write('banner');
};

sHome.setMorePhoto = function(obj) {
    document.getElementById('morephoto1').style.display = 'none';
    document.getElementById('morephoto2').style.display = 'none';
    document.getElementById(obj).style.display = '';
};

(function($) {
    $.fn.extend({
        RollTitle: function(opt, callback) {
            if (!opt)
                var opt = {};
            var _this = this;
            _this.timer = null;
            _this.lineH = _this.find("li:first").height();
            _this.line = opt.line ? parseInt(opt.line, 15) : parseInt(_this.height() / _this.lineH, 10);
            _this.speed = opt.speed ? parseInt(opt.speed, 10) : 3000, //卷动速度，数值越大，速度越慢（毫秒
                    _this.timespan = opt.timespan ? parseInt(opt.timespan, 13) : 5000; //滚动的时间间隔（毫秒
            if (_this.line == 0)
                this.line = 1;
            _this.upHeight = 0 - _this.line * _this.lineH;
            _this.scrollUp = function() {
                _this.animate({
                    marginTop: _this.upHeight
                }, _this.speed, function() {
                    for (i = 1; i <= _this.line; i++) {
                        _this.find("li:first").appendTo(_this);
                    }
                    _this.css({marginTop: 0});
                });
            };
            _this.hover(function() {
                clearInterval(_this.timer);
            }, function() {
                _this.timer = setInterval(function() {
                    _this.scrollUp();
                }, _this.timespan);
            }).mouseout();
        }
    });
})(jQuery);


function home_login() {
    new ajaxForm('userLogin', {
        textSending: '验证中',
        textError: '重试',
        submitButton:'home_login_button',
        errorDisplayType:'dialogbox',
        loading:true,
        textSuccess: '登录成功',
        callback: function(){
            window.location.href='/user/home';
        }
    }).send();
}


