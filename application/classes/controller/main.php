<?php

class Controller_Main extends Layout_Main {

    public $_dev = TRUE;
    //public $_debug = TRUE;
    //首页
    function action_index() {
        
        //echo Kohana::debug($this->quickSort(array(54,1,65,87,2,22,65,23,6,55,12,14,16,2,4,87,100)));

        // 焦点(图片)新闻
        $view['news_pics'] = Db_News::getFocus(5);

        //首页静态图片
        $view['fixed_img'] = Db_Content::getStaticPic();

        //校友组织
        $view['aa'] = $this->_cache->get('home_aa');
        if (!$view['aa']) {
            $view['aa'] = Db_Aa::topAa('地方校友会', 15);
            $this->_cache->set('home_aa', $view['aa'], 84600);
        }

        //推荐学院
        $view['institution'] = $this->_cache->get('home_institution');
        if (!$view['institution']) {
            $view['institution'] = Db_Aa::topAa('学院', 6);
            $this->_cache->set('home_institution', $view['institution'], 84600);
        }

        //推荐俱乐部
        $view['club'] = $this->_cache->get('home_club');
        if (!$view['club']) {
            $view['club'] = Db_Club::topClub(6);
            $this->_cache->set('home_club', $view['club'], 84600);
        }

        //推荐活动
        $view['events'] = DB::query(Database::SELECT, 'SELECT `e`.`id` AS `id`,e.aa_id,e.club_id,`e`.`title` AS `title`, `e`.`type` AS `type`, `e`.`start` AS `start`, `e`.`finish` AS `finish`, (SELECT COUNT(`e2`.`id`) AS `e2__0` FROM `event_sign` `e2` WHERE (`e2`.`event_id` = `e`.`id`)) AS `sign_num`, (SELECT `a`.`sname` AS `sname` FROM `aa` `a` WHERE (`a`.`id` = `e`.`aa_id`)) AS `aa_name`, IF(`e`.`start` >= NOW(), TIMESTAMPDIFF(DAY, NOW(), `e`.`start`), 10000) AS `can_sign` FROM `event` `e` LEFT JOIN `sys_filter` `s` ON `e`.`id` = `s`.`event_id` WHERE ((`e`.`is_closed` = 0 OR `e`.`is_closed` IS NULL) AND `e`.`finish` > NOW() AND `s`.`event_id` > 0) ORDER BY `e`.`is_fixed` DESC,`can_sign` ASC,`e`.`start` DESC,`e`.`id` DESC LIMIT 2')
                ->execute()
                ->cached(1800)
                ->as_array();

        //主题活动
        $view['static'] = DB::select(DB::expr('id,title,redirect,img_path'))
                ->from('event_static')
                ->where('is_closed', '=', 0)
                ->limit(3)
                ->order_by('order_num', 'asc')
                ->cached(3600)
                ->execute()
                ->as_array();

        //专题展示
        $news_special = DB::select()
                ->from('news_special')
                ->where('is_displayweibo_on_home', '=', 1)
                ->limit(1)
                ->order_by('id', 'DESC')
                ->execute()
                ->as_array();

        $weibolist = array();
        $weibo_comments = array();
        $special_album = array();

        //默认显示3条新闻
        $news_limit = 3;
        //显示微博直播内容----------------------------------------------------------
        if ($news_special) {

            //专题头条新闻
            $view['top_news'] = Doctrine_Query::create()
                    ->select('n.id,n.title,n.intro,n.small_img_path,n.title_color')
                    ->from('News n')
                    ->where('n.is_draft = ?', FALSE)
                    ->andWhere('n.is_top=?', 1)
                    ->andWhere('n.special_id=?', $news_special['id'])
                    ->orderBy('n.id DESC')
                    ->limit(1)
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

            //专题相册
            $special_album = Doctrine_Query::create()
                    ->select('a.*')
                    ->addSelect('(SELECT p.img_path FROM pic p WHERE p.album_id = a.id ORDER BY p.upload_at DESC LIMIT 1) AS img_path')
                    ->from('Album a')
                    ->where('a.special_id = ' . $news_special['id'])
                    ->orderBy('a.id DESC')
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
            $view['special_album'] = $special_album;

            //新浪微博
            $weibolimit = $news_special['is_displaycomment_on_home'] ? 2 : 5;
            $weibolist = Doctrine_Query::create()
                    ->select('*')
                    ->from('SinaWeibo')
                    ->where('aa_id = ?', 0);
            if ($news_special['weibo_topic']) {
                $weibolist = $weibolist->addWhere('text LIKE ?', '%' . $news_special['weibo_topic'] . '%');
            }
            $weibolist = $weibolist->limit($weibolimit)
                    ->orderBy('id DESC')
                    ->fetchArray();
            $view['weibolist'] = $weibolist;

            $weibo_comments = null;
            //大家都在说
            if ($news_special['is_displaycomment_on_home']) {
                $weibo_comments = Doctrine_Query::create()
                        ->select('id,weibo_id,cmt_id,cmt_idstr,text,cmt_name,created_at,profile_image_url')
                        ->from('SinaComments')
                        ->where('is_verify = ?', true)
                        ->limit(24)
                        ->orderBy('id DESC')
                        ->fetchArray();
            }
            $view['weibo_comments'] = $weibo_comments;
        } else {
            $news_limit = 15;
        }

        $view['news_special'] = $news_special;
        $view['weibolist'] = $weibolist;
        $view['weibo_comments'] = $weibo_comments;
        $view['special_album'] = $special_album;

        //头条新闻
        $view['top_news'] = DB::select(DB::expr('n.id,n.title,n.intro,n.title_color'))
                ->from(array('news', 'n'))
                ->where('n.is_draft', '=', 0)
                ->where('n.is_top', '=', 1)
                ->order_by('n.id', 'DESC')
                ->execute()
                ->as_array();

        $view['top_news'] = $view['top_news'] ? $view['top_news'][0] : false;

        //更多新闻列表
        $view['news_list'] = DB::query(Database::SELECT, 'SELECT n.id,n.title,n.create_at, n.title_color,n.is_pic,n.is_fixed FROM `news` `n` LEFT JOIN `sys_filter` `s` ON `n`.`id` = `s`.`news_id` WHERE (`n`.`is_draft` = 0 AND `s`.`news_id` > 0 AND `n`.`is_top` = 0) ORDER BY `n`.`create_at` DESC LIMIT ' . $news_limit)->execute()->as_array();

        //求是群芳
        $view['people'] = $this->_cache->get('home_people');
        if (!$view['people']) {
            $view['people'] = DB::query(Database::SELECT, 'SELECT `p`.`id` AS `id`, `p`.`name` AS `name`, `p`.`pic` AS `pic`, `p`.`intro` AS `intro`, RAND() AS `p__0` FROM `people` `p` WHERE (`p`.`pic` is not NULL) ORDER BY `p__0` LIMIT 1')
                    ->execute()
                    ->as_array();
            $view['people'] = $view['people'] ? $view['people'][0] : false;
            $this->_cache->set('home_people', $view['people'], 86400);
        }

        //最新加入校友
        $view['new_alumni'] = DB::select(DB::expr('u.id,u.realname,u.sex,u.reg_at,u.speciality,u.city,u.start_year,u.finish_year'))
                ->from(array('user', 'u'))
                ->limit(4)
                ->order_by('u.id', 'DESC')
                ->cached(3600)
                ->execute()
                ->as_array();

        //求是记忆
        $view['old_pic'] = DB::query(Database::SELECT, 'SELECT `p`.`id`,`p`.`name` AS `name`, `p`.`img_path` AS `img_path` FROM `sys_filter` `s` LEFT JOIN `pic` `p` ON `s`.`pic_id` = `p`.`id` LEFT JOIN `album` `a` ON `p`.`album_id` = `a`.`id` WHERE (`s`.`pic_id` > 0 AND `a`.`aa_id` = 0) ORDER BY `p`.`id` DESC LIMIT 7')
                ->cached(3600)
                ->execute()
                ->as_array();

        //活动照片
        $view['event_pic'] = DB::query(Database::SELECT, 'SELECT `p`.`id`,`p`.`name` AS `name`, `p`.`img_path` AS `img_path` FROM `sys_filter` `s` LEFT JOIN `pic` `p` ON `s`.`pic_id` = `p`.`id` LEFT JOIN `album` `a` ON `p`.`album_id` = `a`.`id` WHERE (`s`.`pic_id` > 0 AND `a`.`aa_id` > 0) ORDER BY `p`.`id` DESC LIMIT 7')
                ->cached(3600)
                ->execute()
                ->as_array();

        //论坛最新话题
        $view['units'] = DB::query(Database::SELECT, 'SELECT `b`.`id`, `b`.`title`, `b`.`type`, `b`.`create_at`, `b`.`hit`, `b`.`reply_num`, `u`.`realname` AS `username`, `a`.`sname` AS `aa_name`, `a`.`id` AS `aa_id` FROM `bbs_unit` `b` LEFT JOIN `sys_filter` `s` ON `b`.`id` = `s`.`bbs_unit_id` LEFT JOIN `aa` `a` ON `b`.`aa_id` = `a`.`id` LEFT JOIN `user` `u` ON `b`.`user_id` = `u`.`id` WHERE (`b`.`is_closed` = 0 AND `s`.`bbs_unit_id` > 0 AND `b`.`club_id` = 0) ORDER BY `b`.`create_at` DESC LIMIT 11')
                ->cached(3600)
                ->execute()
                ->as_array();

        //图片链接
        $view['logo_links'] = DB::select()
                ->from('links')
                ->where('is_logo', '=', 1)
                ->where('type', '=', 1)
                ->limit(50)
                ->order_by('order_num', 'ASC')
                ->order_by('id', 'desc')
                ->cached(3600)
                ->execute()
                ->as_array();

        //校内文字链接(type:1)
        $view['text_links1'] = DB::select()
                ->from('links')
                ->where('is_logo', '=', 0)
                ->where('type', '=', 1)
                ->limit(50)
                ->order_by('order_num', 'ASC')
                ->order_by('id', 'DESC')
                ->cached(3600)
                ->execute()
                ->as_array();

        //校外文字链接(type:2)
        $view['text_links2'] = DB::select()
                ->from('links')
                ->where('is_logo', '=', 0)
                ->where('type', '=', 2)
                ->limit(50)
                ->order_by('order_num', 'ASC')
                ->order_by('id', 'desc')
                ->cached(3600)
                ->execute()
                ->as_array();

        //一周热门话题
        $hot_date_span = date('Y-m-d H:i:s', (time() - Date::MONTH - Date::MONTH));
        $hot_topics_sql = 'SELECT `b`.`id`, `b`.`bbs_id`, `b`.`title`, `b`.`create_at`, `b`.`hit`, `b`.`user_id`, `b`.`type`, `b`.`aa_id`, `b`.`reply_num`,`reply_num` AS `reduzhi`, `a`.`sname` AS `sname` FROM `bbs_unit` `b` LEFT JOIN `sys_filter` `s` ON `b`.`id` = `s`.`bbs_unit_id`  LEFT JOIN `aa` `a` ON `b`.`aa_id` = `a`.`id` WHERE (`b`.`is_closed` = 0 AND `s`.`bbs_unit_id` > 0 AND `b`.`create_at` > "' . $hot_date_span . '") ORDER BY `reduzhi` DESC,`b`.`hit` DESC, `b`.`reply_num` DESC LIMIT 11';
        $view['hot_topic'] = DB::query(Database::SELECT, $hot_topics_sql)
                ->execute()
                ->as_array();


        //捐赠鸣谢
        $view['statistics'] = DB::select(DB::expr('id,project,donate_at,donor,speciality,amount'))
                ->from('donate_annual')
                ->where('payment_status', '=', 1)
                ->order_by('donate_at', 'DESC')
                ->order_by('id', 'DESC')
                ->limit(30)
                ->cached(3600)
                ->execute()
                ->as_array();

        $this->_title($this->_config->base['sitename'] . ' - 母校就在你身边 校友与你心相连');

        if ($news_special) {
            $this->_render('_body', $view, 'main/index_special');
        } else {
            $this->_render('_body', $view, 'main/indexa');
        }
    }

