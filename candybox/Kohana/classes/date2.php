<?php

defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date {

        public static function span_str($time1, $time2 = NULL, $output = 'years,months,weeks,days,hours,minutes,seconds') {
                if (!$time1)
                        return '';
                $r = parent::span($time1+1, $time2, $output);
                foreach ($r as $k => $v) {
                        if ($v > 0) {
                                return $v . __($k);
                        }
                }
        }

}