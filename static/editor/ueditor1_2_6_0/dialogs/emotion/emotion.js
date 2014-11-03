function initImgBox(box, str, len) {
    if (box.length)return;
    var tmpStr = "",i = 1;
    for (; i <= len; i++) {
        tmpStr = str;
        if (i < 10)tmpStr = tmpStr + '0';
        tmpStr = tmpStr + i + '.gif';
        box.push(tmpStr);
    }
}
function $G(id) {
    return document.getElementById(id)
}


function InsertSmiley(url) {
    var obj = {
        src:editor.options.emotionLocalization ? editor.options.UEDITOR_HOME_URL + "dialogs/emotion/" + url : url
    };
    obj.data_ue_src = obj.src;
    editor.execCommand('insertimage', obj);
    dialog.popup.hide();
}

function InsertSmileyStr(str) {
    editor.execCommand("insertHTML","["+str+"]");
    dialog.popup.hide();
}

function over(td, srcPath, posFlag) {
    td.style.backgroundColor = "#D6F5D6";
    $G('faceReview').style.backgroundImage = "url(" + srcPath + ")";
    if (posFlag == 1) $G("tabIconReview").className = "show";
    $G("tabIconReview").style.display = 'block';
}
function out(td) {
    td.style.backgroundColor = "#FFFFFF";
    var tabIconRevew = $G("tabIconReview");
    tabIconRevew.className = "";
    tabIconRevew.style.display = 'none';
}
var emotion = {};
emotion.SmileyPath = editor.options.emotionLocalization ? 'images/' : "http://img.baidu.com/hi/";
emotion.SmileyBox = {tab0:[],tab1:[],tab2:[],tab3:[],tab4:[],tab5:[],tab6:[]};
emotion.SmileyInfor = {tab0:[],tab1:[],tab2:[],tab3:[],tab4:[],tab5:[],tab6:[]};
var faceBox = emotion.SmileyBox;
var inforBox = emotion.SmileyInfor;
var sBasePath = emotion.SmileyPath;
if (editor.options.emotionLocalization) {
    initImgBox(faceBox['tab0'], '', 88);
    initImgBox(faceBox['tab1'], '', 53);
    initImgBox(faceBox['tab2'], 't_00', 39);

} else {
    initImgBox(faceBox['tab0'], '', 88);
    initImgBox(faceBox['tab1'], '', 53);
    initImgBox(faceBox['tab2'], 't_00', 39);
}


inforBox['tab0'] = ['微笑','撇嘴','色','发呆','得意','流泪','害羞','闭嘴','睡觉','大哭','尴尬','发怒','调皮','呲牙','惊讶','难过','酷','冷汗','抓狂','呕吐','偷笑','可爱','白眼','傲慢','饥饿','瞌睡','惊恐','流汗','憨笑','大兵','奋斗','咒骂','疑问','嘘','晕','抓狂','衰','骷髅','敲打','再见','擦汗','口鼻','鼓掌','糗大了','坏笑','左哼哼','右哼哼','哈欠','鄙视','委屈','快哭了','阴险','亲亲','吓','可怜','菜刀','西瓜','啤酒','篮球','乒乓球','咖啡','米饭','猪头','玫瑰','凋零','献吻','爱心','心碎','蛋糕','闪电','炸弹','刀','足球','瓢虫','便便','月亮','太阳','拥抱','礼物','强','弱','胜利','OK','握手','抱拳','拳头','爱你','NO'];
inforBox['tab1'] = ['转发','笑哈哈','得意地笑','噢耶','偷乐','泪流满面','巨汗','抠鼻屎','求关注','真V5','群体围观','hold住','羞嗒嗒','非常汗','许愿','崩溃','好囧','震惊','别烦我','不好意思','纠结','拍手','给劲','好喜欢','好爱哦','路过这儿','悲催','不想上班','躁狂症','甩甩手','瞧瞧','同意','喝多了','啦啦啦啦','杰克逊','雷锋','传火炬','加油啊','亲一口','放假啦','立志青年','下班','困死了','好棒','有鸭梨','膜拜了','互相膜拜','拍砖','互相拍砖','想一想','中箭','推荐','赞啊'];
inforBox['tab2'] = ['摁倒','送爱心','耶','啊','背扭','顶','抖胸','拜拜','汗','瞌睡','鲁拉','拍砖','揉脸','生日快乐','摊手','睡觉','瘫坐','无聊','星星闪','旋转','也不行','郁闷','听歌','抓墙','撞墙至死','歪头','戳眼','飘过','互相拍砖','砍死你','扔桌子','少林寺','干什么','转头','我爱牛奶','我踢','摇晃','晕厥','在笼子里','震荡'];
//inforBox['langxiaohua'] = ['大笑','瀑布汗~','惊讶','臭美','傻笑','抛媚眼','发怒','我错了','money','气愤','挑逗','吻','怒','胜利','委屈','受伤','说啥呢？','闭嘴','不','逗你玩儿','飞吻','眩晕','魔法','我来了','睡了','我打','闭嘴','打','打晕了','刷牙','爆揍','炸弹','倒立','刮胡子','邪恶的笑','不要不要','爱恋中','放大仔细看','偷窥','超高兴','晕','松口气','我跑','享受','修养','哭','汗','啊~','热烈欢迎','打酱油','俯卧撑','?'];
//inforBox['tab3'] = ['HI','KISS','不说','不要','扯花','大心','顶','大惊','飞吻','鬼脸','害羞','口水','狂哭','来','泪眼','流泪','生气','吐舌','喜欢','旋转','再见','抓狂','汗','鄙视','拜','吐血','嘘','打人','蹦跳','变脸','扯肉','吃To','吃花','吹泡泡糖','大变身','飞天舞','回眸','可怜','猛抽','泡泡','苹果','亲','','骚舞','烧香','睡','套娃娃','捅捅','舞倒','西红柿','爱慕','摇','摇摆','杂耍','招财','被殴','被球闷','大惊','理想','欧打','呕吐','碎','吐痰'];
//inforBox['tab4'] = ['发财了', '吃西瓜', '套牢', '害羞', '庆祝', '我来了', '敲打', '晕了', '胜利', '臭美', '被打了', '贪吃', '迎接', '酷', '顶', '幸运', '爱心', '躲', '送花', '选择'];