    function action_deny() {
        $view['reason'] = urldecode(Arr::get($_GET, 'reason'));
        $this->_title('抱歉，您没有权限访问该资源');
        $this->_render('_body', $view);
    }

    function action_notFound() {
        $this->_title('抱歉，您所请求的信息没有找到');
        $this->_render('_body');
    }

    function action_notAuthorized() {
        $this->_title('抱歉，您没有权限访问该页');
        $this->_render('_body');
    }

    #关注某校友

    function action_mark() {
        $obj = Arr::get($_GET, 'obj', 'user');
        $val = Arr::get($_GET, 'val');

        if (!$this->_sess->get('id')) {
            echo '请先登录';
            exit;
        }

        $user_id = $this->_sess->get('id');

        $mark = Doctrine_Query::create()
                ->from('UserMark')
                ->where('user_id = ?', $user_id)
                ->andWhere($obj . ' = ?', $val)
                ->fetchOne();

        if ($mark) {
            $mark->delete();
            echo '重新关注';
        } else {
            $mark = new UserMark();
            $mark->user_id = $user_id;
            $mark->$obj = $val;
            $mark->mark_at = date('Y-m-d H:i:s');
            $mark->save();
            echo '取消关注';
        }
    }

    public function quickSort($arr) {
        if (count($arr) > 1) {
            //关键数据
            $k = $arr[0];
            $x = array();
            $y = array();
            $_size = count($arr);
            for ($i = 1; $i < $_size; $i++) {
                if ($arr[$i] <= $k) {
                    $x[] = $arr[$i];
                } else {
                    $y[] = $arr[$i];
                }
            }
            $x = $this->quickSort($x);
            $y = $this->quickSort($y);
            return array_merge($x, array($k), $y);
        } else {
            return $arr;
        }
    }

}
