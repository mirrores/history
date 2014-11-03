<?php

//论坛
class Controller_Api_Bbs_bak extends Layout_Mobile {

    function before() {
        parent::before();
    }

    //获取话题分类
    function action_category() {
        $data = array();
        $data[] = array(
            'name' => '公共园地',
            'parameter' => 'all',
        );
        $data[] = array(
            'name' => '加入的校友会',
            'parameter' => 'joinaa',
        );
        $data[] = array(
            'name' => '其他校友会',
            'parameter' => 'joined',
        );
        $this->response($data, 'list', 'list');
    }

    //话题列表
    function action_index() {

        $q = $this->getParameter('q');
        $limit = $this->getParameter('limit', 15);
        $page = $this->getParameter('page', 1);
        $max_id = $this->getParameter('max_id');
        $since_id = $this->getParameter('since_id');
        $cat = $this->getParameter('cat','all');
        $offset = ($page - 1) * $limit;
        $bbs_ids = null;
        
        //置顶话题
        $fixed = Doctrine_Query::create()
                ->select('u.id,u.aa_id,u.subject,u.bbs_id,u.title,u.user_id,u.comment_at,u.create_at,u.new_replyid,u.reply_num,u.hit,u.is_good,u.is_fixed')
                ->addSelect('a.name AS aa_name')
                ->addSelect('user.id,user.realname,user.sex,user.speciality,user.start_year')
                ->addSelect('ru.realname AS replyname,ru.sex AS replysex')
                ->addSelect('IF(u.is_fixed = 1 AND u.aa_id=0,1,0) AS public_fixed')
                ->from('BbsUnit u')
                ->leftJoin('u.User user')
                ->leftJoin('u.Ruser ru')
                ->leftJoin('u.Aa a');

        //最新主题
        $unit = Doctrine_Query::create()
                ->select('u.id,u.aa_id,u.subject,u.bbs_id,u.title,u.user_id,u.comment_at,u.create_at,u.new_replyid,u.reply_num,u.hit,u.is_good,u.is_fixed')
                ->addSelect('a.name AS aa_name')
                ->addSelect('user.id,user.realname,user.sex,user.speciality,user.start_year')
                ->addSelect('ru.realname AS replyname,ru.sex AS replysex')
                ->from('BbsUnit u')
                ->leftJoin('u.User user')
                ->leftJoin('u.Ruser ru')
                ->leftJoin('u.Aa a');

        //默认排序
        $list_order_by = 'case when u.comment_at IS NOT NULL then u.comment_at
                 when u.comment_at IS NULL then u.create_at end DESC';

        //总会指定话题有限排序
        if ($cat == 'all' OR empty($cat)) {
            $fixed_order_by = 'public_fixed DESC,case when u.comment_at IS NOT NULL then u.comment_at
                 when u.comment_at IS NULL then u.create_at end DESC';
        } 
        
        //地方校友会
        else {
            $fixed_order_by = 'is_fixed DESC,case when u.comment_at IS NOT NULL then u.comment_at
                 when u.comment_at IS NULL then u.create_at end DESC';
        }

        //公共交流区
        if ($cat == 'all' or empty($cat)) {
            $fixed->where('u.aa_id>=0');
            $unit->where('u.aa_id>=0');
        }
        //加入的校友会
        elseif ($cat == 'joined') {
            if (!$this->_uid) {
                $this->error('您还没有登录或加入任何地方校友会');
            } else {
                $fixed->whereIn('u.aa_id', Model_User::aaIds($this->_uid));
                $unit->whereIn('u.aa_id', Model_User::aaIds($this->_uid));
            }
        }
        //其他校友会
        elseif ($cat == 'other') {
            if ($this->_uid) {
                $aa_ids = Model_User::aaIds($this->_uid);
                $aa_ids[] = 0;
            } else {
                $aa_ids[] = 0;
            }
            $fixed->whereNotIn('u.aa_id', $aa_ids);
            $unit->whereNotIn('u.aa_id', $aa_ids);
        } elseif ($cat == 'my') {
            $fixed->where('u.user_id=?', $this->_uid);
            $unit->where('u.user_id=?', $this->_uid);
        } else {
            $fixed->where('u.aa_id>=0');
            $unit->where('u.aa_id>=0');
        }

        //置顶话题
        $fixed_list = array();
        if ($page == 1) {
            if ($cat == 'all' OR empty($cat)) {
                $fixed_limit = 1;
            } else {
                $fixed_limit = 3;
            }
            $fixed_list = $fixed->addWhere('u.is_fixed = ?', TRUE)
                            ->addWhere('u.is_closed = ?', FALSE)
                            ->limit($fixed_limit)
                            ->orderBy($fixed_order_by)->fetchArray();
        }

        //最新话题
        $last_list = $unit->addWhere('u.is_closed = ?', FALSE)
                        ->offset($offset)
                        ->limit($limit)
                        ->orderBy($list_order_by)->fetchArray();

        $back = array();
        $back['fixed'] = $this->createXmlArray($fixed_list);
        $back['list'] = $this->createXmlArray($last_list);
        $this->response($back, null, null);
    }

