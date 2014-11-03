<?php defined('SYSPATH') or die('No direct script access.');

class Html extends Kohana_Html
{
    static function th($cols_name)
    {
        $th = '<tr>';
        foreach($cols_name as $col){
            $th .= '<th>'.$col.'</th>';
        }
        return $th.'</tr>';
    }
}