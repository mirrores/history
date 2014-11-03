<?php

//微信开发者接口
class Controller_Api_Weixin extends Layout_Main {

    //指定校友会
    private $_aid;
    //来源微信帐号
    private $FromUserName;
    //返回用的xml数据
    private $backData;
    //消息类型
    private $msgType;
    private static $help_keyword = array('?', '？', '？', '帮助', 'h', 'help');
    private static $event_keyword = array('1', '活动');
    private static $bbs_keyword = array('2', '话题');
    public $_siteurl;

    //初始化和分配处理
    function before() {

        parent::before();

        $this->auto_render = false;

        $this->_siteurl = 'http://' . $_SERVER['HTTP_HOST'];

        //没有接收到信息时进行测试------------------------------
        if (!isset($GLOBALS['HTTP_RAW_POST_DATA']) OR empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
            $msgType = Arr::get($_GET, 'msgType');
            $GLOBALS['HTTP_RAW_POST_DATA'] = $this->getTestXml($msgType);
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        }

        //是否来源微信验证
        if (!$this->checkSignature()) {
            //exit;
        }

        $this->_aid = isset($_GET['aid']) && is_numeric($_GET['aid']) ? $_GET['aid'] : false;

        //--------------------------------模拟数据结束
        //替换一下数据后返回给微信服务器
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $xmlObject = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlObject = (array) $xmlObject;

        //消息类型
        $this->msgType = isset($xmlObject['MsgType']) ? trim($xmlObject['MsgType']) : 'text';

        //最终返回给微信服务器公用信息
        $this->FromUserName = isset($xmlObject['FromUserName']) ? trim($xmlObject['FromUserName']) : null;
        $this->backData['FromUserName'] = isset($xmlObject['ToUserName']) ? trim($xmlObject['ToUserName']) : null;
        $this->backData['ToUserName'] = $this->FromUserName;
        $this->backData['CreateTime'] = time();
        $this->backData['FuncFlag'] = 0;
        //默认返回消息类型
        $this->backData['MsgType'] = 'text';

        //开始处理文本类型
        if ($this->msgType == 'text') {
            $keyword = isset($xmlObject['Content']) ? trim($xmlObject['Content']) : null;
            $this->textMsg($keyword);
        }
        //开始处理图片消息类型
        elseif ($this->msgType == 'image') {
            $picUrl = isset($xmlObject['PicUrl']) ? trim($xmlObject['PicUrl']) : null;
            $this->imageMsg($picUrl);
        }
        //开始处理地址位置类型
        elseif ($this->msgType == 'location') {
            //地理位置纬度
            $Location_X = isset($xmlObject['Location_X']) ? trim($xmlObject['Location_X']) : null;
            //地理位置经度
            $Location_Y = isset($xmlObject['Location_Y']) ? trim($xmlObject['Location_Y']) : null;
            //地图缩放大小
            $Scale = isset($xmlObject['Scale']) ? trim($xmlObject['Scale']) : null;
            //地理位置信息
            $Label = isset($xmlObject['Label']) ? trim($xmlObject['Label']) : null;
            $this->locationMsg($Label, $Scale, $Location_X, $Location_Y);
        }
        //开始处理链接类型
        elseif ($this->msgType == 'link') {
            $Title = isset($xmlObject['Title']) ? trim($xmlObject['Title']) : null;
            $Description = isset($xmlObject['Description']) ? trim($xmlObject['Description']) : null;
            $Url = isset($xmlObject['Url']) ? trim($xmlObject['Url']) : null;
            $this->linkMsg($Title, $Description, $Url);
        }
        //开始处理事件消息
        elseif ($this->msgType == 'event') {
            //事件类型，subscribe(订阅)、unsubscribe(取消订阅)、CLICK(自定义菜单点击事件)
            $Event = isset($xmlObject['Event']) ? trim($xmlObject['Event']) : null;
            //事件KEY值，与自定义菜单接口中KEY值对应
            $EventKey = isset($xmlObject['EventKey']) ? trim($xmlObject['EventKey']) : null;
            $this->eventMsg($Event, $EventKey);
        }
        //发送来位置的信息类型
        else {
            //$this->responseText('');
        }
    }

