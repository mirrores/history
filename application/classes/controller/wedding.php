<?php

class Controller_Wedding extends Layout_Main {

    public $_id;
    public $_wedding;
    public $_year;
    public $_openvote;

    public function before() {
        $this->template = 'layout/wedding';
        parent::before();
        $this->_year = $this->request->param('year');
        $this->_id = Arr::getAll('id');
        $this->_openvote = false;

        //投票不查找婚礼，减轻刷票压力
        if ($this->request->action != 'good') {
            if ($this->_year) {
                $this->_wedding = Db_Wedding::getByYear($this->_year);
            } elseif ($this->_id) {
                $this->_wedding = Db_Wedding::getByid($this->_id);
            } else {
                //不指定年份获取最新一届活动
                $this->_wedding = Db_Wedding::getLatest();
            }
            if (!$this->_wedding) {
                $this->request->redirect('main/notFound');
            } else {
                $this->_id = $this->_wedding['id'];
            }
            View::set_global('_YEAR', $this->_wedding['year']);
            View::set_global('_OPENVOTE', $this->_openvote);
            View::set_global('_WID', $this->_wedding['id']);
            View::set_global('_WEDDING', $this->_wedding);
            $this->_render('_notice', array('wedding' => $this->_wedding), 'wedding/inc_notice_none');
        }
    }