    //重新设置返回字段
    function createXmlArray($units) {
        $data = array();
        if (count($units) > 0) {
            $subject = Kohana::config('bbs.subject');
            foreach ($units AS $key => $u) {
                $data[$key]['id'] = $u['id'];
                $data[$key]['title'] = $u['title'];
                $data[$key]['subject'] = $subject[$u['subject']];
                $data[$key]['aa_id'] = $u['aa_id'];
                $data[$key]['aa_name'] = $u['aa_name'];
                $data[$key]['bbs_id'] = $u['bbs_id'];
                $data[$key]['bbs_name'] = '交流论坛';
                $data[$key]['is_good'] = $u['is_good'] ? 'true' : 'false';
                $data[$key]['is_fixed'] = $u['is_fixed'] ? 'true' : 'false';
                $data[$key]['uid'] = $u['user_id'];
                $data[$key]['reply_uid'] = $u['new_replyid'];
                $data[$key]['hits'] = $u['hit'] ? $u['hit'] : 0;
                $data[$key]['comments_count'] = $u['reply_num'] ? $u['reply_num'] : 0;
                $data[$key]['create_date'] = $u['create_at'];
                $data[$key]['str_create_date'] = Date::ueTime($u['create_at']);
                $data[$key]['update_date'] = $u['comment_at'] ? $u['comment_at'] : '';
                $data[$key]['str_update_date'] = $u['comment_at'] ? Date::ueTime($u['comment_at']) : '';
                $data[$key]['allow_comment'] = 'true';
                $data[$key]['statuses'] = $u['new_replyid'] ? $u['replyname'] . $data[$key]['str_update_date'] . '回复' : $u['User']['realname'] . $data[$key]['str_create_date'] . '发表';
                $avatar_id = $u['new_replyid'] ? $u['new_replyid'] : $u['user_id'];
                $avatar_sex = $u['new_replyid'] ? $u['replysex'] : $u['User']['sex'];
                $data[$key]['updater_avatar'] = $this->_siteurl . Model_User::avatar($avatar_id, 48, $avatar_sex);
                $data[$key]['user']['id'] = $u['user_id'];
                $data[$key]['user']['realname'] = $u['User']['realname'];
                $data[$key]['user']['speciality'] = $u['User']['start_year'] && $u['User']['speciality'] ? $u['User']['start_year'] . '级' . $u['User']['speciality'] : $u['User']['speciality'];
                $data[$key]['user']['sex'] = $u['User']['sex'];
                $data[$key]['user']['profile_image_url'] = $this->_siteurl . Model_User::avatar($u['User']['id'], 48, $u['User']['sex']);
                $data[$key]['user']['avatar_large'] = $this->_siteurl . Model_User::avatar($u['User']['id'], 128, $u['User']['sex']);
            }
        } else {
            return '';
        }
        return $data;
    }

