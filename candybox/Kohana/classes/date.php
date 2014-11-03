<?php

defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date {

    public static function span_str($time1, $time2 = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds') {
        if (!$time1)
            return '';
        $r = parent::span($time1 + 1, $time2, $output);
        foreach ($r as $k => $v) {
            if ($v > 0) {
                return $v . __($k);
            }
        }
    }
    
    //个性问候
    public static function hello($name) {
         return '欢迎回来！'.$name;
        $hour = date('H');
        $message=array();
        $message[0]=array('早上好！'.$name);
        $message[1]=array('早上好！');
        $message[2]=array('早上好！');
        $message[3]=array('早上好！');
        $message[4]=array('早上好！');
        $message[5]=array('早上好！');
        $message[6]=array('早上好！'.$name.'，又是新的一天，祝您工作顺利！');
        $message[7]=array('早上好！');
        $message[8]=array('早上好！');
        $message[9]=array('早上好！');
        $message[10]=array('早上好！');
        $message[11]=array('早上好！');
        $message[12]=array('早上好！');
        $message[13]=array('早上好！');
        $message[14]=array('早上好！');
        $message[15]=array('早上好！');
        $message[16]=array('早上好！');
        $message[17]=array('下午好！'.$name);
        $message[18]=array('早上好！');
        $message[19]=array('早上好！');
        $message[20]=array('早上好！');
        $message[21]=array('早上好！');
        $message[22]=array('早上好！');
        $message[23]=array('早上好！');
        if(isset($message[$hour])){
            return $message[$hour][0];
        }
        else{
            return '欢迎回来！';
        }
    }

    //人性化日期显示
    public static function ueTime($times) {
        if ($times == '' || $times == 0) {
            return false;
        }
        //完整时间戳
        $strtotime = is_int($times) ? $times : strtotime($times);
        $times_day = date('Y-m-d', $strtotime);
        $times_day_strtotime = strtotime($times_day);

        //今天
        $nowdate = date('Y-m-d');
        $nowdate_str = strtotime(date('Y-m-d'));

        //精确的时间间隔(秒)
        $interval = time() - $strtotime;

        //今天的
        if ($times_day_strtotime == $nowdate_str) {

            //小于一分钟
            if ($interval < 60) {
                $pct = sprintf("%d秒前", $interval);
            }
            //小于1小时
            elseif ($interval < 3600) {
                $pct = sprintf("%d分钟前", ceil($interval / 60));
            } else {
                $pct = sprintf("%d小时前", floor($interval / 3600));
            }
        }
        //昨天的
        elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-1 days')))) {
            $pct = '昨天' . date('H:i', $strtotime);
        }
        //前天的
        elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-2 days')))) {
            $pct = '前天' . date('H:i', $strtotime);
        }
        //一个月以内
        elseif ($interval < (3600 * 24 * 30)) {
            $pct = date('m月d日', $strtotime);
        }
        //一年以内
        elseif ($interval < (3600 * 24 * 365)) {
            $pct = date('m月d日', $strtotime);
        }
        //一年以上
        else {
            $pct = date('Y年m月d日', $strtotime);
        }
        return $pct;
    }
    
    //获取星期
    public static function getWeek($date){
        $week = array('0' => '星期日', '1' => '星期一', '2' => '星期二', '3' => '星期三', '4' => '星期四', '5' => '星期五', '6' => '星期六');
        $dateArr = explode("-", date('Y-n-d', strtotime($date)));
        return $week[date("w", mktime(0, 0, 0, $dateArr[1], $dateArr[2], $dateArr[0]))];
    }

}