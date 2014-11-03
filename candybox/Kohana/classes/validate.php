<?php defined('SYSPATH') or die('No direct script access.');

class Validate extends Kohana_Validate
{
    const RULES_CONF_NAME = 'valid';
    private static $_data = array();

    /**
     * 信息格式化
     * @param <type> $prefix
     * @param <type> $suffix
     * @param <type> $messages
     * @return <type>
     */
    public static function outputMsg($messages, $prefix='*', $suffix='<br />')
    {
        if(is_array($messages)){
            $str = '';
            foreach($messages as $msg){
                $str .= $prefix.$msg.$suffix;
            }
            return substr($str, 0, intval('-'.strlen($suffix)));

        } else {
            return $prefix.$messages.$suffix;
        }
    }

    /**
     * 设置 kohana config 中的数据校验文件
     * @param <type> $data
     * @param <type> $vname
     * @param <type> $unset_rules
     * @return <type>
     */
    public static function setRules($data, $vname, $unRules=null)
    {
        $v = self::factory($data);
        $config = Kohana::config(self::RULES_CONF_NAME);

        self::$_data = $data;

        // filters
        if(isset($config['filters']) && isset($config['filters'][$vname])){
            $filters = $config['filters'][$vname];
            
        } else {
            $filters = array(TRUE => array('trim'=>null, 'Security::xss_clean'=>null));
        }

        foreach($filters as $field => $filter){
            $v->filters($field, $filter);
        }

        // rules
        $rules = $config['rules'][$vname];
        if($unRules)
        {
            $unset_rules_arr = explode(',', $unRules);
            foreach($unset_rules_arr as $field)
                unset($rules[$field]);
        }

        foreach($rules as $field => $rule)
            $v->rules($field, $rule);

        // labels
        $labels_com = $config['labels'];
        $labels = Kohana::config(self::RULES_CONF_NAME.'.labels.'.$vname);

        $v->labels($labels_com);
        if(is_array($labels)){
            $v->labels($labels);
        }

        return $v;
    }

    /**
     * 获取过滤后的数据
     * @return <type>
     */
    static function getData()
    {
        if(is_array(self::$_data))
        {
            $temp = array();
            foreach(self::$_data as $key => $data)
            {
                // 非checkbox数据需要过滤空格符
                if( ! is_array($data))
                    $temp[$key] = Security::xss_clean(trim($data));
                else
                {
                    foreach($data as $k => $v)
                    {
                        $temp[$key][$k] = Security::xss_clean(trim($v));
                    }
                }
            }
            self::$_data = $temp;
        }
        return self::$_data;
    }

    // 中文校验
    public static function chinese($str)
    {
        return (bool) preg_match("/^[\x7f-\xff]+$/", $str);
    }

    // 数字相等
    public static function num_eq($num_x, $num_y)
    {
        return (bool) ((int)$num_x == (int)$num_y);
    }
}