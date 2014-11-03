<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */
class Bench_User extends Codebench {

    public $loops = 2;

    public function bench_doctrine() {
        $user = Doctrine_Query::create()
                ->select('id,realname,role,password,account,sex,city,actived,login_num,login_time')
                ->from('User')
                ->where('id = ?', 18119)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        return $user;
    }

    public function bench_kohana() {

        $user = DB::select('*')
                ->from('user')
                ->where('id', '=', 18119)
                ->execute()
                ->as_array();

        DB::update('user')
                ->set(array('realname' => 'shrek82', 'login_time' => date('Y-m-d H:i:s'), 'role' => '管理员'))->where('id', '=', 18119)
                ->execute();

        return $user;
    }

}

?>
