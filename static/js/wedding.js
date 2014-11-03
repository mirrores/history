/*
 * tiyo wish
 * teo.leung@gmail.com
 */

(function($) {
    $.fn.wish = function() {
        var _this = this;
        var _wish = _this.children();

        var wish = {
            area: {
                left: 0,
                top: 0,
                right: _this.width(),
                bottom: _this.height()
            },
            skin: {
                width: 200,
                height: 150
            }
        };
        $.extend(wish);

        var _left = wish.area.left;
        var _right = wish.area.right;
        var _top = wish.area.top;
        var _bottom = wish.area.bottom;

        _right = _right - _left > wish.skin.width ? _right : _left + wish.skin.width;
        _bottom = _bottom - _top > wish.skin.height ? _bottom : _top + wish.skin.height;

        _right = _right - wish.skin.width;
        _bottom = _bottom - wish.skin.height;

        var methods = {
            rans: function(v1, v2) {
                var ran = parseInt(Math.random() * (v2 - v1) + v1);
                return ran;
            },
            pos: function() {
                return {left: methods.rans(_left - 10, _right + 10), top: methods.rans(_top - 10, _bottom + 10)}
            },
            css: function() {
                return methods.rans(1, 6);
            }
        }

        _wish.each(function(i) {
            var _p = methods.pos();
            var _s = methods.css();
            var _self = $(this);
            _self.prepend('<a class="close"></a>');
            _self.addClass('wish').addClass('s' + _s).css({'position': 'absolute', 'left': _p.left + 'px', 'top': _p.top + 'px'});
            _self.hover(
                    function() {
                        _self.css({'z-index': '999', 'border': 'none'}).children('.close').show().bind('click', function() {
                            _self.effect('scale', {percent: 0}, 200, function() {
                                _self.remove()
                            })
                        });
                    },
                    function() {
                        _self.css({'z-index': '', 'border': 'none'}).children('.close').hide();
                    });
        });

    };

})(jQuery);


//抽奖
var lottery = {
    //超时函数
    timeOut: function() {
        $("#lotteryBtn").rotate({
            angle: 0,
            duration: 10000,
            animateTo: 2160, //这里是设置请求超时后返回的角度，所以应该还是回到最原始的位置，2160是因为我要让它转6圈，就是360*6得来的
            callback: function() {
                alert('很抱歉，网络超时，请稍候重试。');
            }
        });
    },
    //旋转输入的角度
    //awards:奖项
    //angle:奖项对应的角度
    //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
    rotateFunc: function(result, angle, message) {
        $('#lotteryBtn').stopRotate();
        var icon = 'face-smile';
        $("#lotteryBtn").rotate({
            angle: 0,
            duration: 5000,
            animateTo: angle + 2880,
            callback: function() {
                if (result == 'error') {
                    icon = 'error';
                }
                else if (result == 'yes') {
                    icon = 'face-smile';
                }
                else if (result == 'no') {
                    icon = 'face-sad';
                }
                else {
                    icon = 'warning';
                }
                faceboxAlert({
                    icon: icon,
                    message: message,
                    time: 30
                });
            }
        });
    },
    //取消转盘按钮并提示相关语句
    proscribeBtn: function(message) {
        $("#lotteryBtn").unbind().click(function() {
            faceboxAlert({
                icon: 'warning',
                message: message,
                time: 30
            });
        });
    },
    //绑定抽奖按钮
    bindRotate: function(wedding_id) {
        var _this = this;
        var server_results = null;
        var lotteryBtn = $("#lotteryBtn");
        lotteryBtn.unbind();
        lotteryBtn.rotate({
            bind: {click: function() {
                    $.ajax({
                        type: "post",
                        url: "/wedding/lottery_results",
                        dataType: "json",
                        data: 'id=' + wedding_id,
                        async: false,
                        success: function(data) {
                            server_results = data;
                        }
                    });

                    if (server_results.result == 'error') {
                        _this.rotateFunc('error', 0, server_results.message);
                    }
                    else if (server_results.result == 'yes') {
                        _this.rotateFunc('yes', parseInt(server_results.awards_angle), server_results.message);
                    }
                    else if (server_results.result == 'no') {
                        _this.rotateFunc('no', 360, server_results.message);
                    }
                    else {
                        _this.rotateFunc('error', 0, '抽奖异常出错，请与管理员联系或重试！');
                    }

                    _this.proscribeBtn('很抱歉，您已经抽过奖了：）');
                }
            }
        });
    }
}