    //微信来源验证(以get方式发送过来的)
    private function checkSignature() {
        /*
         * 加密/校验流程：
          1. 将token、timestamp、nonce三个参数进行字典序排序
          2. 将三个参数字符串拼接成一个字符串进行sha1加密
          3. 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
         */
        $token = 'zjuhz';
        //微信加密签名
        $signature = Arr::get($_GET, 'signature');
        //微信时间戳
        $timestamp = Arr::get($_GET, 'timestamp');
        //随机数
        $nonce = Arr::get($_GET, 'nonce');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    #应答入口

    function action_index() {

    }

    //文本消息处理
    function textMsg($keyword = null) {

        if ($keyword) {
            //首次关注后来自后台的推送
            if ($keyword == 'Hello2BizUser' OR $keyword == 'subscribe') {
                $this->eventMsg('subscribe');
            }
            //查询帮助命令
            elseif (in_array($keyword, self::$help_keyword)) {
                $this->help();
            }
            //最新活动
            elseif (in_array($keyword, self::$event_keyword)) {
                $this->event();
            }
            //话题
            elseif (in_array($keyword, self::$bbs_keyword)) {
                $this->bbs();
            }
            //绑定微信帐号
            elseif ($keyword == 'bind') {
                $this->bindweixin();
            }
            //测试签名验证
            elseif ($keyword == 'testyz') {
                if ($this->checkSignature()) {
                    $this->responseText('验证签名通过!');
                } else {
                    $this->responseText('没有通过签名验证!');
                }
            }
            //分页查看活动
            elseif (preg_match("/^1([1-9]+)$/i", $keyword, $matches)) {
                $this->event(array('page' => $matches[1]));
            }
            //我参加的相关活动
            elseif ($keyword == 's10') {
                $this->event(array('cat' => 'joined', 'page' => 1));
            } elseif (preg_match('/^s10([1-9]+)$/i', $keyword, $matches)) {
                $this->event(array('cat' => 'joined', 'page' => $matches[1]));
            }
            //关键字查询活动
            elseif (preg_match("/^1([\x{4e00}-\x{9fa5}A-Za-z0-9_]+)$/u", $keyword, $matches)) {
                $this->event(array('q' => $matches[1]));
            }
            //我发布的话题
            elseif ($keyword == 's20') {
                $this->bbs(array('list' => 'posted', 'page' => 1));
            } elseif (preg_match('/^s20([1-9]+)$/i', $keyword, $matches)) {
                $this->bbs(array('page' => $matches[1]));
            } elseif (preg_match("/^2([1-9]+)$/i", $keyword, $matches)) {
                $this->bbs(array('page' => $matches[1]));
            }
            //搜索话题
            elseif (preg_match("/^2([\x{4e00}-\x{9fa5}A-Za-z0-9_]+)$/u", $keyword, $matches)) {
                $this->bbs(array('q' => $matches[1]));
            }
            //站内信
            else {

            }
        }
    }

    //文本类型
    public function imageMsg($picUrl = null) {

    }

    //图片类型处理
    public function locationMsg($Label, $Scale, $Location_X, $Location_Y) {

    }

    //链接类型处理
    public function linkMsg($Title, $Description, $Url) {

    }

    //事件类型
    public function eventMsg($Event = null, $EventKey = null) {

        if ($Event == 'subscribe') {
            $articles[] = array(
                'Title' => '亲爱的浙大校友，欢迎回来！',
                'Url' => $this->weixinUrl('/mobile/help'),
                'PicUrl' => $this->weixinUrl('/static/weixinbanner/welcomeback.jpg'),
                'Description' => '这里是杭州浙大校友会微信平台，感谢您的关注，小助手微微同学在这里恭候您多时了:)，请回复“?”或直接点击以下“阅读全文”查看使用帮助，谢谢!'
            );
            $this->backData['Articles'] = $articles;
            $this->textImageTemplate($this->backData);
        }
    }

    //返回带校友会aid参数的链接地址,$url必须是/开始
    public function weixinUrl($url) {
        $and = strstr($url, '?') ? '&' : '?';
        $aid = is_numeric($this->_aid) ? $and . 'aid=' . $this->_aid : '';
        $siteurl = strstr($url, 'http') ? $url . $aid : $this->_siteurl . $url . $aid;
        return $siteurl;
    }

    //返回使用帮助
    function help() {
        $articles[] = array(
            'Title' => '杭州浙大校友会微信使用帮助',
            'Url' => $this->weixinUrl('/mobile/help'),
            'PicUrl' => $this->weixinUrl('/static/images/weixinhelp.jpg'),
            'Description' => '使用方法如下：
发送"?":查看使用帮助
发送"1":查看最近活动
发送"1页码":翻页查看活动，例如"12"查看第2页活动;
发送"1关键字":查找相关活动，例如"1金融"查找金融相关活动;
发送"2":查看最新话题'
        );

        $this->backData['Articles'] = $articles;
        $this->textImageTemplate($this->backData);
    }

    //返回活动列表
    public function event($con = array()) {

        $page = isset($con['page']) ? (int) $con['page'] : 1;
        $cat = isset($con['cat']) && $con['cat'] ? $con['cat'] : false;
        $q = isset($con['q']) && $con['q'] ? trim($con['q']) : false;

        if ($cat == 'joined' AND empty($this->_uid)) {
            $this->backData['Content'] = '您还没有登录，请登录后查询参加过的活动。';
            $this->textTemplate($this->backData);
        }

        $event = array();
        $etype = Kohana::config('icon.etype');
        //显示最新
        $con = array('aa_id' => $this->_aid, 'limit' => 5, 'page_size' => 5, 'page' => $page, 'q' => $q, 'uid' => $this->_uid, 'cat' => $cat);
        $event = Db_Event::getEvents($con);

        if ($event) {
            foreach ($event as $key => $e) {

                $event[$key]['id'] = Db_Event::replaceTitle($e['id']);
                $event[$key]['Title'] = Model_Event::SatusFinish2($e['start'], $e['finish']) . '
' . Db_Event::replaceTitle($e['title']);
                $event[$key]['Url'] = $this->weixinUrl('/mobile/eview?id=' . $e['id']);
                if ($e['type'] AND isset($etype['icons'][$e['type']])) {
                    $event[$key]['PicUrl'] = $this->_siteurl . $etype['url'] . $etype['icons'][$e['type']];
                } else {
                    $event[$key]['PicUrl'] = $this->_siteurl . $etype['url'] . 'undefined.png';
                }
                $event[$key]['Description'] = $e['title'];
            }

            //生成第一张文章普通和摘要
            $first_Article = Db_Event::getEventById($event[0]['id']);
            $htmlAndPics = Common_Global::standardHtmlAndPics($first_Article['content'], $first_Article['title'], true, false);
            $event[0]['Description'] = Text::limit_chars(strip_tags($htmlAndPics['html']), 150);
            $pics = $htmlAndPics['pics'];
            $event[0]['PicUrl'] = isset($pics[0]['bmiddle_pic']) ? $pics[0]['bmiddle_pic'] : $this->getClubBanner($event[0]['club_id']);
            $this->backData['Articles'] = $event;
            $this->textImageTemplate($this->backData);
        } else {
            $this->backData['Content'] = '很遗憾，暂时还没有活动信息';
            $this->textTemplate($this->backData);
        }
        exit;
    }

    //搜索话题
    public function bbs($con = array()) {
        $con['limit'] = 6;
        $con['page'] = isset($con['page']) ? (int) $con['page'] : 1;
        $con['cat'] = isset($con['cat']) && $con['cat'] ? $con['cat'] : false;
        $con['aa_id'] = $this->_aid;
        $con['q'] = isset($con['q']) && $con['q'] ? trim($con['q']) : false;
        $con['is_display_event'] = false;

        //置顶主题
        $units = Model_Bbs::getMobileList($con);

        //笨蛋整理
        $fixed = Model_bbs::createXmlArray($units['fixed']);
        $last = Model_bbs::createXmlArray($units['list']);

        $articles = array();
        //置顶话题1篇
        if ($fixed) {
            foreach ($fixed as $key => $u) {
                $articles[] = array(
                    'id' => Db_Event::replaceTitle($u['id']),
                    'Title' => Db_Event::replaceTitle($u['title']),
                    'Url' => $this->weixinUrl('/mobile/bbsview?id=' . $u['id']),
                    'PicUrl' => $u['user']['avatar_large'],
                    'Description' => $u['title']
                );
                continue;
            }
        }
        //普通话题n篇
        if ($last) {
            foreach ($last as $key => $u) {
                if (count($articles) >= 5) {
                    continue;
                }
                $articles[] = array(
                    'id' => Db_Event::replaceTitle($u['id']),
                    'Title' => $u['statuses'] . '
' . Db_Event::replaceTitle($u['title']),
                    'Url' => $this->weixinUrl('/mobile/bbsview?id=' . $u['id']),
                    'PicUrl' => $u['updater_avatar_large'],
                    'Description' => $u['title']
                );
            };
        }

        //没有内容
        if (!$articles) {
            $this->backData['Content'] = '暂时还没有任何话题:(';
            echo $this->textTemplate($this->backData);
        } else {
            //生成第一张文章普通和摘要
            $first_Article = Db_Bbs::getUnitBaseViewData($articles[0]['id']);
            $htmlAndPics = Common_Global::standardHtmlAndPics($first_Article['Post']['content'], $first_Article['title'], true, false);
            $articles[0]['Description'] = Text::limit_chars(strip_tags($htmlAndPics['html']), 150);
            $pics = $htmlAndPics['pics'];
            $articles[0]['PicUrl'] = isset($pics[0]['bmiddle_pic']) ? $pics[0]['bmiddle_pic'] : $this->_siteurl . '/static/images/weixinb2.jpg';
            $this->backData['Articles'] = $articles;
            $xml = $this->textImageTemplate($this->backData);
            echo $xml;
        }
        exit;
    }

    //文本模板
    public function textTemplate($xml) {
        echo '<xml>
<ToUserName><![CDATA[' . $xml['ToUserName'] . ']]></ToUserName>
<FromUserName><![CDATA[' . $xml['FromUserName'] . ']]></FromUserName>
<CreateTime>' . time() . '</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[' . $xml['Content'] . ']]></Content>
<FuncFlag>0</FuncFlag>
</xml>';
        exit;
    }

