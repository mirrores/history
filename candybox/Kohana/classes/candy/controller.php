<?php

class Candy_Controller extends Kohana_Controller_Template {

    public $_debug = false;
    public $_dev = false;
    public $template = 'xhtml';
    protected $_sess;
    private $_flash_msg_key = 'candy_flash_msg';
    public $_cache;
    public $_filecache;
    public $_config;
    //网站配置
    public $_setting;

    // 预设视图变量
    function before() {

        parent::before();

        ob_start();

        //初始化缓存组件
        $this->_cache = Cache::instance('xcache');
        $this->_config = Kohana::config('config');
        
        // ajax 请求阻止渲染布局视图
        if (Request::$is_ajax) {
            $this->auto_render = false;
        }

        //获取网站配置
        $this->_setting = Model_Config::get();

        //网站基本参数
        View::set_global('_CONFIG', $this->_config);
        View::set_global('_SETTING', $this->_setting);

        // session
        $sid = Arr::get($_GET, 'SESSID');
        $this->_sess = Session::instance(null, $sid);
        view::set_global('_SESS', $this->_sess);
        $request = $this->request;
        View::set_global('_C', $request->controller);
        View::set_global('_A', $request->action);
        View::set_global('_URI', $request->uri);
        View::set_global('_PID', $request->param('id'));
        View::set_global('_URL', URL::site($request->uri) . URL::query());

        // FLASH MESSAGE
        $flash_msg = $this->_sess->get($this->_flash_msg_key);
        if ($flash_msg) {
            View::set_global('_FLASH', $flash_msg);
            $this->_sess->delete($this->_flash_msg_key);
        }
    }

    // 切换布局
    function _layout($file) {
        $this->template = View::factory($file);
    }

    /**
     * 重定向简写
     * @param <type> $url
     */
    function _redirect($url) {
        $this->request->redirect($url);
    }

    function _conf($group) {
        return Kohana::config($group);
    }

    // 视图 $_title 设置
    function _title($title) {
        $join_title = '';
        if (isset($this->template->_title)) {
            $join_title = htmlspecialchars($title) . ' - ' . $this->template->_title;
        } else {
            $join_title = htmlspecialchars($title);
        }
        $this->template->_title = $join_title;
    }

    /**
     * 加入自定义的header meta media
     * @param <type> $string
     */
    function _custom_media($string) {

        if (isset($this->template->_custom_media)) {
            $this->template->_custom_media .= $string . "\n";
        } else {
            $this->template->_custom_media = $string . "\n";
        }
    }

    /**
     * 渲染指定视图
     * @param <type> $position
     * @param <type> $params
     * @param <type> $uri
     */
    function _render($position, $params = null, $uri = null) {
        $request = $this->request;
        $view_path = APPPATH . 'views/';
        $folder = $request->controller;
        $view_file = $request->action;

        if (!is_string($uri)) {
            $uri = $folder . '/' . $view_file;
        }

        if (!is_file($view_path . $uri . EXT)) {
            if (!file_exists($view_path . $folder)) {
                @mkdir($view_path . $folder);
            }
            file_put_contents($view_path . $uri . EXT, '<!-- ' . $uri . ':' . $position . ' -->');
        }

        $this->template->$position = View::factory($uri, $params);
    }

    function after() {
        parent::after();

        if ($this->_dev == true && !Request::$is_ajax) {
            $this->showDevTools();
        }

        if ($this->_debug == true && !Request::$is_ajax) {
            // $this->request->response .= View::factory('profiler/stats');
            $this->request->response .= Kohana::debug($_SESSION);
            $this->request->response .= Kohana::debug(session_id());
        }
    }

    function _debug() {
        $variables = func_get_args();

        $output = Kohana::debug($variables);

        if (isset($this->template->_debug)) {
            // $this->template->_debug .= $output;
        } else {
            // $this->template->_debug = $output;
        }
    }

    /**
     * flash message set
     * @param <type> $string 内容
     * @param <type> $class 样式
     */
    function _flash($string, $class = 'candy-notice') {
        $this->_sess->set($this->_flash_msg_key, array(
            'class' => $class,
            'msg' => $string,
        ));
    }

    function showDevTools() {
        $this->request->response .= '<center>';

        $handler_links = '<a href="?handler=log">log</a> | ';
        $handler_links .= '<a href="?handler=cleanup">clean up</a> | ';
        $handler_links .= '<a href="?handler=model">genmodel</a> | ';
        $handler_links .= '<a href="?handler=table">gentable</a> | ';

        $this->request->response .= $handler_links;

        $handler = Arr::get($_GET, 'handler', 'log');

        $view['logs'] = 'no log!';

        if ($handler == 'model') {
            Candy::genORMModel();
            $view['logs'] = 'done!';
        }

        if ($handler == 'table') {
            Candy::genORMTable();
            $view['logs'] = 'done!';
        }

        $log_file = APPPATH . 'logs/' . date('Y/m/d') . EXT;

        if ($handler == 'log' && file_exists($log_file)) {
            $view['logs'] = file_get_contents($log_file);
            $view['logs'] = nl2br($view['logs']);
        }

        if ($handler == 'cleanup') {
            file_put_contents(APPPATH . 'logs/' . date('Y/m/d') . EXT, '');
            $view['logs'] = 'done!';
        }

        $this->request->response .= $view['logs'] . '</center>';
    }

    //用户访问特定内容权限
    function userPermissions($field, $return = False) {
        $role = Session::instance()->get('role', '游客');
        $actived = Session::instance()->get('actived', False);
        $permissions = Kohana::config('permissions');

        if (isset($permissions[$field])) {
            $permissions = $permissions[$field];
            $permissions = $permissions[$role];
            if (!$permissions) {
                //不返回，直接调整
                if (!$return) {
                    $this->template->_body = View::factory('main/notAuthorized', compact('role', 'actived'));
                    echo $this->template->render();
                    exit;
                } else {
                    return False;
                }
            } else {
                return True;
            }
        } else {
            return False;
        }
    }

    //决绝或否认，在当前页面显示
    function deny($reason = null, $redirect = null) {
        $this->template->_body = View::factory('main/deny', compact('reason'));
        echo $this->template->render();
        exit;
    }

    //设置积分弹出flash
    public function setPrompt($msg) {
        $this->_sess->set('prompt', $msg);
    }

    //返回错误提示
    public function json_error($error = '请求错误') {
        echo json_encode(array('status' => 0, 'error' => $error));
        exit;
    }

    //返回成功提示
    public function json_success($array) {
        $array['status'] = 1;
        echo json_encode($array);
    }

}
