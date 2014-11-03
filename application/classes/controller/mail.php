<?php

//校友邮箱
class Controller_Mail extends Layout_Main {

    //首页
    function action_index() {
        $mail = Doctrine_Query::create()
                ->from('ZuaaMail')
                ->where('user_id=?', $this->_uid)
                ->addWhere('progress_rate=?', '已开通')
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        $view['mail'] = $mail;
        $this->_render('_body', $view);
    }

    //登录邮箱
    function mailLogin($mail) {
        if ($mail) {
            $time = time();
            $username = $mail['username'];
            $hostname = 'zuaa.zju.edu.cn';
            $login_secret = md5("zjdxzuaa" . $username . $hostname . $time);
            $url = 'http://mail.zuaa.zju.edu.cn/cgi-bin/login?userid=' . $username . '@' . $hostname . '&' . 'timestamp=' . $time . '&authid=' . $login_secret;
            //$url = 'http://mail.zuaa.zju.edu.cn/';
            $this->_redirect($url);
        }
    }

    function action_apply() {
        $this->auto_render = False;

        //用户名合法性
        if (!$this->_uid) {
            echo Candy::MARK_ERR . '很抱歉，您还没有登录！ ';
            exit;
        }

        //用户名合法性
        if ($this->_sess->get('role') != '校友(已认证)' AND $this->_sess->get('role')!= '管理员') {
            echo Candy::MARK_ERR . '很抱歉，您的帐号暂时还没有通过审核';
            return false;
        }

        if ($_POST) {
            $valid = Validate::setRules($_POST, 'apply_mail');
            $post = Validate::getData();
            //内容填写验证
            if (!$valid->check()) {
                echo Candy::MARK_ERR .
                $valid->outputMsg($valid->errors('validate'));
            }
            //格式验证
            else {

                $username = trim($post['username']);

                //用户名合法性
                if (!preg_match("/^[\-\_a-zA-Z0-9]+$/", $username)) {
                    echo Candy::MARK_ERR . '很抱歉，登录名只能包含字母、数字和下划线！';
                    exit;
                }
                if ($post['password'] != $post['password2']) {
                    echo Candy::MARK_ERR . '很抱歉，两次密码输入不一致，请重新输入，谢谢！';
                    exit;
                }

                //查找是否有重复
                $registered = Doctrine_Query::create()
                        ->from('ZuaaMail')
                        ->where('username=?', $username)
                        ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

                //有冲突
                if ($registered AND $registered['user_id'] == $this->_sess->get('id')) {
                    echo Candy::MARK_ERR . '很抱歉，您已经申请过' . $registered['username'] . '@zuaa.zju.edu.cn邮箱了，请等待开通！';
                    exit;
                } elseif ($registered) {
                    echo Candy::MARK_ERR . '很抱歉，登录名已经被占用，请选用其他名称！';
                    exit;
                }
                //不存在冲突
                else {
                    $this->save_log(array(
                        'user_id' => $this->_sess->get('id'),
                        'username' => $username,
                        'password' => $post['password'],
                        'progress_rate' => '等待开通',
                    ));
                    echo 'temp_ok';
                    exit;
                }
            }
        }
    }

