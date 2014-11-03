<?php

class Model_Weddingsign {

    private $wedding_id;
    private $wedding;
    private $_uid;
    private $user;
    private $error;
    private $action;
    private $userSign;
    public $postData;
    public $configBase;

    //初始化报名模型(集体婚礼id，用户id,$action)
    //action:addForm,add,updateForm,update
    function __construct($wedding_id = null, $user_id = null, $action = 'addForm') {
        $this->error = false;
        $this->postData = array();
        $this->_uid = $user_id;
        $this->wedding_id = $wedding_id;
        $this->action = $action;
        $this->wedding = Db_Wedding::getById($wedding_id);
        $this->user = Db_User::getInfoById($this->_uid);
        $this->configBase = Kohana::config('config')->base;
        $this->category = array();
    }

    //能否执行addFom和add和updateForm和update
    public function signValidation() {

        //每次都需要验证的
        if (!$this->wedding_id) {
            $this->error = '很抱歉，请指定集体婚礼id！';
            return false;
        }

        //无集体婚礼信息
        if (!$this->wedding) {
            $this->error = '很抱歉，集体婚礼不存在或已被删除！';
            return false;
        }

        //无指定用户id
        if (!$this->_uid) {
            $this->error = '很抱歉，您还没有登录或已过期，请重新登录！';
            return false;
        }

        //无用户信息
        if (!$this->user) {
            $this->error = '很抱歉，用户不存在；';
            return false;
        }

        //集体婚礼基本限制
        if (time() >= strtotime($this->wedding['start'])) {
            $this->error = '很抱歉，集体婚礼已经开始了，不能再报名了！';
            return false;
        }

        //用户没有通过审核
        if ($this->user['role'] != '校友(已认证)' AND $this->user['role'] != '管理员') {
            $this->error = '很抱歉，您的帐号暂时还没有通过审核，不能报名哦，请稍等等吧:)';
            if (isset($this->configBase['manager_tel']) AND $this->configBase['manager_tel']) {
                $this->error.='<br><span style="color:#999">说明：新注册帐号通常（注册时有找到档案信息）会在注册后半个工作日内审核，如急需通过，请与校友总会<b>' . $this->configBase['manager_name'] . '</b>联系（电话' . $this->configBase['manager_tel'] . '）。</span>';
            }
            return false;
        }

        //暂停集体婚礼
        if ($this->wedding['is_suspend']) {
            $this->error = '很抱歉，集体婚礼已暂停，有事请与管理员联系吧:) ';
            return false;
        }

        //情况1、新报名表单和添加
        if ($this->action == 'addForm' OR $this->action == 'add') {

            //报名人数及票数数量验证
            $sign_all = Doctrine_Query::create()
                    ->select('s.id')
                    ->from('WeddingSign s')
                    ->where('s.wedding_id = ?', $this->wedding_id)
                    ->count();

            //是否是重复报名
            if (self::isJoined($this->wedding_id, $this->_uid)) {
                $this->error = '很抱歉，您已经报名了本次集体婚礼，不需要再次报名了；';
                return false;
            }

            //停止报名
            if ($this->wedding['is_stop_sign']) {
                $this->error = '很抱歉，暂停集体婚礼报名，如有问题，请与管理员联系！';
                return false;
            }

            //检查名额是否充足
            if ($this->wedding['sign_limit'] > 0 AND $sign_all >= $this->wedding['sign_limit']) {
                $this->error = '很遗憾，名额已经满了，欢迎下次参加:) ';
                return false;
            }
        }

        //情况2、添加到数据库或修改数据库报名信息
        if ($this->action == 'add' OR $this->action == 'update') {
            //集体婚礼备注内容字数限制
            if (isset($this->postData['remarks']) AND UTF8::strlen($this->postData['remarks']) > 255) {
                $this->error = '很抱歉，备注文字字数超过限制(255)，请编辑后重试:(';
                return false;
            }
            
            //集体婚礼备注内容字数限制
            if ($this->postData['bridegroom_name']!=$this->user['realname'] && $this->postData['bride_name']!=$this->user['realname']) {
                $this->error = '很抱歉，新郎或新娘至少有一方是当前注册校友！';
                return false;
            }
            
        }

        if (!$this->action) {
            $this->error = '很抱歉，非法操作！';
            return false;
        }

        return true;
    }

    //当前用户是否已经报名
    public static function isJoined($wedding_id, $user_id = 0) {
        $signed = Doctrine_Query::create()
                ->select('id')
                ->from('WeddingSign')
                ->where('wedding_id = ? AND user_id = ?', array($wedding_id, $user_id))
                ->execute(array(), 6);
        return (bool) $signed;
    }

    //返回错误
    public function getError() {
        return $this->error;
    }

    public function getWedding() {
        return $this->wedding;
    }

    //返回用户报名信息
    public function getUserSign() {
        return $this->userSign;
    }

    //保存或添加报名信息
    //返回成功sign_id或具体错误信息
    public function signSub() {

        if (!$this->signValidation()) {
            return False;
        }

        if (isset($this->postData['is_anonymous']) AND $this->postData['is_anonymous']) {
            $this->postData['is_anonymous'] = 1;
        } else {
            $this->postData['is_anonymous'] = 0;
        }

        //添加新报名
        if ($this->action == 'add') {
            $sign = new WeddingSign();
            $sign->fromArray($this->postData);
            $sign->user_id = $this->_uid;
            $sign->sign_at = date('Y-m-d H:i:s');

            //保存报名信息
            $sign->save();
            if ($sign->id) {
                //返回sign_id
                return $sign->id;
            } else {
                $this->error = '很抱歉，报名失败，可能是网站错误，请与管理员联系';
                return False;
            }
        }
        //修改报名信息
        elseif ($this->action == 'update') {
            $this->userSign = Doctrine_Query::create()
                    ->from('WeddingSign')
                    ->where('wedding_id=?', $this->wedding_id)
                    ->addWhere('user_id=?', $this->_uid)
                    ->fetchOne();
            if ($this->userSign) {
                $this->userSign->synchronizeWithArray($this->postData);
                $this->userSign->save();
                return $this->userSign->id;
            } else {
                $this->error = '很抱歉，您还没有报名！';
                return False;
            }
        }
        return false;
    }

}