    #集体婚礼首页
    function action_index() {
        $view['wedding'] = $this->_wedding;

        if ($this->_uid) {
            $view['user_sign'] = Db_Wedding::getUserSign($this->_wedding['id'], $this->_uid);
        } else {
            $view['user_sign'] = array();
        }

        //报名总数
        $view['sign_count'] = Db_Wedding::getCountSigner($this->_wedding['id']);

        //集体婚礼相册
        $view['album'] = Doctrine_Query::create()
                ->from('Album')
                ->select('*')
                ->where('wedding_id=?', $this->_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        //相册照片
        $view['alubm_photo'] = $view['album'] ? Db_Album::getPics($view['album']['id'], 12, true) : array();

        //随机新人展示
        $photos = DB::select(DB::expr('s.id,s.wedding_id,s.user_id,s.bridegroom_name,s.bride_name,s.sign_at,s.love_declaration,s.photo_path,s.good_num,RAND() AS order_num'))
                ->select(DB::expr('(SELECT COUNT(o.id) FROM wedding_sign o WHERE (o.good_num >s.good_num) OR (o.good_num=s.good_num AND o.id<s.id)) AS topnum'))
                ->from(array('wedding_sign', 's'))
                ->where('s.wedding_id', '=', $this->_wedding['id'])
                ->order_by('order_num', 'ASC')
                ->limit(12)
                ->execute()
                ->as_array();

        //计算首页随机新人排名
        foreach ($photos as $key => $p) {
            $photos[$key]['votekey'] = md5($this->GetIP() . $p['id'] . 'zjuwedding@zjg');
            $photos[$key]['topnum'] = $p['topnum'] + 1;
        }
        $view['photos'] = $photos;

        //通知公告
        $notice = Doctrine_Query::create()
                ->select('c.id,c.title,c.redirect,c.content,c.create_at,c.update_at')
                ->from('Content c')
                ->where('c.type=18')
                ->orderBy('c.id DESC')
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);


        //重要公告通知
        $view['notices'] = Doctrine_Query::create()
                ->select('c.id,c.title,c.redirect,c.content,c.create_at,c.update_at')
                ->from('Content c')
                ->where('c.type=18')
                ->orderBy('c.id DESC')
                ->limit(5)
                ->fetchArray();


        //祝福墙
        $view['wish'] = Doctrine_Query::create()
                ->select('w.id,w.wedding_id,w.user_id,w.content,w.created_at')
                ->addSelect('u.realname AS username')
                ->from('WeddingWish w')
                ->leftJoin('w.User u')
                ->where('w.wedding_id=?', $this->_id)
                ->addWhere('w.is_closed=?', false)
                ->orderBy('w.id DESC')
                ->limit(50)
                ->fetchArray();


        //新人投票排行
        $view['newtop'] = Doctrine_Query::create()
                ->from('WeddingSign s')
                ->select('s.id,s.wedding_id,s.bridegroom_name,s.bride_name,s.good_num')
                ->where('wedding_id=?', $this->_id)
                ->orderBy('s.good_num DESC,s.id ASC')
                ->limit(117)
                ->fetchArray();


        //活动抽奖
        $view['lottery'] = Model_Lottery::getLottery($this->_id);

        //鸣谢
        $view['thinks'] = Doctrine_Query::create()
                ->from('WeddingSponsors')
                ->where('wedding_id=0 OR wedding_id=?', $this->_id)
                ->addWhere('category_id=2')
                ->orderBy('order_num ASC,id ASC')
                ->limit(16)
                ->fetchArray();

        //赞助
        $view['ponsors'] = Doctrine_Query::create()
                ->from('WeddingSponsors')
                ->where('wedding_id=0 OR wedding_id=?', $this->_id)
                ->addWhere('category_id=1')
                ->orderBy('order_num ASC,id ASC')
                ->limit(16)
                ->fetchArray();


        //当前用户是否发表祝福
        if ($this->_uid) {
            $view['is_wished'] = Doctrine_Query::create()
                    ->select('w.id')
                    ->from('WeddingWish w')
                    ->where('w.wedding_id=?', $this->_id)
                    ->addWhere('w.user_id=?', $this->_uid)
                    ->count();
            //用户抽奖历史
            $view['user_recorded'] = Model_Lottery::getResults($view['lottery']['id'], $this->_uid);
        } else {
            $view['is_wished'] = false;
            $view['user_recorded'] = false;
        }

        //首页作品展示
        if ($this->_wedding['open_photography']) {
            $view['first_prize'] = Doctrine_Query::create()
                    ->from('WeddingPhotography')
                    ->where('wedding_id=?', $this->_id)
                    ->where('award_name=?', '一等奖')
                    ->limit(3)
                    ->fetchArray();
            $view['second_prize'] = Doctrine_Query::create()
                    ->from('WeddingPhotography')
                    ->where('wedding_id=?', $this->_id)
                    ->where('award_name=?', '二等奖')
                    ->limit(6)
                    ->fetchArray();
            $view['third_prize'] = Doctrine_Query::create()
                    ->from('WeddingPhotography')
                    ->where('wedding_id=?', $this->_id)
                    ->where('award_name=?', '三等奖')
                    ->limit(12)
                    ->fetchArray();
        }

        //点击次数
        DB::update('wedding')->set(array('hits' => $this->_wedding['hits'] + 1))->where('id', '=', $this->_id)->execute();

        $this->_title($this->_wedding['title']);
        $this->_render('_notice', array('wedding' => $this->_wedding, 'notice' => $notice), 'wedding/inc_notice');
        $this->_render('_body', $view,'wedding/index');
    }

