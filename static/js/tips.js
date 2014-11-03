var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
BROWSER.ie = window.ActiveXObject && USERAGENT.indexOf('msie') != -1 && USERAGENT.substr(USERAGENT.indexOf('msie') + 5, 3);
BROWSER.firefox = document.getBoxObjectFor && USERAGENT.indexOf('firefox') != -1 && USERAGENT.substr(USERAGENT.indexOf('firefox') + 8, 3);
BROWSER.chrome = window.MessageEvent && !document.getBoxObjectFor && USERAGENT.indexOf('chrome') != -1 && USERAGENT.substr(USERAGENT.indexOf('chrome') + 7, 10);
BROWSER.opera = window.opera && opera.version();
BROWSER.safari = window.openDatabase && USERAGENT.indexOf('safari') != -1 && USERAGENT.substr(USERAGENT.indexOf('safari') + 7, 8);
BROWSER.other = !BROWSER.ie && !BROWSER.firefox && !BROWSER.chrome && !BROWSER.opera && !BROWSER.safari;
BROWSER.firefox = BROWSER.chrome ? 1 : BROWSER.firefox;

var DISCUZCODE = [];
DISCUZCODE['num'] = '-1';
DISCUZCODE['html'] = [];
var CSSLOADED = [];
var JSMENU = [];
JSMENU['active'] = [];
JSMENU['timer'] = [];
JSMENU['drag'] = [];
JSMENU['layer'] = 0;
JSMENU['zIndex'] = {
    'win':200,
    'menu':300,
    'prompt':400,
    'dialog':500
};
JSMENU['float'] = '';
var AJAX = [];
AJAX['debug'] = 0;
AJAX['url'] = [];
AJAX['stack'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var clipboardswfdata = '';
var CURRENTSTYPE = null;
var discuz_uid = isUndefined(discuz_uid) ? 0 : discuz_uid;
var creditnotice = isUndefined(creditnotice) ? '' : creditnotice;
var cookiedomain = isUndefined(cookiedomain) ? '' : cookiedomain;
var cookiepath = isUndefined(cookiepath) ? '' : cookiepath;

if(BROWSER.firefox && window.HTMLElement) {
    HTMLElement.prototype.__defineSetter__('outerHTML', function(sHTML) {
        var r = this.ownerDocument.createRange();
        r.setStartBefore(this);
        var df = r.createContextualFragment(sHTML);
        this.parentNode.replaceChild(df,this);
        return sHTML;
    });

    HTMLElement.prototype.__defineGetter__('outerHTML', function() {
        var attr;
        var attrs = this.attributes;
        var str = '<' + this.tagName.toLowerCase();
        for(var i = 0;i < attrs.length;i++){
            attr = attrs[i];
            if(attr.specified)
                str += ' ' + attr.name + '="' + attr.value + '"';
        }
        if(!this.canHaveChildren) {
            return str + '>';
        }
        return str + '>' + this.innerHTML + '</' + this.tagName.toLowerCase() + '>';
    });

    HTMLElement.prototype.__defineGetter__('canHaveChildren', function() {
        switch(this.tagName.toLowerCase()) {
            case 'area':case 'base':case 'basefont':case 'col':case 'frame':case 'hr':case 'img':case 'br':case 'input':case 'isindex':case 'link':case 'meta':case 'param':
                return false;
        }
        return true;
    });
    HTMLElement.prototype.click = function(){
        var evt = this.ownerDocument.createEvent('MouseEvents');
        evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
        this.dispatchEvent(evt);
    };
}

function $$obj(id){
    return document.getElementById(id);
}

function display(id) {
    $$obj(id).style.display = $$obj(id).style.display == '' ? 'none' : '';
}

function isUndefined(variable) {
    return typeof variable == 'undefined' ? true : false;
}

function in_array(needle, haystack) {
    if(typeof needle == 'string' || typeof needle == 'number') {
        for(var i in haystack) {
            if(haystack[i] == needle) {
                return true;
            }
        }
    }
    return false;
}

function showMenu(v) {
    var ctrlid = isUndefined(v['ctrlid']) ? v : v['ctrlid'];
    var showid = isUndefined(v['showid']) ? ctrlid : v['showid'];
    var menuid = isUndefined(v['menuid']) ? showid + '_menu' : v['menuid'];
    var ctrlObj = $$obj(ctrlid);
    var menuObj = $$obj(menuid);
    if(!menuObj) return;
    var mtype = isUndefined(v['mtype']) ? 'menu' : v['mtype'];
    var evt = isUndefined(v['evt']) ? 'mouseover' : v['evt'];
    var pos = isUndefined(v['pos']) ? '43' : v['pos'];
    var layer = isUndefined(v['layer']) ? 1 : v['layer'];
    var duration = isUndefined(v['duration']) ? 2 : v['duration'];
    var timeout = isUndefined(v['timeout']) ? 250 : v['timeout'];
    var maxh = isUndefined(v['maxh']) ? 500 : v['maxh'];
    var cache = isUndefined(v['cache']) ? 1 : v['cache'];
    var drag = isUndefined(v['drag']) ? '' : v['drag'];
    var dragobj = drag && $$obj(drag) ? $$obj(drag) : menuObj;
    var fade = isUndefined(v['fade']) ? 0 : v['fade'];
    var cover = isUndefined(v['cover']) ? 0 : v['cover'];
    var zindex = isUndefined(v['zindex']) ? JSMENU['zIndex']['menu'] : v['zindex'];
    if(typeof JSMENU['active'][layer] == 'undefined') {
        JSMENU['active'][layer] = [];
    }

    if(evt == 'click' && in_array(menuid, JSMENU['active'][layer]) && mtype != 'win') {
        hideMenu(menuid, mtype);
        return;
    }
    if(mtype == 'menu') {
        hideMenu(layer, mtype);
    }

    if(ctrlObj) {
        if(!ctrlObj.initialized) {
            ctrlObj.initialized = true;
            ctrlObj.unselectable = true;

            ctrlObj.outfunc = typeof ctrlObj.onmouseout == 'function' ? ctrlObj.onmouseout : null;
            ctrlObj.onmouseout = function() {
                if(this.outfunc) this.outfunc();
                if(duration < 3 && !JSMENU['timer'][menuid]) JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
            };

            ctrlObj.overfunc = typeof ctrlObj.onmouseover == 'function' ? ctrlObj.onmouseover : null;
            ctrlObj.onmouseover = function(e) {
                doane(e);
                if(this.overfunc) this.overfunc();
                if(evt == 'click') {
                    clearTimeout(JSMENU['timer'][menuid]);
                    JSMENU['timer'][menuid] = null;
                } else {
                    for(var i in JSMENU['timer']) {
                        if(JSMENU['timer'][i]) {
                            clearTimeout(JSMENU['timer'][i]);
                            JSMENU['timer'][i] = null;
                        }
                    }
                }
            };
        }
    }


    if(!menuObj.initialized) {
        menuObj.initialized = true;
        menuObj.ctrlkey = ctrlid;
        menuObj.mtype = mtype;
        menuObj.layer = layer;
        menuObj.cover = cover;
        if(ctrlObj && ctrlObj.getAttribute('fwin')) {
            menuObj.scrolly = true;
        }
        menuObj.style.position = 'absolute';
        menuObj.style.zIndex = zindex + layer;
        menuObj.onclick = function(e) {
            if(!e || BROWSER.ie) {
                window.event.cancelBubble = true;
                return window.event;
            } else {
                e.stopPropagation();
                return e;
            }
        };
        if(duration < 3) {
            if(duration > 1) {
                menuObj.onmouseover = function() {
                    clearTimeout(JSMENU['timer'][menuid]);
                    JSMENU['timer'][menuid] = null;
                };
            }
            if(duration != 1) {
                menuObj.onmouseout = function() {
                    JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
                };
            }
        }
        if(drag) {
            dragobj.style.cursor = 'move';
            dragobj.onmousedown = function(event) {
                try{
                    dragMenu(menuObj, event, 1);
                }catch(e){}
            };
        }
        if(cover) {
            var coverObj = document.createElement('div');
            coverObj.id = menuid + '_cover';
            coverObj.style.position = 'absolute';
            coverObj.style.zIndex = menuObj.style.zIndex - 1;
            coverObj.style.left = coverObj.style.top = '0px';
            coverObj.style.width = '100%';
            coverObj.style.height = document.body.scrollHeight + 'px';
            coverObj.style.backgroundColor = '#000';
            coverObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=50)';
            coverObj.style.opacity = 0.5;
            $$obj('append_parent').appendChild(coverObj);
        }
    }
    menuObj.style.display = '';
    if(cover) $$obj(menuid + '_cover').style.display = '';
    if(fade) {
        var O = 0;
        var fadeIn = function(O) {
            if(O == 100) {
                clearTimeout(fadeInTimer);
                return;
            }
            menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
            menuObj.style.opacity = O / 100;
            O += 10;
            var fadeInTimer = setTimeout(function () {
                fadeIn(O);
            }, 50);
        };
        fadeIn(O);
        menuObj.fade = true;
    } else {
        menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=100)';
        menuObj.style.opacity = 1;
        menuObj.fade = false;
    }
    setMenuPosition(showid, menuid, pos);
    if(maxh && menuObj.scrollHeight > maxh) {
        menuObj.style.height = maxh + 'px';
        if(BROWSER.opera) {
            menuObj.style.overflow = 'auto';
        } else {
            menuObj.style.overflowY = 'auto';
        }
    }

    if(!duration) {
        setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
    }

    if(!in_array(menuid, JSMENU['active'][layer])) JSMENU['active'][layer].push(menuid);
    menuObj.cache = cache;
    if(layer > JSMENU['layer']) {
        JSMENU['layer'] = layer;
    }
}

