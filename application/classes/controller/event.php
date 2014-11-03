<?php

/**
  +-----------------------------------------------------------------
 * 名称：活动控制器
  +-----------------------------------------------------------------
 */
class Controller_Event extends Layout_Main {

    function before() {
        $this->template = 'layout/event';
        parent::before();
        $this->_custom_media('<script type="text/javascript" src="/static/My97DatePicker/WdatePicker.js"></script><script type="text/javascript" src="/static/js/event.js?v=20130903"></script>');
    }

    /**
      +------------------------------------------------------------------------------
     * 活动首页
      +------------------------------------------------------------------------------
     */
    function action_index() {

        # 活动关键字搜索
        $q = Arr::get($_GET, 'q');
        $view['q'] = $q;

        # tag
        $tag = urldecode(Arr::get($_GET, 'tag'));
        $view['tag'] = $tag;

        # 活动分类
        $type = urldecode(Arr::get($_GET, 'type'));
        $view['type'] = $type;

        #特定范围
        $list = Arr::get($_GET, 'list');
        $view['list'] = $list;

        # 校友自主活动列表
        $event = Doctrine_Query::create()
                ->select('e.id')
                ->from('Event e')
                ->where('e.is_closed =0 OR e.is_closed IS NULL');

        if ($type) {
            $event->andWhere('e.type = ?', $type);
        }

        if ($q) {
            $event->andWhere('e.title LIKE ?', '%' . $q . '%');
        }

        if ($tag) {
            $event->andWhere('(e.title LIKE ? OR e.tags LIKE ?)', array('%' . $tag . '%', '%' . $tag . '%'));
        }

        if ($list == 'aa' AND $this->_uid > 0) {
            $event->whereIn('e.aa_id', Model_User::aaIds($this->_uid));
        }

        if ($list == 'joined' AND $this->_uid > 0) {
            $event->whereIn('e.id', Model_Event::joinIDs($this->_uid));
        }

        if ($list) {
            switch ($list) {
                case 'week':
                    $time_span = time() + Date::WEEK;
                    $event->addWhere('UNIX_TIMESTAMP(e.start)>UNIX_TIMESTAMP() AND UNIX_TIMESTAMP(e.start)<=' . $time_span);
                    break;
                case 'today':
                    $event->addWhere('TIMESTAMPDIFF(DAY, now(), e.start)=0');
                    break;
                case 'weeken':
                    $event->addWhere('DAYOFWEEK(e.start)=1 OR DAYOFWEEK(e.start)=7');
                    break;
                default :
                    break;
            }
        }

        $pager = Pagination::factory(array(
                    'total_items' => $event->count(),
                    'items_per_page' => 10,
                    'view' => 'pager/common',
        ));
        $view['pager'] = $pager;

        $view['events'] = $event->addSelect('e.title,e.start,e.is_vcert,e.small_img_path,e.comments_num AS cmt_num,e.custom_icon,e.finish,e.address,e.type,e.aa_id,e.club_id,e.is_fixed,e.publish_at,e.tags,e.votes,e.score')
                ->addSelect('a.name, c.name')
                ->addSelect('(SELECT SUM(ss.num) FROM EventSign ss WHERE ss.event_id = e.id) AS sign_num')
                ->addSelect('IF(e.finish >= now(),TIMESTAMPDIFF(MINUTE, now(), e.start),900000) AS can_sign')
                ->addSelect('IF(e.is_fixed = 1 && e.start >= now(),1,0) AS is_start_fixed')
                ->leftJoin('e.Aa a')
                ->leftJoin('e.Club c')
                ->orderBy('is_start_fixed DESC,can_sign ASC,e.start DESC')
                ->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        # 总会活动专题
        $view['static'] = Doctrine_Query::create()
                ->select('id,title,redirect,img_path')
                ->from('EventStatic')
                ->where('is_closed = ?', FALSE)
                ->limit(10)
                ->orderBy('order_num ASC,id DESC')
                ->fetchArray();

        #最新活动照片
        $condition = array('list' => 'event', 'page_size' => 6);
        $album_data = Db_Album::getAlbums($condition);
        $view['event_pic'] = $album_data['albums'];

        #热门标签
        $view['tags'] = Doctrine_Query::create()
                ->select('id,name,num, RANDOM() AS rand')
                ->from('EventTags')
                ->limit('30')
                ->orderBy('num DESC')
                ->fetchArray();

        $this->_title('校友会活动');
        $this->_render('_body', $view);
    }

    //热门标签
    function action_tags() {
        #特定时间
        $list = Arr::get($_GET, 'list');
        $view['list'] = $list;

        #最新活动照片
        $view['event_pic'] = Doctrine_Query::create()
                ->select('p.id,p.name,p.upload_at,p.img_path')
                ->from('Pic p')
                ->leftJoin('p.Album a')
                ->andWhere('a.event_id>?', 0)
                ->orderBy('p.id DESC')
                ->limit('4')
                ->fetchArray();

        # 总会活动专题
        $view['static'] = Doctrine_Query::create()
                ->select('id,title,redirect,img_path')
                ->from('EventStatic')
                ->where('is_closed = ?', FALSE)
                ->limit(10)
                ->orderBy('order_num ASC,id DESC')
                ->fetchArray();

        $view['tags'] = Doctrine_Query::create()
                ->select('id,name,num, RANDOM() AS rand')
                ->from('EventTags')
                ->limit('150')
                ->orderBy('rand')
                ->useResultCache(true, 3600, 'event_tags')
                ->fetchArray();
        $this->_title('活动标签');
        $this->_render('_body', $view);
    }