    //图文模板
    public function textImageTemplate($xml) {
        $str = '<xml>
 <ToUserName><![CDATA[' . $xml['ToUserName'] . ']]></ToUserName>
 <FromUserName><![CDATA[' . $xml['FromUserName'] . ']]></FromUserName>
 <CreateTime>' . time() . '</CreateTime>
 <MsgType><![CDATA[news]]></MsgType>
 <ArticleCount>' . count($xml['Articles']) . '</ArticleCount>
 <Articles>';
        $item = '';
        foreach ($xml['Articles'] AS $a) {
            $item .= '<item>
 <Title><![CDATA[' . $a['Title'] . ']]></Title>
 <Description><![CDATA[' . $a['Description'] . ']]></Description>
 <PicUrl><![CDATA[' . $a['PicUrl'] . ']]></PicUrl>
 <Url><![CDATA[' . $a['Url'] . ']]></Url>
 </item>';
        }
        $str = $str . $item . '</Articles><FuncFlag>0</FuncFlag></xml> ';
        echo $str;
        exit;
    }

    //输出一段文本类型消息给微信
    function responseText($text = null) {
        if (trim($text)) {
            $this->backData['Content'] = $text;
            $this->textTemplate($this->backData);
        }
    }

    //返回测试数据
    public function getTestXml($msgType) {
        if ($msgType == 'text') {
            $text = '<xml><ToUserName><![CDATA[gh_8beddc0ffe45]]></ToUserName>
<FromUserName><![CDATA[o3NOTjuuuVzTERS2INXGeqLM4t7A]]></FromUserName>
<CreateTime>1363249489</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[1]]></Content>
<MsgId>5855111971643712177</MsgId>
</xml>';
        } elseif ($msgType == 'images') {
            $text = '<xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName>
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[image]]></MsgType>
 <PicUrl><![CDATA[this is a url]]></PicUrl>
 <MsgId>1234567890123456</MsgId>
 </xml>';
        } elseif ($msgType == 'location') {
            $text = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[location]]></MsgType>