function setMenuPosition(showid, menuid, pos) {
    var showObj = $$obj(showid);
    var menuObj = menuid ? $$obj(menuid) : $$obj(showid + '_menu');
    if(isUndefined(pos)) pos = '43';
    var basePoint = parseInt(pos.substr(0, 1));
    var direction = parseInt(pos.substr(1, 1));
    var sxy = sx = sy = sw = sh = ml = mt = mw = mcw = mh = mch = bpl = bpt = 0;

    if(!menuObj || (basePoint > 0 && !showObj)) return;
    if(showObj) {
        sxy = fetchOffset(showObj);
        sx = sxy['left'];
        sy = sxy['top'];
        sw = showObj.offsetWidth;
        sh = showObj.offsetHeight;
    }
    mw = menuObj.offsetWidth;
    mcw = menuObj.clientWidth;
    mh = menuObj.offsetHeight;
    mch = menuObj.clientHeight;

    switch(basePoint) {
        case 1:
            bpl = sx;
            bpt = sy;
            break;
        case 2:
            bpl = sx + sw;
            bpt = sy;
            break;
        case 3:
            bpl = sx + sw;
            bpt = sy + sh;
            break;
        case 4:
            bpl = sx;
            bpt = sy + sh;
            break;
    }
    switch(direction) {
        case 0:
            menuObj.style.left = (document.body.clientWidth - menuObj.clientWidth) / 2 + 'px';
            mt = (document.documentElement.clientHeight - menuObj.clientHeight) / 2;
            break;
        case 1:
            ml = bpl - mw;
            mt = bpt - mh;
            break;
        case 2:
            ml = bpl;
            mt = bpt - mh;
            break;
        case 3:
            ml = bpl;
            mt = bpt;
            break;
        case 4:
            ml = bpl - mw;
            mt = bpt;
            break;
    }
    if(in_array(direction, [1, 4]) && ml < 0) {
        ml = bpl;
        if(in_array(basePoint, [1, 4])) ml += sw;
    } else if(ml + mw > document.documentElement.scrollLeft + document.body.clientWidth && sx >= mw) {
        ml = bpl - mw;
        if(in_array(basePoint, [2, 3])) ml -= sw;
    }
    if(in_array(direction, [1, 2]) && mt < 0) {
        mt = bpt;
        if(in_array(basePoint, [1, 2])) mt += sh;
    } else if(mt + mh > document.documentElement.scrollTop + document.documentElement.clientHeight && sy >= mh) {
        mt = bpt - mh;
        if(in_array(basePoint, [3, 4])) mt -= sh;
    }
    if(pos == '210') {
        ml += 69 - sw / 2;
        mt -= 5;
        if(showObj.tagName == 'TEXTAREA') {
            ml -= sw / 2;
            mt += sh / 2;
        }
    }
    if(direction == 0 || menuObj.scrolly) {
        if(BROWSER.ie && BROWSER.ie < 7) {
            if(direction == 0) mt += Math.max(document.documentElement.scrollTop, document.body.scrollTop);
        } else {
            if(menuObj.scrolly) mt -= Math.max(document.documentElement.scrollTop, document.body.scrollTop);
            menuObj.style.position = 'fixed';
        }
    }
    if(ml) menuObj.style.left = ml + 'px';
    if(mt) menuObj.style.top = mt + 'px';
    if(direction == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
        menuObj.style.position = 'absolute';
        menuObj.style.top = (document.body.clientHeight - menuObj.clientHeight) / 2 + 'px';
    }
    if(menuObj.style.clip && !BROWSER.opera) {
        menuObj.style.clip = 'rect(auto, auto, auto, auto)';
    }
}