//大对象
FaceHandler = {
    imageFolders:{tab0:'qq/',tab1:'lxh/',tab2:'tsj/'},
    imageWidth:{tab0:35,tab1:35,tab2:35},
    imageCols:{tab0:11,tab1:11,tab2:11},
    imageColWidth:{tab0:3,tab1:3,tab2:3},
    imageCss:{tab0:'qq',tab1:'lxh',tab2:'tsj'},
    imageCssOffset:{tab0:35,tab1:35,tab2:35},
    tabExist:[0,0,0]
};
function switchTab(index) {
    if (FaceHandler.tabExist[index] == 0) {
        FaceHandler.tabExist[index] = 1;
        createTab('tab' + index);
    }
    //获取呈现元素句柄数组
    var tabMenu = $G("tabMenu").getElementsByTagName("div"),
        tabContent = $G("tabContent").getElementsByTagName("div"),
        i = 0,L = tabMenu.length;
    //隐藏所有呈现元素
    for (; i < L; i++) {
        tabMenu[i].className = "";
        tabContent[i].style.display = "none";
    }
    //显示对应呈现元素
    tabMenu[index].className = "on";
    tabContent[index].style.display = "block";
}
function createTab(tabName) {
    var faceVersion = "?v=1.2",//版本号
        tab = $G(tabName),//获取将要生成的Div句柄
        imagePath = sBasePath + FaceHandler.imageFolders[tabName],//获取显示表情和预览表情的路径
        imageColsNum = FaceHandler.imageCols[tabName],//每行显示的表情个数
        positionLine = imageColsNum / 2,//中间数
        iWidth = iHeight = FaceHandler.imageWidth[tabName],//图片长宽
        iColWidth = FaceHandler.imageColWidth[tabName],//表格剩余空间的显示比例
        tableCss = FaceHandler.imageCss[tabName],
        cssOffset = FaceHandler.imageCssOffset[tabName],
        textHTML = ['<table class="smileytable" cellpadding="1" cellspacing="0" align="center" style="border-collapse:collapse;" border="1" bordercolor="#BAC498" width="100%">'],
        i = 0,imgNum = faceBox[tabName].length,imgColNum = FaceHandler.imageCols[tabName],faceImage,
        sUrl,realUrl,posflag,offset,infor;
    for (; i < imgNum;) {
        textHTML.push('<tr>');
        for (var j = 0; j < imgColNum; j++,i++) {
            faceImage = faceBox[tabName][i];
            if (faceImage) {
                sUrl = imagePath + faceImage + faceVersion;
                realUrl = imagePath + faceImage;
                posflag = j < positionLine ? 0 : 1;
                offset = cssOffset * i * (-1) - 1;
                infor = inforBox[tabName][i];
                textHTML.push('<td  class="' + tableCss + '"   border="1" width="' + iColWidth + '%" style="border-collapse:collapse;" align="center"  bgcolor="#FFFFFF"  onclick="InsertSmileyStr(\'' + infor+ '\')" onclick_="InsertSmiley(\'' + realUrl.replace(/'/g, "\\'") + '\')" onmouseover="over(this,\'' + sUrl + '\',\'' + posflag + '\')" onmouseout="out(this)">');
                textHTML.push('<span  style="display:block;">');
                textHTML.push('<img  style="background-position:left ' + offset + 'px;" title="' + infor + '" src="' + sBasePath + (editor.options.emotionLocalization ? '0.gif" width="' : 'default/0.gif" width="') + iWidth + '" height="' + iHeight + '"></span>');
                textHTML.push('</span>');
            } else {
                textHTML.push('<td width="' + iColWidth + '%"   bgcolor="#FFFFFF">');
            }
            textHTML.push('</td>');
        }
        textHTML.push('</tr>');
    }
    textHTML.push('</table>');
    textHTML = textHTML.join("");
    tab.innerHTML = textHTML;
}
var tabIndex = 0;//getDialogInstance()?(getDialogInstance().smileyTabId?getDialogInstance().smileyTabId:0):0;
switchTab(tabIndex);
$G("tabIconReview").style.display = 'none';