    /**
      +------------------------------------------------------------------------------
     * 查看主题详情
      +------------------------------------------------------------------------------
     */
    function action_view() {
        $id = $this->getParameter('id');
        $preview = $this->getParameter('preview');
        $subject = Kohana::config('bbs.subject');
        $u = Doctrine_Query::create()
                ->select('u.*,p.content AS content')
                ->addSelect('a.id,a.sname,b.id,b.name,b.aa_id')
                ->addSelect('user.id,user.realname,user.sex,user.speciality,user.start_year')
                ->from('BbsUnit u')
                ->leftJoin('u.Post p')
                ->leftJoin('u.User user')
                ->leftJoin('u.Bbs b')
                ->leftJoin('b.Aa a')
                ->where('u.id=?', $id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        if (!$u) {
            $this->error('话题不存在或已经被删除！');
        } else {
            Model_Bbs::unitHit($id);
        }

        $event = null;
        $signs = null;
        $total_sign = 0;
        if ($u['event_id']) {

            $event = Doctrine_Query::create()
                    ->select('e.*, a.name,a.id,cb.name')
                    ->addSelect('(SELECT eb.id FROM Album eb WHERE eb.event_id = e.id) AS album_id')
                    ->from('Event e')
                    ->leftJoin('e.Aa a')
                    ->leftJoin('e.Club cb')
                    ->where('e.id = ?', $u['event_id'])
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

            // 所有报名记录
            $signs = Doctrine_Query::create()
                    ->select('s.*, u.id, u.realname')
                    ->from('EventSign s')
                    ->leftJoin('s.User u')
                    ->where('event_id = ?', $event['id'])
                    ->orderBy('sign_at ASC')
                    ->fetchArray();
            if ($signs) {
                foreach ($signs AS $s) {
                    $total_sign = $total_sign + $s['num'];
                }
            }
        }

        $data = array();
        $data['id'] = $u['id'];
        $data['title'] = $u['title'];
        $data['subject'] = $subject[$u['subject']];
        $data['aa_id'] = $u['Bbs']['aa_id'];
        $data['aa_name'] = $u['Bbs']['aa_id'] > 0 ? $u['Bbs']['Aa']['sname'] . '校友会' : '校友总会';
        $data['bbs_id'] = $u['bbs_id'];
        $data['bbs_name'] = $u['Bbs']['name'];
        $data['is_good'] = $u['is_good'] ? 'true' : 'false';
        $data['is_fixed'] = $u['is_fixed'] ? 'true' : 'false';
        $data['uid'] = $u['user_id'];
        $data['hits'] = $u['hit'] ? $u['hit'] : 0;
        $data['comments_count'] = $u['reply_num'] ? $u['reply_num'] : 0;
        $data['create_data'] = $u['create_at'];
        $data['str_create_data'] = Date::ueTime($u['create_at']);
        $data['update_data'] = $u['comment_at'] ? $u['comment_at'] : $data['create_data'];
        $data['str_update_data'] = Date::ueTime($data['update_data']);
        $data['allow_comment'] = 'true';
        $htmlAndPics = Common_Global::standardHtmlAndPics($u['content'], $u['title']);
        $u['content'] = $htmlAndPics['html'];
        $data['content'] = View::factory('api/bbs/view', array('u' => $u, 'event' => $event, 'signs' => $signs,'total_sign'=>$total_sign));
        $data['pics'] = $htmlAndPics['pics'];
        $data['user']['id'] = $u['user_id'];
        $data['user']['realname'] = $u['User']['realname'];
        $data['user']['speciality'] = $u['User']['start_year'] && $u['User']['speciality'] ? $u['User']['start_year'] . '级' . $u['User']['speciality'] : $u['User']['speciality'];
        $data['user']['sex'] = $u['User']['sex'];
        $data['user']['profile_image_url'] = $this->_siteurl . Model_User::avatar($u['user_id'], 48, $u['User']['sex']);
        $data['user']['avatar_large'] = $this->_siteurl . Model_User::avatar($u['user_id'], 128, $u['User']['sex']);
        if ($preview) {
            echo $data['content'];
        } else {
            $this->response($data);
        }
    }

}

?>
