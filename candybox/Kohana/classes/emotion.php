<?php

defined('SYSPATH') or die('No direct script access.');

class Emotion extends Kohana_Text {

    public static function autoToUrl($str, $absolutePath = false) {
        $all = array(
            '微笑' => 'emotion/qq/01.gif',
            '撇嘴' => 'emotion/qq/02.gif',
            '色' => 'emotion/qq/03.gif',
            '发呆' => 'emotion/qq/04.gif',
            '得意' => 'emotion/qq/05.gif',
            '流泪' => 'emotion/qq/06.gif',
            '害羞' => 'emotion/qq/07.gif',
            '闭嘴' => 'emotion/qq/08.gif',
            '睡觉' => 'emotion/qq/09.gif',
            '大哭' => 'emotion/qq/10.gif',
            '尴尬' => 'emotion/qq/11.gif',
            '发怒' => 'emotion/qq/12.gif',
            '调皮' => 'emotion/qq/13.gif',
            '呲牙' => 'emotion/qq/14.gif',
            '惊讶' => 'emotion/qq/15.gif',
            '难过' => 'emotion/qq/16.gif',
            '酷' => 'emotion/qq/17.gif',
            '冷汗' => 'emotion/qq/18.gif',
            '抓狂' => 'emotion/qq/19.gif',
            '呕吐' => 'emotion/qq/20.gif',
            '偷笑' => 'emotion/qq/21.gif',
            '可爱' => 'emotion/qq/22.gif',
            '白眼' => 'emotion/qq/23.gif',
            '傲慢' => 'emotion/qq/24.gif',
            '饥饿' => 'emotion/qq/25.gif',
            '瞌睡' => 'emotion/qq/26.gif',
            '惊恐' => 'emotion/qq/27.gif',
            '流汗' => 'emotion/qq/28.gif',
            '憨笑' => 'emotion/qq/29.gif',
            '大兵' => 'emotion/qq/30.gif',
            '奋斗' => 'emotion/qq/31.gif',
            '咒骂' => 'emotion/qq/32.gif',
            '疑问' => 'emotion/qq/33.gif',
            '嘘' => 'emotion/qq/34.gif',
            '晕' => 'emotion/qq/35.gif',
            '抓狂' => 'emotion/qq/36.gif',
            '衰' => 'emotion/qq/37.gif',
            '骷髅' => 'emotion/qq/38.gif',
            '敲打' => 'emotion/qq/39.gif',
            '再见' => 'emotion/qq/40.gif',
            '擦汗' => 'emotion/qq/41.gif',
            '口鼻' => 'emotion/qq/42.gif',
            '鼓掌' => 'emotion/qq/43.gif',
            '糗大了' => 'emotion/qq/44.gif',
            '坏笑' => 'emotion/qq/45.gif',
            '左哼哼' => 'emotion/qq/46.gif',
            '右哼哼' => 'emotion/qq/47.gif',
            '哈欠' => 'emotion/qq/48.gif',
            '鄙视' => 'emotion/qq/49.gif',
            '委屈' => 'emotion/qq/50.gif',
            '快哭了' => 'emotion/qq/51.gif',
            '阴险' => 'emotion/qq/52.gif',
            '亲亲' => 'emotion/qq/53.gif',
            '吓' => 'emotion/qq/54.gif',
            '可怜' => 'emotion/qq/55.gif',
            '菜刀' => 'emotion/qq/56.gif',
            '西瓜' => 'emotion/qq/57.gif',
            '啤酒' => 'emotion/qq/58.gif',
            '篮球' => 'emotion/qq/59.gif',
            '乒乓球' => 'emotion/qq/60.gif',
            '咖啡' => 'emotion/qq/61.gif',
            '米饭' => 'emotion/qq/62.gif',
            '猪头' => 'emotion/qq/63.gif',
            '玫瑰' => 'emotion/qq/64.gif',
            '凋零' => 'emotion/qq/65.gif',
            '献吻' => 'emotion/qq/66.gif',
            '爱心' => 'emotion/qq/67.gif',
            '心碎' => 'emotion/qq/68.gif',
            '蛋糕' => 'emotion/qq/69.gif',
            '闪电' => 'emotion/qq/70.gif',
            '炸弹' => 'emotion/qq/71.gif',
            '刀' => 'emotion/qq/72.gif',
            '足球' => 'emotion/qq/73.gif',
            '瓢虫' => 'emotion/qq/74.gif',
            '便便' => 'emotion/qq/75.gif',
            '月亮' => 'emotion/qq/76.gif',
            '太阳' => 'emotion/qq/77.gif',
            '拥抱' => 'emotion/qq/79.gif',
            '礼物' => 'emotion/qq/78.gif',
            '强' => 'emotion/qq/80.gif',
            '弱' => 'emotion/qq/81.gif',
            '胜利' => 'emotion/qq/83.gif',
            'OK' => 'emotion/qq/90.gif',
            '握手' => 'emotion/qq/82.gif',
            '抱拳' => 'emotion/qq/84.gif',
            '拳头' => 'emotion/qq/86.gif',
            '爱你' => 'emotion/qq/88.gif',
            'NO' => 'emotion/qq/89.gif',
            '转发' => 'emotion/lxh/01.gif',
            '笑哈哈' => 'emotion/lxh/02.gif',
            '得意地笑' => 'emotion/lxh/03.gif',
            '噢耶' => 'emotion/lxh/04.gif',
            '偷乐' => 'emotion/lxh/05.gif',
            '泪流满面' => 'emotion/lxh/06.gif',
            '巨汗' => 'emotion/lxh/07.gif',
            '抠鼻屎' => 'emotion/lxh/08.gif',
            '求关注' => 'emotion/lxh/09.gif',
            '真V5' => 'emotion/lxh/10.gif',
            '群体围观' => 'emotion/lxh/11.gif',
            'hold住' => 'emotion/lxh/12.gif',
            '羞嗒嗒' => 'emotion/lxh/13.gif',
            '非常汗' => 'emotion/lxh/14.gif',
            '许愿' => 'emotion/lxh/15.gif',
            '崩溃' => 'emotion/lxh/16.gif',
            '好囧' => 'emotion/lxh/17.gif',
            '震惊' => 'emotion/lxh/18.gif',
            '别烦我' => 'emotion/lxh/19.gif',
            '不好意思' => 'emotion/lxh/20.gif',
            '纠结' => 'emotion/lxh/21.gif',
            '拍手' => 'emotion/lxh/22.gif',
            '给劲' => 'emotion/lxh/23.gif',
            '好喜欢' => 'emotion/lxh/24.gif',
            '好爱哦' => 'emotion/lxh/25.gif',
            '路过这儿' => 'emotion/lxh/26.gif',
            '悲催' => 'emotion/lxh/27.gif',
            '不想上班' => 'emotion/lxh/28.gif',
            '躁狂症' => 'emotion/lxh/29.gif',
            '甩甩手' => 'emotion/lxh/30.gif',
            '瞧瞧' => 'emotion/lxh/31.gif',
            '同意' => 'emotion/lxh/32.gif',
            '喝多了' => 'emotion/lxh/33.gif',
            '啦啦啦啦' => 'emotion/lxh/34.gif',
            '杰克逊' => 'emotion/lxh/35.gif',
            '雷锋' => 'emotion/lxh/36.gif',
            '传火炬' => 'emotion/lxh/37.gif',
            '加油啊' => 'emotion/lxh/38.gif',
            '亲一口' => 'emotion/lxh/39.gif',
            '放假啦' => 'emotion/lxh/40.gif',
            '立志青年' => 'emotion/lxh/41.gif',
            '下班' => 'emotion/lxh/42.gif',
            '困死了' => 'emotion/lxh/43.gif',
            '好棒' => 'emotion/lxh/44.gif',
            '有鸭梨' => 'emotion/lxh/45.gif',
            '膜拜了' => 'emotion/lxh/46.gif',
            '互相膜拜' => 'emotion/lxh/47.gif',
            '拍砖' => 'emotion/lxh/48.gif',
            '互相拍砖' => 'emotion/lxh/49.gif',
            '想一想' => 'emotion/lxh/50.gif',
            '中箭' => 'emotion/lxh/51.gif',
            '推荐' => 'emotion/lxh/52.gif',
            '赞啊' => 'emotion/lxh/53.gif',
            '摁倒' => 'emotion/tsj/t_0001.gif',
            '送爱心' => 'emotion/tsj/t_0002.gif',
            '耶' => 'emotion/tsj/t_0003.gif',
            '啊' => 'emotion/tsj/t_0004.gif',
            '背扭' => 'emotion/tsj/t_0005.gif',
            '顶' => 'emotion/tsj/t_0006.gif',
            '抖胸' => 'emotion/tsj/t_0007.gif',
            '拜拜' => 'emotion/tsj/t_0008.gif',
            '汗' => 'emotion/tsj/t_0009.gif',
            '瞌睡' => 'emotion/tsj/t_0010.gif',
            '鲁拉' => 'emotion/tsj/t_0011.gif',
            '拍砖' => 'emotion/tsj/t_0012.gif',
            '揉脸' => 'emotion/tsj/t_0013.gif',
            '生日快乐' => 'emotion/tsj/t_0014.gif',
            '摊手' => 'emotion/tsj/t_0015.gif',
            '睡觉' => 'emotion/tsj/t_0016.gif',
            '瘫坐' => 'emotion/tsj/t_0017.gif',
            '无聊' => 'emotion/tsj/t_0018.gif',
            '星星闪' => 'emotion/tsj/t_0019.gif',
            '旋转' => 'emotion/tsj/t_0020.gif',
            '也不行' => 'emotion/tsj/t_0021.gif',
            '郁闷' => 'emotion/tsj/t_0022.gif',
            '听歌' => 'emotion/tsj/t_0023.gif',
            '抓墙' => 'emotion/tsj/t_0024.gif',
            '撞墙至死' => 'emotion/tsj/t_0025.gif',
            '歪头' => 'emotion/tsj/t_0026.gif',
            '戳眼' => 'emotion/tsj/t_0027.gif',
            '飘过' => 'emotion/tsj/t_0028.gif',
            '互相拍砖' => 'emotion/tsj/t_0029.gif',
            '砍死你' => 'emotion/tsj/t_0030.gif',
            '扔桌子' => 'emotion/tsj/t_0031.gif',
            '少林寺' => 'emotion/tsj/t_0032.gif',
            '干什么' => 'emotion/tsj/t_0033.gif',
            '转头' => 'emotion/tsj/t_0034.gif',
            '我爱牛奶' => 'emotion/tsj/t_0035.gif',
            '我踢' => 'emotion/tsj/t_0036.gif',
            '摇晃' => 'emotion/tsj/t_0037.gif',
            '晕厥' => 'emotion/tsj/t_0038.gif',
            '在笼子里' => 'emotion/tsj/t_0039.gif',
            '震荡' => 'emotion/tsj/t_0040.gif',
        );
        $pattern = "/\[(.*)\]/U";
        $imgPath = $absolutePath ? 'http://zuaa.zju.edu.cn/static/images/' : '/static/images/';
        if (preg_match($pattern, $str)) {
            preg_match_all($pattern, $str, $imgArray);
            foreach ($imgArray[1] AS $emt) {
                if (isset($all[$emt])) {
                    $str = str_replace('[' . $emt . ']', '<span class="emotion"><img src="' . $imgPath . $all[$emt] . '" ></span>', $str);
                }
            }
            return $str;
        } else {
            return $str;
        }
    }

}

?>