    /**
      +------------------------------------------------------------------------------
     * 专题信息展示
      +------------------------------------------------------------------------------
     */
    function action_static() {
        $id = Arr::get($_GET, 'id', 0);

        $view['static'] = Doctrine_Query::create()
                ->from('EventStatic')
                ->where('id = ?', $id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        if (!$view['static']) {
            $this->request->redirect('main/notFound');
        }

        $this->_title($view['static']['title']);
        $this->_render('_body', $view);
    }

    function action_signForm($template = '') {
        $this->auto_render = FALSE;
        $event_id = Arr::get($_GET, 'eid');
        $sign_action = Arr::get($_GET, 'sign_action', 'addForm');
        $template = Arr::get($_GET, 'template', 'event/signForm');

        //不能参加的原因
        $view['error'] = false;

        //活动报名分类
        $view['categorys'] = Db_Event::getSignCategory($event_id);

        //报名模型(活动id，用户id，添加或修改)
        $eventSign = new Model_Eventsign($event_id, $this->_uid, $sign_action);

        $view['event'] = $eventSign->getEvent();
        if (!$eventSign->signValidation()) {
            $view['error'] = $eventSign->getError();
        }

        //编辑报名信息
        if ($sign_action == 'updateForm') {
            $view['user_sign'] = Model_Event::getUserSign($event_id, $this->_uid);
        }

        echo View::factory($template, $view);
    }

    /**
      +------------------------------------------------------------------------------
     * 添加或修改报名信息
      +------------------------------------------------------------------------------
     */
    function action_sign() {

        $this->auto_render = FALSE;
        $event_id = Arr::get($_POST, 'event_id');
        $sign_action = Arr::get($_POST, 'sign_action');
        $eventSign = new Model_Eventsign($event_id, $this->_uid, $sign_action);

        //传递表单数据
        $eventSign->postData = $_POST;

        //提交添加或修改信息
        $post_status = $eventSign->signSub();

        // 执行报名或修改操作
        if ($post_status) {
            echo $post_status;
        }
        //报名或修改失败
        else {
            $error = $eventSign->getError();
            echo 'err#' . $error;
            exit;
        }
    }

    //返回分组活动报名信息
    //$event_id,$category_id,$limit
    function action_signs() {
        $this->auto_render = FALSE;
        $event_id = Arr::get($_GET, 'event_id');
        $category_id = Arr::get($_GET, 'category_id', null);
        $view['permission'] = Db_Event::getPermission($event_id, $this->_uid, null);
        $view['signs'] = Db_Event::getEventSigner($event_id, null, $category_id);
        $view['category'] = Doctrine_Query::create()
                ->from('EventSignCategorys')
                ->where('id=?', $category_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        echo View::factory('event/signs', $view);
    }

    //设置活动某bool类型字段值
    function action_set() {
        $event_id = Arr::get($_POST, 'event_id');
        $field = Arr::get($_POST, 'field');

        $event = Doctrine_Query::create()
                ->from('Event e')
                ->andWhere('e.id = ?', $event_id)
                ->fetchOne();

        if (!Model_Event::isManager($event)) {
            exit;
        }

        if ($event && $field) {
            $event[$field] = $event[$field] == TRUE ? FALSE : TRUE;
            $event->save();
        }
    }

    /**
      +------------------------------------------------------------------------------
     * 取消活动报名
      +------------------------------------------------------------------------------
     */
    function action_cancelSign() {

        $event_id = Arr::get($_GET, 'eid');

        //取消报名
        Doctrine_Query::create()
                ->delete('EventSign')
                ->where('user_id = ?', $this->_uid)
                ->andWhere('event_id = ?', $event_id)
                ->execute();
    }

    /**
      +------------------------------------------------------------------------------
     * 活动详细介绍页面
      +------------------------------------------------------------------------------
     */
    function action_view() {

        $this->userPermissions('eventView');

        $id = Arr::get($_GET, 'id');

        //活动详细页面数据
        $condition = array(
            'event_id' => $id,
            'aa_info' => True,
            'club_info' => True,
            'album' => True,
            'photos' => True,
            'signs' => True,
            'organiger_info' => True,
            'bbs_unit_id' => True,
            'user_sign_status' => True,
            'permission' => True,
            'sign_category' => True
        );

        $view['event_data'] = Db_Event::getEventViewData($condition);

        //活动不存在
        if (!$view['event_data']) {
            $this->request->redirect('main/notFound');
            exit;
        }



        //校友会或俱乐部活动进行跳转
        if ($view['event_data']['event']['club_id'] > 0 AND $view['event_data']['event']['aa_id'] > 0) {
            $this->_redirect(Db_Event::getLink($id, $view['event_data']['event']['aa_id'], $view['event_data']['event']['club_id']));
        } elseif ($view['event_data']['event']['aa_id'] > 0) {
            $this->_redirect(Db_Event::getLink($id, $view['event_data']['event']['aa_id'], null));
        } else {
            
        }

        $this->_title($view['event_data']['event']['title']);
        $this->_render('_body', $view);
    }

    //快速修改
    function action_quick_edit() {
        $this->auto_render = False;
        $event_id = Arr::get($_GET, 'id', 0);
        $view['etype'] = Kohana::config('icon.etype');
        $view['event'] = Doctrine_Query::create()
                ->from('Event')
                ->where('id = ?', $event_id)
                ->fetchOne();
        $view['aa_id'] = $view['event']['aa_id'];
        $view['club_id'] = $view['event']['club_id'];
        echo View::factory('event/quick_edit', $view);
    }

    //发起和修改表单
    function action_form() {

        $this->userPermissions('eventPublish');

        $event_id = Arr::get($_GET, 'id', 0);
        $restart = Arr::get($_GET, 'restart', 0);
        $view['aa_id'] = Arr::get($_GET, 'aa');
        $view['club_id'] = Arr::get($_GET, 'club');
        $view['restart'] = $restart;
        $view['event'] = Doctrine_Query::create()
                ->from('Event')
                ->where('id = ?', $event_id)
                ->fetchOne();

        //编辑、推荐、置顶、删除等权限
        $permission = Db_Event::getPermission($event_id, $this->_uid);
        $view['permission'] = $permission;

        if ($view['event'] != false) {
            // 替代URL aa,club参数
            $view['aa_id'] = $view['event']['aa_id'];
            $view['club_id'] = $view['event']['club_id'];
            //只有管理员和本人可再次修改
            if (!$permission['is_edit_permission']) {
                Model_User::deny('您还没有权限修改本活动！');
                exit;
            }
        }

        $this->_title('组织活动');
        $this->_render('_body', $view);
    }

    //过滤标签
    function replaceTags($tags) {
        $tags = preg_replace('/(^\s*)|(\s*$)/', '', $tags); //去除首尾空格;
        $tags = preg_replace('/,|，|(\s+)|(　+)+/', ' ', $tags); //替代空格,换行,tab,中文空格
        $tags = preg_replace('/(\s+)/', ' ', $tags); //替换多个空格为一个空格
        return $tags;
    }

    //处理与更新标签
    function updateTags($tags) {
        if (!$tags) {
            return FALSE;
        }
        $tags_array = explode(' ', trim($tags));
        foreach ($tags_array as $name) {
            $tag = Doctrine_Query::create()
                    ->from('EventTags')
                    ->where('name = ?', $name)
                    ->fetchOne();
            if ($tag) {
                $count = Doctrine_Query::create()
                        ->select('id')
                        ->from('Event')
                        ->where('tags LIKE ?', '%' . $name . '%')
                        ->count();
                $tag->num = $count;
                $tag->save();
            } else {
                $tag = new EventTags();
                $tag->name = $name;
                $tag->num = 1;
                $tag->save();
            }
        }
    }

    /**
      +------------------------------------------------------------------------------
     * 发布、修改活动
      +------------------------------------------------------------------------------
     */
    function action_publish() {

        $this->userPermissions('eventPublish');
        $postNew = False;

        if ($_POST) {
            $is_quick_edit = (bool) Arr::get($_POST, 'is_quick_edit');
            $v = Validate::setRules($_POST, 'event');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {

                //是否是快速编辑
                if (!$is_quick_edit) {
                    $content = isset($_POST['content']) ? $_POST['content'] : null;
                    $con_len = strlen($content);
                    if ($con_len < 4) {
                        echo Candy::MARK_ERR . ' 内容介绍是不是有点少了呢？';
                        exit;
                    } elseif ($con_len >= 4294960000) {
                        echo Candy::MARK_ERR . ' 内容介绍字数过多，如是Word粘贴内容，请整理后重试。';
                        exit;
                    }
                    $post['content'] = $content;
                    $post['intro'] = Text::limit_chars(strip_tags($content), 200);
                }

                //活动分类
                $post['type'] = Arr::get($_POST, 'etype');

                //是否包含非法关键词
                $filter_str = Model_Filter::check(array(Arr::get($_POST, 'title'), Arr::get($_POST, 'content')));
                if ($filter_str) {
                    echo Candy::MARK_ERR . '检测到含有非法关键词“' . $filter_str . '”，请在修改后重试，谢谢！';
                    exit;
                }

                //Tags
                $tags = $this->replaceTags($post['tags']);
                $post['tags'] = $tags;

                //活动详情
                $event = Doctrine_Query::create()
                        ->from('Event e')
                        ->where('e.id = ?', $post['id'])
                        ->fetchOne();


                //自助创建队伍自动设置选择队伍标签
                if (isset($post['is_create_procession']) AND empty($post['is_create_procession'])) {
                    $post['category_label'] = '选择队伍';
                }

                // 发布新活动
                if (!$event) {
                    $postNew = True;
                    $post['user_id'] = $this->_uid;
                    $post['num'] = 1;
                    $post['publish_at'] = date('Y-m-d H:i:s');
                    $event = new Event();
                    $event->fromArray($post);
                    //设置活动相册
                    $event->Album['name'] = $post['title'] . '相册';
                    $event->Album['aa_id'] = $post['aa_id'];
                    if (isset($post['club_id']) AND $post['club_id'] > 0) {
                        $event->Album['club_id'] = $post['club_id'];
                    }
                    $event->Album['create_at'] = date('Y-m-d H:i:s');

                    //设置Bbs发布时间
                    $event->Units['create_at'] = date('Y-m-d H:i:s');
                    $event->Units['user_id'] = $this->_uid;

                    //增加用户积分
                    Db_User::updatePoint('event');
                }

                //修改活动
                else {

                    //编辑、推荐、置顶、删除等权限
                    $permission = Db_Event::getPermission($event['id']);

                    // 校验权限
                    if ($permission['is_edit_permission']) {

                        //id主键修改会出错，所以删除
                        unset($post['id']);

                        //获取修改项
                        $post['is_suspend'] = isset($post['is_suspend']) ? true : false;
                        $post['is_stop_sign'] = isset($post['is_stop_sign']) ? true : false;
                        $post['is_create_procession'] = isset($post['is_create_procession']) ? true : false;
                        $event->synchronizeWithArray($post);

                        //同步修改相册字段
                        $event['Album']['name'] = $post['title'] . '相册';

                        //同步修改Bbs字段
                        $event->Units['user_id'] = $event['user_id'];
                        $event->Units['create_at'] = $event['publish_at'];
                        $event->Units['update_at'] = date('Y-m-d H:i:s');
                    } else {
                        echo Candy::MARK_ERR . '很抱歉，您无权修改！';
                        exit;
                    }
                }

                //同步到bbs
                //获取活动对于俱乐部或校友会论坛版块
                $aa_id = Arr::get($_POST, 'aa_id');
                $club_id = Arr::get($_POST, 'club_id');

                if ($club_id > 0) {
                    $bbs_ids = Model_Bbs::getIDs(array('club_id' => $club_id));
                } elseif ($aa_id > 0) {
                    $bbs_ids = Model_Bbs::getIDs(array('aa_id' => $aa_id));
                } else {
                    $bbs_ids = Model_Bbs::getIDs(array('aa_id' => 0));
                }

                if (count($bbs_ids) > 0) {
                    foreach ($bbs_ids AS $id => $name) {
                        $bbs_id = $id;
                        break;
                    }
                }

                //Bbs话题其他字段
                if (@$bbs_id > 0) {
                    $bbs_info = Model_Bbs::getBbsByid($bbs_id);
                    $event->Units['subject'] = 3;
                    $event->Units['title'] = $post['title'];
                    $event->Units['bbs_id'] = $bbs_id;
                    $event->Units['aa_id'] = $bbs_info['aa_id'];
                    $event->Units['club_id'] = $bbs_info['club_id'];
                    $event->Units['type'] = 'Post';
                    if (!$is_quick_edit) {
                        $event->Units['Post']['content'] = $post['content'];
                    }
                }

                //保存以上内容
                $event->save();

                //更新tags
                $this->updateTags($tags);

                //自动发布到新鲜事
                if ($event->id AND $postNew) {
                    $weiboPost = array();
                    $weiboPost['user_id'] = $this->_uid;
                    $weiboPost['aa_id'] = $post['aa_id'];
                    $weiboPost['content'] = '我刚发布了[e=' . $event->id . ']' . $event['title'] . '[/e]活动，时间' . $event['start'] . '，快来参加吧！';
                    Model_weibo::post($weiboPost);
                }

                //跳转到活动详细页面
                echo $event->id;
            }
        }
    }

    //删除活动
    function action_del() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        //编辑、推荐、置顶、删除等权限
        $permission = Db_Event::getPermission($cid, $this->_uid);

        if ($permission['is_edit_permission']) {
            Db_Event::delete($cid);
        }
    }

    //删除报名信息
    function action_delsign() {

        $this->auto_render = False;

        if ($_GET) {
            $cid = Arr::get($_GET, 'cid');
        } elseif ($_POST) {
            $cid = Arr::get($_POST, 'sign_id');
            $remarks = Arr::get($_POST, 'remarks');
        }

        //报名信息
        $sign = Db_Event::getSignById($cid);
        $event = Db_Event::getEventById($sign['event_id']);
        $signer = Db_User::getInfoById($sign['user_id']);
        if (!$sign OR !$signer OR !$event) {
            echo '没有找到报名记录或活动记录或用户!';
            exit;
        }

        //编辑、推荐、置顶、删除等权限
        $permission = Db_Event::getPermission($sign['event_id'], $this->_uid, $event);

        if (!$permission['is_edit_permission']) {
            echo 'No Access!';
            exit;
        }

        //获取表单
        if ($_GET) {
            $view['sign'] = $sign;
            $view['event'] = $event;
            $view['sign_user'] = $signer;
            echo View::factory('event/delSignForm', $view);
        }
        //删除报名记录
        elseif ($_POST) {
            $notic = Arr::get($_POST, 'notic', 'none');
            $remarks = Arr::get($_POST, 'remarks');
            Db_Event::deleteSignById($cid);

            if ($notic == 'msg' OR $notic == 'msg_mail') {
                Model_Msg::create(array(
                    'user_id' => $this->_uid,
                    'send_to' => $sign['user_id'],
                    'sort_in' => 0,
                    'content' => $remarks,
                ));
            }
            if ($notic == 'msg_mail') {
                $mailer = new Model_Mailer('first');
                $mailer->sendMessage($signer['realname'], $signer['account'], $remarks);
            }
            echo '1';
        }
    }

//我参加了可发表投票和评论的活动
    function action_userjoin() {

        $this->auto_render = False;
        $lastEventVoteTime = $this->_sess->get('lastEventVoteTime');
        $nowTime = date('Y-m-d H:i:s');

        //提示频率
        $openWindowTime = 0;

        //自上次弹出到现在时间
        $diffTime = strtotime($nowTime) - strtotime($lastEventVoteTime);

        if ($diffTime > $openWindowTime OR empty($lastEventVoteTime)) {
            $signs = Doctrine_Query::create()
                    ->select('s.*')
                    ->from('EventSign s')
                    ->leftJoin('s.Event e')
                    ->where('s.user_id=?', $this->_uid)
                    ->addWhere('e.start < now()')
                    ->addWhere('e.finish>"2013-01-01 00:00:00"')
                    ->addWhere('s.vote=?', 0)
                    ->addWhere('s.is_anonymous=?', 0)
                    ->addWhere('s.is_present is NULL')
                    ->addWhere('e.is_closed=0')
                    ->addWhere('e.is_suspend=0')
                    ->orderBy('e.finish DESC')
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

            $this->_sess->set('lastEventVoteTime', $nowTime);

            if ($signs) {
                echo $signs['event_id'];
            } else {
                echo '0';
            }
        }
    }

    //活动评分窗口
    function action_vote() {
        $this->auto_render = False;
        $id = Arr::get($_GET, 'eid');
        $view['event'] = Doctrine_Query::create()
                ->select('e.*')
                ->from('Event e')
                ->where('e.id=?', $id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        //大家都在说什么
        $comment = Doctrine_Query::create()
                ->select('c.*,u.realname AS realname')
                ->from('Comment c')
                ->leftJoin('c.User u')
                ->where('c.event_id=?', $id)
                ->addWhere('c.score>0')
                ->orderBy('c.id DESC')
                ->limit(5)
                ->fetchArray();

        $view['comment'] = $comment;
        //评分窗口
        echo View::factory('event/vote', $view);
        //活动总结窗口
    }

    //发表活动评分
    function action_votesub() {

        $this->auto_render = False;
        $event_id = Arr::get($_POST, 'event_id');
        $event_id = $event_id ? $event_id : Arr::get($_GET, 'event_id');
        $is_present = Arr::get($_GET, 'is_present');
        $feelings = Arr::get($_POST, 'feelings');
        $postvote = Arr::get($_POST, 'postvote', 5);

        //活动信息
        $event = Doctrine_Query::create()
                ->select('e.*')
                ->from('Event e')
                ->where('e.id=?', $event_id)
                ->fetchOne();

        //我的活动记录
        $sign = Doctrine_Query::create()
                ->from('EventSign')
                ->where('event_id=?', $event_id)
                ->addWhere('user_id=?', $this->_uid)
                ->addWhere('vote=0')
                ->fetchOne();

        if (!$sign) {
            echo Candy::MARK_ERR . '您没有报名或已经取消报名～';
            exit;
        }

        //未前去参加活动，删除报名记录
        if ($is_present == 'no') {
            $sign->delete();
            echo $is_present;
            exit;
        }
        //参加了活动但不发表评论
        elseif ($is_present == 'yesnocmt') {
            $sign['vote'] = $postvote;
            $sign['is_present'] = '是';
            $sign->save();
            Db_User::updatePoint('eventsign');
            echo $is_present;
            exit;
        }
        //参加活动并发表评论
        else {
            if (!$postvote) {
                echo Candy::MARK_ERR . '您还选择分数哦～';
                exit;
            }
            if (!$feelings) {
                echo Candy::MARK_ERR . '哎呀，随便说点什么吧 :)';
                exit;
            }
        }

        $sign['vote'] = $postvote;
        $sign['is_present'] = '是';
        $sign->save();
        Db_User::updatePoint('eventsign');

        //Bbs对应的帖子
        $bbsUnit = Doctrine_Query::create()
                ->select('id')
                ->from('BbsUnit')
                ->where('event_id = ?', $event_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        //发表活动体会
        if ($feelings) {
            $post['event_id'] = $event_id;
            $post['bbs_unit_id'] = $bbsUnit ? $bbsUnit['id'] : null;
            $post['content'] = $feelings;
            $post['user_id'] = $this->_uid;
            $post['score'] = $postvote;
            $post['post_at'] = date('Y-m-d H:i:s');
            $backCommentId = Model_Comment::post($post);
        }

        //重置活动评分结果
        $total_score = 0;
        $sign_vote = Doctrine_Query::create()
                ->select('s.*')
                ->from('EventSign s')
                ->where('s.event_id=?', $event_id)
                ->addWhere('s.vote>0')
                ->fetchArray();

        //总票数
        $num_votes = count($sign_vote);

        //总分值
        foreach ($sign_vote as $e) {
            $total_score = $total_score + $e['vote'];
        }

        //平均分值
        $average_score = round($total_score / $num_votes);

        //更新活动平均分值
        $event['score'] = $average_score;
        $event['votes'] = $num_votes;
        $event->save();

        //发布到新鲜事
        if ($backCommentId) {
            $weiboPost = array();
            $weiboPost['aa_id'] = $event['aa_id'];
            $weiboPost['user_id'] = $this->_uid;
            $weiboPost['is_original'] = false;
            $weiboPost['content'] = Common_Global::mobileText($feelings) . '  [e=' . $event_id . ']' . $event['title'] . '[/e]';
            Model_weibo::post($weiboPost);
        }
    }

    //感兴趣
    function action_interested() {
        $this->auto_render = false;
        $id = Arr::get($_GET, 'id');
        $cookie_name = 'interested_event_id' . $id;
        $keeptime = time() + Date::YEAR;
        if (isset($_COOKIE[$cookie_name])) {
            $is_interested = $_COOKIE[$cookie_name];
            echo 'ed';
        } else {
            $event = Doctrine_Query::create()
                    ->select('e.id,e.interested_num')
                    ->from('Event e')
                    ->where('e.id=?', $id)
                    ->fetchOne();
            if ($event) {
                $event->interested_num = $event['interested_num'] + 1;
                $event->save();
                setcookie($cookie_name, 'yes', $keeptime, '/');
                echo '感兴趣(' . $event->interested_num . ')';
            } else {
                echo '无活动';
            }
        }
    }

    //添加或修改队伍（只正对管理员）
    function action_signCategorys() {

        $event_id = Arr::get($_POST, 'event_id');
        $event_id = $event_id ? $event_id : Arr::get($_GET, 'event_id');
        $category_id = Arr::get($_POST, 'category_id');
        $name = Arr::get($_POST, 'name');
        $del = Arr::get($_POST, 'del');
        $merger_to_category_id = Arr::get($_POST, 'merger_to_category_id');
        $category = null;

        //编辑、推荐、置顶、删除等权限
        $permission = Db_Event::getPermission($event_id);

        // 校验权限
        if (!$permission['is_edit_permission']) {
            header("Content-Type:text/html; charset=utf-8");
            echo '您没有编辑权限！';
            exit;
        }

        //分类内容
        if ($category_id) {
            $category = Doctrine_Query::create()
                    ->from('EventSignCategorys')
                    ->where('id=?', $category_id)
                    ->fetchOne();
        }
        //删除
        if ($category AND $del) {
            DB::update('event_sign')->set(array('category_id' => 0))->where('event_id', '=', $event_id)->where('category_id', '=', $category_id)->execute();
            $category->delete();
            exit;
        }
        //合并到新分类
        elseif ($category AND $merger_to_category_id) {
            DB::update('event_sign')->set(array('category_id' => $merger_to_category_id, 'is_captain' => 0))->where('event_id', '=', $event_id)->where('category_id', '=', $category_id)->execute();
            exit;
        }
        //修改
        elseif ($category AND $name) {
            //队长id
            $captain_id = (int) Arr::get($_POST, 'captain_id');
            //更换队长了
            if ($category['captain_id'] != $captain_id) {
                DB::update('event_sign')->set(array('is_captain' => 0))->where('event_id', '=', $category['event_id'])->where('user_id', '=', $category['captain_id'])->execute();
                DB::update('event_sign')->set(array('is_captain' => 1, 'is_verify' => 1, 'category_id' => $category['id']))->where('event_id', '=', $category['event_id'])->where('user_id', '=', $captain_id)->execute();
                Model_Msg::create(array(
                    'user_id' => $this->_uid,
                    'send_to' => $captain_id,
                    'sort_in' => 0,
                    'content' => '恭喜您，您已经成为“' . $category['name'] . '”小队新任队长了，加油哦！',
                ));
            }
            $category->name = $name;
            $category->captain_id = $captain_id;
            $category->save();
            exit;
        }
        //添加
        elseif (!$category AND $event_id AND $name) {
            $category = new EventSignCategorys();
            $category->name = $name;
            $category->captain_id = Arr::get($_POST, 'captain_id');
            $category->remarks = Arr::get($_POST, 'remarks');
            $category->event_id = $event_id;
            $category->save();
            exit;
        }

        $event = Db_Event::getEventById($event_id);
        $categorys = Db_Event::getSignCategory($event_id);
        $view['event'] = $event;
        $view['categorys'] = $categorys;
        $view['event_id'] = $event_id;
        $this->_render('_body', $view);
    }

    //添加或修改分组（任何校友可操作）
    function action_signCategoryForm() {
        $view = array();
        $this->auto_render = False;
        $event_id = Arr::get($_GET, 'event_id');
        $event_id = $event_id ? $event_id : Arr::get($_POST, 'event_id');
        $category_id = Arr::get($_GET, 'category_id');
        $category_id = $category_id ? $category_id : Arr::get($_POST, 'category_id');
        $view['event_id'] = $event_id;
        $view['category_id'] = $category_id;
        $category = Doctrine_Query::create()
                ->from('EventSignCategorys')
                ->where('id=?', (int) $category_id)
                ->fetchOne();
        $view['category'] = $category;

        //我创建的队伍
        $my_category = Doctrine_Query::create()
                ->from('EventSignCategorys')
                ->where('event_id=?', (int) $event_id)
                ->addWhere('captain_id=?', (int) $this->_uid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        if (!$category_id AND $my_category) {
            echo '<div style="color:#f00;padding:20px;line-height:1.6em">很抱歉，您已经创建了' . $my_category['name'] . '，不能再创建更多了，如需更多，请直接活动发起人联系！</div>';
            exit;
        }

        if ($_POST AND $this->_uid) {
            $name = Arr::get($_POST, 'name');
            $remarks = Arr::get($_POST, 'remarks');
            if (empty($event_id) OR empty($name) OR empty($remarks)) {
                echo json_encode(array('status' => 0, 'error' => '队伍名称或说明不能为空'));
                exit;
            }

            //修改
            if ($category) {
                $has = Doctrine_Query::create()
                        ->from('EventSignCategorys')
                        ->where('name=?', $name)
                        ->addWhere('event_id=?', $event_id)
                        ->addWhere('id!=?', (int) $category_id)
                        ->count();
                if ($has > 0) {
                    echo json_encode(array('status' => 0, 'error' => '很抱歉，队伍名称已经存在，请换用其他的名称'));
                    exit;
                } else {
                    $category->name = $name;
                    $category->remarks = $remarks;
                    $category->save();
                    echo json_encode(array('status' => 1, 'id' => $category->id, 'name' => $category->name));
                    exit;
                }
            }
            //添加新队伍
            else {
                $has = Doctrine_Query::create()
                        ->from('EventSignCategorys')
                        ->where('name=?', $name)
                        ->addWhere('event_id=?', $event_id)
                        ->fetchOne();

                $has = Doctrine_Query::create()
                        ->from('EventSignCategorys')
                        ->where('name=?', $name)
                        ->addWhere('event_id=?', $event_id)
                        ->fetchOne();

                if ($has) {
                    echo json_encode(array('status' => 0, 'error' => '很抱歉，队伍名称已经存在，请换用其他的名称'));
                    exit;
                } elseif ($my_category) {
                    echo json_encode(array('status' => 0, 'error' => '很抱歉，您已经创建过一支队伍了，如需更多，请与活动管理员联系！'));
                    exit;
                } else {
                    $category = new EventSignCategorys();
                    $category->name = $name;
                    $category->event_id = $event_id;
                    $category->captain_id = $this->_uid;
                    $category->remarks = $remarks;
                    $category->save();
                    echo json_encode(array('status' => 1, 'id' => $category->id, 'name' => $category->name));
                    exit;
                }
            }
        } else {
            echo View::factory('event/signCategoryForm', $view);
        }
    }

    //管理小队成员
    function action_manageGroup() {
        $this->auto_render = False;
        $event_id = Arr::get($_POST, 'event_id');
        $category_id = Arr::get($_POST, 'category_id');
        $is_manager = Db_Event::is_category_manager($category_id, $this->_uid);
        if (!$is_manager) {
            echo 'No Access';
            exit;
        }
        $view = array();
        $view['member'] = Db_Event::getEventSignerMore($event_id, null, $category_id);
        echo View::factory('event/manageGroup', $view);
    }

    //加入到某小队
    function action_joineventgroup() {
        $this->auto_render = False;

        $sign_id = Arr::get($_POST, 'sign_id', 0);
        $sign = Doctrine_Query::create()
                ->from('EventSign')
                ->where('id=?', $sign_id)
                ->fetchOne();

        if (!$sign) {
            echo '没有找到报名记录';
            exit;
        }

        $is_manager = Db_Event::is_category_manager($sign['category_id'], $this->_uid);
        if (!$is_manager) {
            echo 'No Access';
            exit;
        }

        if ($sign->is_verify) {
            $sign->is_verify = false;
        } else {
            $sign->is_verify = true;

            $category_info = Doctrine_Query::create()
                    ->from('EventSignCategorys')
                    ->select('id,name')
                    ->where('id=?', $sign['category_id'])
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

            Model_Msg::create(array(
                'user_id' => $this->_uid,
                'send_to' => $sign['user_id'],
                'sort_in' => 0,
                'content' => '欢迎加入“' . $category_info['name'] . '”，您目前已经是该小组正式成员了，加油哦!',
            ));
        }
        $sign->save();
    }

    //删除小队成员
    function action_deleteGroupSign() {
        $this->auto_render = False;

        $sign_id = Arr::get($_POST, 'sign_id', 0);
        $sign = Doctrine_Query::create()
                ->from('EventSign')
                ->where('id=?', $sign_id)
                ->fetchOne();

        if (!$sign) {
            echo '没有找到报名记录';
            exit;
        }

        $is_manager = Db_Event::is_category_manager($sign['category_id'], $this->_uid);
        if (!$is_manager) {
            echo 'No Access';
            exit;
        }

        $category_info = Doctrine_Query::create()
                ->from('EventSignCategorys')
                ->select('id,name')
                ->where('id=?', $sign['category_id'])
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        Model_Msg::create(array(
            'user_id' => $this->_uid,
            'send_to' => $sign['user_id'],
            'sort_in' => 0,
            'content' => '很抱歉，由于您暂时未满足“' . $category_info['name'] . '入队要求”，请您另选其他队伍后重试，谢谢!',
        ));

        $sign->delete();
    }

    /**
      +------------------------------------------------------------------------------
     * 下载报名名单
      +------------------------------------------------------------------------------
     */
    function action_signDownload() {
        $this->auto_render = FALSE;

        $id = Arr::get($_GET, 'eid');
        $permission = DB_Event::getPermission($id);
        
        if (!$permission['is_edit_permission']) {
            echo 'Sorry,You do not have permission to perform this operation.';
            exit;
        }

        Candy::import('phpExcel');
        Candy::import('phpExce2005');

        $event = Doctrine_Query::create()
                ->from('Event')
                ->where('id = ?', $id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        if (!$event) {
            $this->request->redirect('main/notFound');
        }

        //$permission['is_control_permission']=0;
        //报名校友基本信息
        $sign = Doctrine_Query::create()
                ->select('s.*,u.sex AS sex,u.account AS account,u.realname AS realname,u.role AS role,u.start_year AS start_year,u.speciality AS speciality,c.address AS address,c.mobile AS mobile')
                ->from('EventSign s')
                ->leftJoin('s.User u')
                ->leftJoin('u.Contact c');

        //关联小队名称
        if ($event['category_label']) {
            $sign->addSelect('cat.name AS group_name')->leftJoin('s.EventSignCategorys cat');
        }

        //查询
        $sign = $sign->where('s.event_id = ' . $id)
                ->fetchArray();

        //管理员下载包含更多工作单位信息
        if ($permission['is_control_permission']) {
            $sign_ids = Doctrine_Query::create()
                    ->select('s.user_id')
                    ->from('EventSign s')
                    ->where('s.event_id= ?', $id)
                    ->execute(array(), 6);
            $sign_ids = count($sign_ids) > 0 ? $sign_ids : array(0);
            $all_user_works = Doctrine_Query::create()
                    ->select('w.user_id,w.job,w.company')
                    ->from('UserWork w')
                    ->whereIn('w.user_id', $sign_ids)
                    ->addwhere('w.company IS NOT NULL')
                    ->orderBy('w.id')
                    ->fetchArray();
            $user_works=array();
            foreach ($all_user_works AS $key => $w) {
                $user_works[$w['user_id']] = $w;
            }
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                ->setCreator("Maarten Balliauw")//创建人
                ->setLastModifiedBy("Maarten Balliauw")//最后修改人
                ->setTitle("Office 2007 XLSX Test Document")//标题
                ->setSubject("Office 2007 XLSX Test Document")//题目
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")//描述
                ->setKeywords("office 2007 openxml php")//关键字
                ->setCategory("Test result file"); //种类
        //
        //Excel列索引字母
        $excel_cols_indexs = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        //活动名称
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '活动名称：' . $event['title']);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true)->setSize(16);

        //字段名称，宽度
        $all_fields = array();
        $all_fields[] = array('姓名', 'realname', 15);
        $all_fields[] = array('性别', 'sex', 10);
        $all_fields[] = array('身份', 'role', 15);
        $all_fields[] = array('报名人数', 'num', 15);
        $all_fields[] = array('匿名', 'is_anonymous', 10);

        //有活动分组
        if ($event['category_label']) {
            $all_fields[] = array('已选小队', 'group_name', 30);
            $all_fields[] = array('是否为队长', 'is_captain', 20);
            $all_fields[] = array('是否审核', 'is_verify', 20);
        }

        //活动结束后
        if (time() >= strtotime($event['finish'])) {
            $all_fields[] = array('是否参加', 'is_present', 15);
            $all_fields[] = array('活动评分', 'vote', 15);
        }

        $all_fields[] = array('入学年份', 'start_year', 15);
        $all_fields[] = array('专业', 'speciality', 30);
        $all_fields[] = array('E-mail', 'account', 30);
        $all_fields[] = array('手机', 'mobile', 20);
        $all_fields[] = array('通讯地址', 'address', 30);

        //管理员下载名单包含更多信息
        if ($permission['is_control_permission']) {
            $all_fields[] = array('工作单位', 'company', 35);
            $all_fields[] = array('职务', 'job', 20);
        }

        //需要持门票
        if ($event['need_tickets']) {
            $all_fields[] = array('票数', 'tickets', 20);
            $all_fields[] = array('取票地点', 'receive_address', 20);
        }

        //备注
        $all_fields[] = array('报名日期', 'sign_at', 30);
        $all_fields[] = array('备注', 'remarks', 100);

        //从第3行开始标题
        foreach ($all_fields AS $key => $f) {
            //设置Excel标题
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_cols_indexs[$key] . '3', $f[0]);
            //设置字段宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension($excel_cols_indexs[$key])->setWidth($f[2]);
        }

        //标题格式
        $objPHPExcel->getActiveSheet()->getStyle('A3:O3')->getFont()->setBold(true)->setSize(12);
        //$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
        //$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFill()->getStartColor()->setARGB('FF999999');
        //设置每行每个单元格的值
        if ($sign) {
            $start_row = 4;
            //循环记录
            foreach ($sign AS $key => $s) {

                //工作单位信息
                $s['company'] = isset($user_works[$s['user_id']]) ? $user_works[$s['user_id']]['company'] : '';
                $s['job'] = isset($user_works[$s['user_id']]) ? $user_works[$s['user_id']]['job'] : '';
                //$s['num']=$s['num'].' 人';
                //循环设置每行中的每个单元格值
                foreach ($all_fields AS $key => $f) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_cols_indexs[$key] . $start_row, $s[$f[1]]);
                }
                $start_row++;
            }

            //设置sheet标题
            $objPHPExcel->getActiveSheet()->setTitle('sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);


            //直接保存
            $save_excel_file_path = 'static/export/event' . $id . ".xls";
            $objWriter->save($save_excel_file_path);

            echo 'Export success!';
            $this->_redirect('/' . $save_excel_file_path);
        }
    }

}