    //申请
    function action_apply_api_bak() {
        $this->auto_render = False;

        //用户名合法性
        if (!$this->_uid) {
            echo Candy::MARK_ERR . '很抱歉，您还没有登录！ ';
            exit;
        }
        $domain = '10.202.21.5';
        $port = '6195';

        if ($_POST) {
            $valid = Validate::setRules($_POST, 'apply_mail');
            $post = Validate::getData();
            //内容填写验证
            if (!$valid->check()) {
                echo Candy::MARK_ERR .
                $valid->outputMsg($valid->errors('validate'));
            }
            //格式验证
            else {
                //用户名合法性
                if (!preg_match("/^[A-Za-z0-9_]/", $post['username'])) {
                    echo Candy::MARK_ERR . '很抱歉，用户名只能包含字母、数字和下划线！';
                    exit;
                }
                if ($post['password'] != $post['password2']) {
                    echo Candy::MARK_ERR . '很抱歉，两次密码输入不一致，请重新输入，谢谢！';
                    exit;
                }
                $username = trim($post['username']);
                //建立通信
                Candy::import('socket');
                $s = new Socket($domain, $port);
                $s->sendmsg('');

                //查找是否有重复
                $back = mb_convert_encoding($s->sendmsg($this->search_str($username)), "UTF-8", "GBK");

                //有冲突
                if (strstr($back, '+')) {
                    echo Candy::MARK_ERR . '很抱歉，申请出错：原因“' . $back;
                    exit;
                }
                //不存在冲突
                elseif (strstr($back, '-')) {
                    //数据库保存注册日志
                    $this->save_log(array(
                        'user_id' => $this->_sess->get('id'),
                        'username' => $username,
                        'password' => $post['password'],
                        'progress_rate' => '等待开通',
                    ));
                    echo 'temp_ok';
                    exit;
                }
                //其他情况
                else {
                    echo Candy::MARK_ERR . '异常错误:' . $back . '，请与管理员联系或重试！';
                    exit;
                }
            }
        }
    }

    //删除邮箱
    function action_del() {
        $this->auto_render = False;
        $username = trim($_GET['username']);
        $domain = '10.202.20.19';
        $port = '9998';

        //导入类
        Candy::import('socket');
        $s = new Socket($domain, $port);
        $s->sendmsg('');

//	$searchback = $s->sendmsg($this->search_str($username));
//        echo '查询结果：'.$searchback;
        //$back = $s->sendmsg($this->del_str($username));
        //echo '<br>删除结果：'.$back;
        //exit;
    }

    function search_str($username) {
        $msg = <<<HTML
search{
uid=$username
domain=zuaa.zju.edu.cn
}
.

HTML;
        return $msg;
    }

    function add_str($username, $password) {
        $msg = <<<HTML
add{
uid=$username
domain=zuaa.zju.edu.cn
userPassword=$password
}
.

HTML;
        return $msg;
    }

    function del_str($username) {
        $msg = <<<HTML
del{
uid=$username
domain=zuaa.zju.edu.cn
}
.

HTML;
        return $msg;
    }

    //保存注册日志
    function save_log($data) {
        if ($data) {
            $post['user_id'] = $data['user_id'];
            $post['username'] = $data['username'];
            $post['password'] = $data['password'];
            $post['create_at'] = date('Y-m-d H:i:s');
            $post['progress_rate'] = isset($data['progress_rate']) ? $data['progress_rate'] : null;
            $mail = new ZuaaMail();
            $mail->fromArray($post);
            $mail->save();
            return $mail->id;
        }
    }

    function action_testalterUserInfo() {
        Candy::import('coremail');
        $api = new CoremailAPI;
        if (!$api->open("10.202.21.5")) {
            echo($api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else if (!$api->hasUser("admin@zuaa.zju.edu.cn") || $api->getErrorCode()) {
            echo("Login fail : " . $api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else {
            echo("Login ok: " . $api->getResult() . "\n");
        }
        $api->close();
    }

    function action_testlogin() {
        Candy::import('coremail');
        $api = new CoremailAPI;
        if (!$api->open("10.202.21.5")) {
            echo($api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else if (!$api->call("cmd=5&user_at_domain=admin@zuaa.zju.edu.cn", array("style" => "1", "language" => "2")) || $api->getErrorCode()) {
            echo("Login fail : " . $api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else {
            echo("Login ok: " . $api->getResult() . "\n");
        }
        $api->close();
    }

    function action_testcoremail() {
        $api = new CoremailAPI;
        if (!$api->open("10.202.21.5")) {
            echo($api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else if (!$api->call("cmd=5&user_at_domain=admin@develop.com", array("style" => "1", "language" => "2")) || $api->getErrorCode()) {
            echo("Login fail : " . $api->getErrorCode() . " : " . $api->getErrorString() . "\n");
        } else {
            echo("Login ok: " . $api->getResult() . "\n");
        }
        $api->close();
    }

}

?>
