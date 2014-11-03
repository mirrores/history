<?php

class Controller_Feedback extends Layout_Main {

    public function before() {
        parent::before();
        $this->auto_render = false;
    }

    //发送错误报告到程序猿邮件
    function action_senderror() {
        $error = Arr::get($_POST, 'error');
        $mailer = new Model_Mailer('first');
        $body = '网站有错误，请检查！';
        $body.= '<br>' . $error;
        $body.='<br>用户id:' . Session::instance()->get('id');
        $body.='<br>用户姓名:' . Session::instance()->get('realname');
        $body.='<br>用户邮箱:' . Session::instance()->get('account');
        $body.='<br>用户角色:' . Session::instance()->get('role');
        $body.= '<br>ip:' . $this->GetIP();
        $mailer->sendError($body);
    }

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

}