<Location_X>23.134521</Location_X>
<Location_Y>113.358803</Location_Y>
<Scale>20</Scale>
<Label><![CDATA[位置信息]]></Label>
<MsgId>1234567890123456</MsgId>
</xml> ';
        } elseif ($msgType == 'link') {
            $text = '<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>1351776360</CreateTime>
<MsgType><![CDATA[link]]></MsgType>
<Title><![CDATA[公众平台官网链接]]></Title>
<Description><![CDATA[公众平台官网链接]]></Description>
<Url><![CDATA[url]]></Url>
<MsgId>1234567890123456</MsgId>
</xml> ';
        } elseif ($msgType == 'event') {
            $text = '<xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
<EventKey><![CDATA[EVENTKEY]]></EventKey>
</xml>';
        } else {
            $text = '';
        }
        return $text;
    }

    //根据俱乐部返回banner图片
    public function getClubBanner($club_id) {
        $banners = array(
            'club21' => $this->_siteurl . '/static/weixinbanner/yumaoqiu.jpg',
            'club9' => $this->_siteurl . '/static/weixinbanner/touzilicai2.jpg',
            'club10' => $this->_siteurl . '/static/weixinbanner/jinrun.jpg',
            'club22' => $this->_siteurl . '/static/weixinbanner/sheying.jpg',
            'club25' => $this->_siteurl . '/static/weixinbanner/gaoerfu.jpg',
            'club41' => $this->_siteurl . '/static/weixinbanner/dianying.jpg',
            'club20' => $this->_siteurl . '/static/weixinbanner/lanqiu2.jpg',
            'club24' => $this->_siteurl . '/static/weixinbanner/fangdichan.jpg',
            'club18' => $this->_siteurl . '/static/weixinbanner/yuandingzheda.jpg',
            'club31' => $this->_siteurl . '/static/weixinbanner/meishi.jpg',
            'club12' => $this->_siteurl . '/static/weixinbanner/chuangye.jpg',
            'club16' => $this->_siteurl . '/static/weixinbanner/falv.jpg',
            'club26' => $this->_siteurl . '/static/weixinbanner/laomofang.jpg',
            'club39' => $this->_siteurl . '/static/weixinbanner/tuiliyouxi.jpg',
            'club15' => $this->_siteurl . '/static/weixinbanner/qiyejia.jpg',
            'club36' => $this->_siteurl . '/static/weixinbanner/daxuezhisheng.jpg',
            'club37' => $this->_siteurl . '/static/weixinbanner/yixing.jpg',
            'club17' => $this->_siteurl . '/static/weixinbanner/touzi.jpg',
        );
        if (isset($banners['club' . $club_id])) {
            return $banners['club' . $club_id];
        } else {
            return $this->_siteurl . '/static/images/weixinb1.jpg';
        }
    }

}