    //报名列表
    function action_signs() {

        $view['wedding'] = $this->_wedding;

        if ($this->_uid) {
            $view['user_sign'] = Db_Wedding::getUserSign($this->_wedding['id'], $this->_uid);
        } else {
            $view['user_sign'] = array();
        }

        $view['sign_count'] = $this->_cache->get('sign_count' . $this->_id);
        if (!$view['sign_count']) {
            $view['sign_count'] = Db_Wedding::getCountSigner($this->_wedding['id']);
            $this->_cache->set('sign_count' . $this->_id, $view['sign_count'], 60);
        }

        $sid = Arr::getAll('sid');
        $q = Arr::getAll('q');

        $count = Doctrine_Query::create()
                ->select('s.id')
                ->from('WeddingSign s')
                ->where('s.wedding_id=?', $this->_id);

        $signs = Doctrine_Query::create()
                ->select('s.*')
                ->from('WeddingSign s')
                ->where('s.wedding_id=?', $this->_id)
                ->orderBy('s.id ASC');

        if ($sid) {
            $q = trim($q);
            $count->addWhere('s.id=?', $sid);
            $signs->addWhere('s.id=?', $sid);
        }
        if ($q) {
            $q = trim($q);
            $count->addWhere('(bridegroom_name LIKE ? OR bride_name LIKE ?)', array('%' . $q . '%', '%' . $q . '%'));
            $signs->addWhere('(bridegroom_name LIKE ? OR bride_name LIKE ?)', array('%' . $q . '%', '%' . $q . '%'));
        }

        $total_signs = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_signs,
                    'items_per_page' => 12,
                    'view' => 'pager/common',
        ));
        $signs = $signs->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        //计算排名
        foreach ($signs as $key => $p) {
            $pcount = Doctrine_Query::create()
                    ->from('WeddingSign')
                    ->select('id')
                    ->where('(good_num >?) OR (good_num=? AND id<?)', array($p['good_num'], $p['good_num'], $p['id']))
                    ->count();
            $signs[$key]['votekey'] = md5($this->GetIP() . $p['id'] . 'zjuwedding@zjg');
            $signs[$key]['topnum'] = $pcount + 1;
        }

        $view['photos'] = $signs;
        $view['pager'] = $pager;

        $this->_title('集体婚礼报名');
        $this->_render('_body', $view);
    }

    //报名
    function action_signform() {

        $sign_id = Arr::get($_GET, 'sign_id');
        $sign_action = 'addForm';
        $user_sign = array();
        $error = false;
        //修改
        if ($sign_id) {
            $user_sign = Doctrine_Query::create()
                    ->from('WeddingSign')
                    ->where('id=?', $sign_id)
                    ->addWhere('user_id=?', $this->_uid)
                    ->fetchOne();
            if (!$user_sign) {
                $error = '很抱歉，您还没有参加该活动！';
            } else {
                $sign_action = 'update';
            }
        }
        //新报名
        else {
            //报名前验证能否报名
            $sign = new Model_Weddingsign($this->_wedding['id'], $this->_uid, $sign_action);
            if (!$sign->signValidation()) {
                $error = $sign->getError();
            }
        }

        $view['error'] = $error;
        $view['user_sign'] = $user_sign;
        $view['wedding'] = $this->_wedding;
        $this->_title('在线报名 - ' . $this->_wedding['title']);
        $this->_render('_body', $view);
    }

    //报名提交
    function action_signsub() {
        $this->auto_render = false;
        if ($_POST) {

            //基本项验证
            $v = Validate::setRules($_POST, 'weddingsign');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
                exit;
            }
            //处理报名信息
            $sign = new Model_Weddingsign($post['wedding_id'], $this->_uid, $post['sign_action']);
            $sign->postData = $post;
            $sign_state = $sign->signSub();
            if ($sign_state) {
                echo $sign_state;
            } else {
                echo 'err#' . $sign->getError();
            }
            exit;
        }
    }

    //取消报名
    function action_cancelSign() {
        $wid = Arr::get($_GET, 'wid');
        //取消报名
        Doctrine_Query::create()
                ->delete('WeddingSign')
                ->where('user_id = ?', $this->_uid)
                ->andWhere('wedding_id = ?', $wid)
                ->execute();
    }

    //通知公告
    function action_notice() {
        $nid = Arr::get($_GET, 'nid');
        $view['notice'] = Doctrine_Query::create()
                ->from('Content')
                ->select('*')
                ->where('id=?', $nid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        $view['wedding'] = $this->_wedding;
        $this->_title('通知公告 - ' . $this->_wedding['title']);
        $this->_render('_body', $view);
    }

    //通知公告
    function action_past() {
        $view['notice'] = Doctrine_Query::create()
                ->from('Content')
                ->select('*')
                ->where('type=19')
                ->orderBy('id desc')
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        $view['wedding'] = $this->_wedding;
        $this->_title('往届回顾 - ' . $this->_wedding['title']);
        $this->_render('_body', $view);
    }

    //投票
    function action_ip() {
        $this->auto_render = false;
        echo 'ip:';
        echo $this->GetIP();
    }

    //投票
    function action_good() {
        $this->auto_render = false;
        $sign_id = Arr::get($_POST, 'sign_id');
        $votekey = Arr::get($_POST, 'votekey');
        $sponsors_id = Arr::get($_POST, 'sponsors_id');
        $ip = $this->GetIP();
        $ip = str_replace('.', '_', $ip);
        $sessvote = null;

        //时间未到
        if (!$this->_openvote) {
            exit('error');
        }

        //错误的sign
        if (!$sign_id) {
            exit('error');
        }

        //防止刷票
        $client_votekey = md5($this->GetIP() . $sign_id . 'zjuwedding@zjg');
        if ($client_votekey != $votekey) {
            exit('errorkey');
        }

        // 检查是否直接访问本页面
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url_array = explode('http://', $_SERVER['HTTP_REFERER']);
            $url = explode('/', $url_array[1]);
            if ($_SERVER['SERVER_NAME'] != $url[0]) {
                // 您不是从本站来的;
                exit('error');
            }
        } else {
            // 禁止直接访问此页;
            exit('error');
        }

        //每天最多投9票
        $vote_today = Doctrine_Query::create()
                ->select('id')
                ->from('WeddingVote')
                ->where('ip=?', array($ip))
                ->addWhere("to_days(created_at) = to_days(now())")
                ->count();
        if ($vote_today >= 8) {
            echo 'maximum';
            exit;
        }
        //sign vote
        if ($sign_id) {
            $sessvote = $this->_sess->get('sign_' . $ip . $sign_id);
            if ($sessvote) {
                echo 'voted';
                exit;
            } else {
                $voted = Doctrine_Query::create()
                        ->from('WeddingVote')
                        ->select('id')
                        ->where('sign_id=? AND ip=?', array($sign_id, $ip))
                        ->addWhere("to_days(created_at) = to_days(now())")
                        ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
                if ($voted) {
                    echo 'voted';
                    exit;
                }
            }
        }
        //product vote
        elseif ($sponsors_id) {
            $sessvote = $this->_sess->get('sponsors_' . $ip . $sponsors_id);
            if ($sessvote) {
                echo 'voted';
                exit;
            } else {
                $voted = Doctrine_Query::create()
                        ->from('WeddingVote')
                        ->where('sponsors_id=? AND ip=?', array($sponsors_id, $ip))
                        ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
                if ($voted) {
                    echo 'voted';
                    exit;
                }
            }
        } else {
            echo 'error';
            exit;
        }

        if ($sign_id) {
            $this->_sess->set('sign_' . $ip . $sign_id, 1);
            $wedding_sign = Doctrine_Query::create()
                    ->from('WeddingSign')
                    ->where('id=?', $sign_id)
                    ->fetchOne();
            $wedding_sign->good_num = $wedding_sign->good_num + 1;
            $wedding_sign->save();
        } else {
            $this->_sess->set('sponsors_' . $ip . $sponsors_id, 1);
        }

        $vote = new WeddingVote();
        $vote->ip = $ip;
        $vote->created_at = date("Y-m-d H:i:s");
        $vote->sign_id = $sign_id;
        $vote->sponsors_id = $sponsors_id;
        $vote->save();
        echo $vote->id;
        exit;
    }

    //获取ip
    function GetIP() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if (!empty($_SERVER["REMOTE_ADDR"]))
            $cip = $_SERVER["REMOTE_ADDR"];
        else
            $cip = "无法获取！";
        return $cip;
    }

    //获取抽奖结果
    public function action_lottery_results() {

        $this->auto_render = false;
        $error = null;

        //抽奖内容
        $lottery = Doctrine_Query::create()
                ->select('l.*')
                ->addSelect('(SELECT SUM(a.amount) FROM WeddingAwards a WHERE a.lottery_id = l.id) AS amount')
                ->addSelect('(SELECT SUM(b.has_been_drawn) FROM WeddingAwards b WHERE b.lottery_id = l.id) AS has_been_drawn')
                ->from('WeddingLottery l')
                ->where('l.wedding_id=?', $this->_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        //奖项内容
        $lottery_awards = Doctrine_Query::create()
                ->from('WeddingAwards')
                ->where('lottery_id=?', $lottery['id'])
                ->fetchArray();

        //用户抽奖历史
        $recorded = Model_Lottery::getResults($lottery['id'], $this->_uid);

        //抽奖前检测
        if (!$lottery) {
            $error = '很抱歉，该抽奖不存在';
        } elseif (!$this->_uid) {
            $error = '很抱歉，您还没有登陆，请登录后重试！';
        } elseif ($this->_sess->get('role') != '管理员' AND $this->_sess->get('role') != '校友(已认证)') {
            $error = '很抱歉，您目前帐号还没有通过审核！';
        } elseif (strtotime($lottery['start_date']) > time()) {
            $error = '很抱歉，抽奖尚未开始！';
        } elseif (strtotime($lottery['end_date']) < time()) {
            $error = '很抱歉，抽奖已经结束，欢迎下次参加！';
        } elseif ($lottery['has_been_drawn'] >= $lottery['amount']) {
            $error = '很遗憾，所有奖品已经抽完，欢迎下次参加，谢谢！';
        } elseif ($recorded) {
            $error = '很抱歉，您已经参加过抽奖活动，欢迎下次参加，谢谢！';
        }

        //返回错误并停止
        if ($error) {
            $return = array('result' => 'error', 'message' => $error);
            echo json_encode($return);
            exit;
        }

        // 总中奖概率,概率精度是100，这样比较好计算概率是否正常
        $arr_prize = array();
        $arr_prize[] = array('id' => 0, 'name' => '不中奖', 'rate' => (100 - ((int) $lottery['award_probability'])) . '%');
        $arr_prize[] = array('id' => 1, 'name' => '获奖', 'rate' => $lottery['award_probability'] . '%');

        //奖品级奖品抽取概率设置
        $arr_awards = array();
        foreach ($lottery_awards as $a) {
            $arr_awards[] = array('id' => $a['id'], 'angle' => $a['angle'], 'name' => $a['award_name'], 'rate' => $a['award_probability'] . '%');
        }

        //第一步获取是否中奖
        $first = $this->_get_bingo_index($arr_prize);

        //第二步，如果中奖从奖项中按概率随机获取一件奖品
        //初始值
        //未中奖
        $return = array(
            'result' => 'no',
            'awards_angle' => 0,
            'awards_id' => 0,
            'awards_name' => '未中奖',
            'message' => '很遗憾，你没有中奖，再接再厉!'
        );

        //随机获取奖品
        if ($first) {
            $awards_key = $this->_get_bingo_index($arr_awards);
            $awards_id = $arr_awards[$awards_key]['id'];
            $awards_name = $arr_awards[$awards_key]['name'];
            $awards_angle = $arr_awards[$awards_key]['angle'];
            $return = array(
                'result' => 'yes',
                'awards_angle' => $awards_angle,
                'awards_id' => $awards_id,
                'awards_name' => $awards_name,
                'message' => '恭喜您获得' . $awards_name . '，奖品领取方式请在投票结束后关注校友网集体婚礼专区。'
            );
        }

        //保存抽奖结果
        Model_Lottery::saveResults(array(
            'lottery_id' => $lottery['id'],
            'user_id' => $this->_uid,
            'awards_id' => $return['awards_id'],
            'lottery_results' => $return['awards_name'],
            'lottery_date' => date('Y-m-d H:i:s')
        ));

        //如果获奖更新本次抽奖奖品剩余数量
        if ($return['awards_id']) {
            $has_been_drawn = Doctrine_Query::create()
                    ->from('WeddingLotteryResults')
                    ->select('id')
                    ->where('awards_id=?', $awards_id)
                    ->addWhere('lottery_id=?', $lottery['id'])
                    ->count();

            $awards = Doctrine_Query::create()
                    ->from('WeddingAwards')
                    ->where('id=?', $awards_id)
                    ->fetchOne();
            $awards->has_been_drawn = $has_been_drawn;
            $awards->save();
        }

        //返回结果
        echo json_encode($return);
        exit;
    }

    //模拟抽奖获取每个奖品抽中几率
    function lottery_simulation($arr_awards, $count = 100) {
        $test = array(0, 0, 0, 0, 0, 0);
        $i = 0;
        while ($i++ < $count) {
            $index = $this->_get_bingo_index($arr_awards);
            $test[$index] ++;
        }
        foreach ($test as $k => $v) {
            echo $arr_awards[$k]['name'], '抽取奖品：', ($v / $count) * 100, '%<br />';
        }
    }

    // 获取中奖奖品下标
    function _get_bingo_index($arr_prize) {

        // 计算总概率精度
        $rand_num_max = 0;
        foreach ($arr_prize as $v) {
            $rand_num_max += $v['rate'];
        }

        // 初始化随机数，奖品区间
        $rand_num = mt_rand(1, $rand_num_max);
        $left_interval = 0;
        $right_interval = 0;
        $last_right_interval = 0;

        foreach ($arr_prize as $key => $v) {
            // 左区间
            $left_interval = $last_right_interval;
            // 右区间
            $right_interval = $left_interval + $v['rate'];
            // 上一个右区间
            $last_right_interval = $right_interval;
            // 判断随机数是否落在对应的区间
            if ($left_interval < $rand_num && $rand_num <= $right_interval) {
                return $key;
            }
        }
    }

    //发布祝福
    public function action_wishform() {
        $this->auto_render = False;
        $view['wedding'] = $this->_wedding;
        $wedding_id = Arr::get($_POST, 'wedding_id');
        if ($_POST) {
            $content = Arr::get($_POST, 'content');
            if (strlen($content) < 5) {
                echo Candy::MARK_ERR . '字数太少了，多写一些吧：）';
                exit;
            }
            if (!$this->_uid) {
                echo Candy::MARK_ERR . '您还没有登陆，请先登陆，谢谢！';
                exit;
            }
            if ($this->_sess->get('role') != '管理员' AND $this->_sess->get('role') != '校友(已认证)') {
                echo Candy::MARK_ERR . '很抱歉，您目前帐号还没有通过审核！';
                exit;
            }

            if ($content AND $wedding_id and $this->_uid) {
                $wish = new WeddingWish();
                $wish->wedding_id = $this->_wedding['id'];
                $wish->user_id = $this->_uid;
                $wish->content = $content;
                $wish->created_at = date('Y-m-d H:i:s');
                $wish->save();
                $back = array(
                    'status' => 1,
                    'id' => $wish->id,
                    'content' => $content,
                    'created_at' => '刚刚',
                    'realname' => $this->_sess->get('realname'),
                );
                echo json_encode($back);
                exit;
            } else {
                echo Candy::MARK_ERR . ' 内容介绍是不是有点少了呢？';
            }
            exit;
        }
        echo View::factory('wedding/wish_form', $view);
    }

    //发布祝福
    public function action_wish() {
        $view['wedding'] = $this->_wedding;
        $view['wish'] = Doctrine_Query::create()
                ->from('WeddingWish')
                ->where('wedding_id=?', $this->_wedding['id'])
                ->limit(100)
                ->orderBy('id desc')
                ->fetchArray();

        $this->_title('校友祝福 - ' . $this->_wedding['title']);
        $this->_render('_body', $view);
    }

    //摄影作品
    function action_photography() {

        $view['wedding'] = $this->_wedding;
        $q = Arr::getAll('q');
        $award_name = Arr::getAll('award', '三等奖');
        $pagesize=9;
        
        if (!in_array($award_name, array('一等奖', '二等奖', '三等奖', '入围奖'))) {
            $award_name = '三等奖';
        }
        
        if($award_name=='入围奖'){
            $pagesize=12;
        }
        
        $view['award_name'] = $award_name;

        $count = Doctrine_Query::create()
                ->select('s.id')
                ->from('WeddingPhotography s')
                ->where('s.wedding_id=?', $this->_id)
                ->addWhere('s.award_name=?', $award_name);

        $signs = Doctrine_Query::create()
                ->select('s.*')
                ->from('WeddingPhotography s')
                ->where('s.wedding_id=?', $this->_id)
                ->addWhere('s.award_name=?', $award_name)
                ->orderBy('s.id ASC');

        if ($q) {
            $q = trim($q);
            $count->addWhere('(s.title LIKE ? OR s.author LIKE ?)', array('%' . $q . '%', '%' . $q . '%'));
            $signs->addWhere('(s.title LIKE ? OR s.author LIKE ?)', array('%' . $q . '%', '%' . $q . '%'));
        }

        $total_signs = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_signs,
                    'items_per_page' => $pagesize,
                    'view' => 'pager/common',
        ));
        $signs = $signs->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $view['photos'] = $signs;
        $view['pager'] = $pager;

        $this->_title('集体婚礼摄影作品展示');
        $this->_render('_body', $view);
    }

    //上传照片
    public function action_uploadphoto() {
        $wedding = $this->_wedding;
        $view['wedding'] = $wedding;
        if ($_POST) {

            foreach ($_POST as $key => $value) {
                $this->_sess->set('uploader_' . $key, $value);
            }

            $author = Arr::get($_POST, 'author');
            $title = Arr::get($_POST, 'title');
            $finish_year = Arr::get($_POST, 'finish_year');
            $speciality = Arr::get($_POST, 'speciality');
            $tel = Arr::get($_POST, 'tel');
            $img_path = Arr::get($_POST, 'img_path');
            $original_img_path = Arr::get($_POST, 'original_img_path');
            $wedding_id = Arr::get($_POST, 'wedding_id');
            $company = Arr::get($_POST, 'company');
            

            if (!$wedding['is_upload_photography'] OR time() < strtotime($wedding['photography_start']) OR time() > strtotime($wedding['photography_finish'])) {
                echo Candy::MARK_ERR . '很抱歉，暂未开放或已经过期，谨请留意通知，谢谢！';
                exit;
            }

            if (!$title OR ! $author OR ! $finish_year OR ! $speciality OR ! $tel OR ! $company) {
                echo Candy::MARK_ERR . '添加失败，注意带“*”项必须填写';
                exit;
            }

            if (!$img_path OR ! $original_img_path) {
                echo Candy::MARK_ERR . '照片还没有上传，请检查是否上传';
                exit;
            }
            
            //已上传总数
            $uploaded = $record = Doctrine_Query::create()
                    ->from('WeddingPhotography')
                    ->select('id')
                    ->where('wedding_id=?', $wedding_id)
                    ->addWhere('author=?', trim($author))
                    ->addWhere('tel=?', trim($tel))
                    ->count();
            
            if($uploaded>=5){
                echo Candy::MARK_ERR . '很抱歉，每人做多上传5张';
                exit;
            }

            $photography = new WeddingPhotography();
            $photography->wedding_id = $wedding_id;
            $photography->created_at = date('Y-m-d H:i:s');
            $photography->fromArray($_POST);
            $photography->save();
            if ($photography->id) {
                echo $photography->id;
            } else {
                echo Candy::MARK_ERR . ' 照片添加失败，请检查内容是否添加完整';
            }
            exit;
        }
        
        $this->_title('集体婚礼摄影作品上传');
        $this->_render('_body', $view);
    }

}