//报名评选
function good(sign_id, votekey) {
    var $obj = $('#signvote_' + sign_id);
    var $num = $obj.find('span.goodnum');
    new Request({
        url: '/wedding/good',
        type: 'post',
        data: 'sign_id=' + sign_id + '&votekey=' + votekey,
        beforeSend: function() {
            $('#votetext' + sign_id).html('请稍候');
        },
        success: function(data) {
            if (data == 'voted') {
                $('#votetext' + sign_id).html('已投票');
                faceboxAlert({
                    icon: 'warning',
                    message: '很抱歉，该对新人您已经投过该票了！'
                });
            }
            else if (data == 'maximum') {
                $('#votetext' + sign_id).html('投一票');
                faceboxAlert({
                    icon: 'warning',
                    message: '很抱歉，您今天已经投票很多了，歇会吧！'
                });
            }
            else if (data == 'error') {
                $('#votetext' + sign_id).html('投一票');
                faceboxAlert({
                    icon: 'warning',
                    message: '投票失败，数据发送失败!'
                });
            }
            else if (data == 'errorkey') {
                $('#votetext' + sign_id).html('投一票');
                faceboxAlert({
                    icon: 'warning',
                    message: '投票失败，错误投票验证码!'
                });
            }
            else {
                $obj.find('span.animatevote').show().animate({'opacity': 0, 'top': '-60px'}, 400, 'linear', function() {
                    $(this).hide().css({'opacity': 1, 'top': '-15px'});
                    $num.html(parseInt($num.html()) + 1);
                    $('#votetext' + sign_id).html('已投票');
                });
            }
        }
    }).send();
}

//发表祝福
function write_wish(wedding_id) {
    var wishwindow = new Facebox({
        title: '签写婚礼祝福',
        url: '/wedding/wishform?id=' + wedding_id,
        okVal: '送上祝福',
        ok: function() {
            //提交表单
            new ajaxForm('wish_form', {
                textSuccess: '发送成功',
                textSending: '提交中',
                data_type: 'json',
                callback: function(data) {
                    wishwindow.close();
                    if (data.id > 0) {
                        $('#wish').append('<div>' + data.content + '<p>' + data.realname + '&nbsp;' + data.created_at + '</p></div>');
                        resetWishWall();
                        lottery.bindRotate(wedding_id);
                    }
                    else {
                        errorAlert(data);
                    }
                }
            }).send();
            return false;
        }
    }).show();
}

//重置祝福墙
function resetWishWall() {
    $('#wish').wish();
    $('.wish').draggable({containment: "#wish", scroll: false});
}

//ie6透明度
function correctPNG()
{
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])
    if ((version >= 5.5) && (document.body.filters))
    {
        for (var j = 0; j < document.images.length; j++)
        {
            var img = document.images[j]
            var imgName = img.src.toUpperCase()
            if (imgName.substring(imgName.length - 3, imgName.length) == "PNG")
            {
                var imgID = (img.id) ? "id='" + img.id + "' " : ""
                var imgClass = (img.className) ? "class='" + img.className + "' " : ""
                var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
                var imgStyle = "display:inline-block;" + img.style.cssText
                if (img.align == "left")
                    imgStyle = "float:left;" + imgStyle
                if (img.align == "right")
                    imgStyle = "float:right;" + imgStyle
                if (img.parentElement.href)
                    imgStyle = "cursor:hand;" + imgStyle
                var strNewHTML = "<span " + imgID + imgClass + imgTitle
                        + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
                        + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
                        + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
                img.outerHTML = strNewHTML
                j = j - 1
            }
        }
    }
}


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