function hideMenu(attr, mtype) {
    attr = isUndefined(attr) ? '' : attr;
    mtype = isUndefined(mtype) ? 'menu' : mtype;
    if(attr == '') {
        for(var i = 1; i <= JSMENU['layer']; i++) {
            hideMenu(i, mtype);
        }
        return;
    } else if(typeof attr == 'number') {
        for(var j in JSMENU['active'][attr]) {
            hideMenu(JSMENU['active'][attr][j], mtype);
        }
        return;
    } else if(typeof attr == 'string') {
        var menuObj = $$obj(attr);
        if(!menuObj || (mtype && menuObj.mtype != mtype)) return;
        clearTimeout(JSMENU['timer'][attr]);
        var hide = function() {
            if(menuObj.cache) {
                menuObj.style.display = 'none';
                if(menuObj.cover) $$obj(attr + '_cover').style.display = 'none';
            } else {
                menuObj.parentNode.removeChild(menuObj);
                if(menuObj.cover) $$obj(attr + '_cover').parentNode.removeChild($$obj(attr + '_cover'));
            }
            var tmp = [];
            for(var k in JSMENU['active'][menuObj.layer]) {
                if(attr != JSMENU['active'][menuObj.layer][k]) tmp.push(JSMENU['active'][menuObj.layer][k]);
            }
            JSMENU['active'][menuObj.layer] = tmp;
        };
        if(menuObj.fade) {
            var O = 100;
            var fadeOut = function(O) {
                if(O == 0) {
                    clearTimeout(fadeOutTimer);
                    hide();
                    return;
                }
                menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
                menuObj.style.opacity = O / 100;
                O -= 10;
                var fadeOutTimer = setTimeout(function () {
                    fadeOut(O);
                }, 50);
            };
            fadeOut(O);
        } else {
            hide();
        }
    }
}

//弹出积分窗口
function showPrompt(msg, timeout) {
    var menuid = 'ntcwin';
    var duration = timeout ? 0 : 3;
    var div = document.createElement('div');
    div.id = menuid;
    div.className = 'ntcwin';
    div.style.display = 'none';
    $$obj('append_parent').appendChild(div);
    msg = '<span style="font-style: normal;">' + msg + '</span>';
    msg = '<table cellspacing="0" cellpadding="0" class="popupcredit"><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div class="pc_inner">' + msg +
    '</td><td class="pc_r">&nbsp;</td></tr></table>';
    div.innerHTML = msg;
    showMenu({
        'mtype':'prompt',
        'pos':'00',
        'menuid':menuid,
        'duration':duration,
        'timeout':timeout,
        'fade':1,
        'zindex':JSMENU['zIndex']['prompt']
    });

}