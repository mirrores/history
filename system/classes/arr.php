<?php

defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {

    //获取post或get参数
    public static function getAll($key, $default = NULL) {
        if (isset($_POST[$key])) {
            $str = $_POST[$key];
            return Security::xss_clean($str);
        } elseif (isset($_GET[$key])) {
            $str = $_GET[$key];
            $safe_str = urlencode($str);
            if (strstr($safe_str, '%3C') OR strstr($safe_str, '%27') OR strstr($safe_str, '%22') OR strstr($safe_str, '%26')) {
                return false;
            }
            return Security::xss_clean($str);
        } else {
            return $default;
        }
    }

}
