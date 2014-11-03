<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */
class Bench_Weibo extends Codebench {

    public $loops = 1;

//    public function bench_doctrine() {
//
//        $weibo = Doctrine_Query::create()
//                ->select('a.id,c.*,aa.id,u.realname,u.sex,u.speciality,u.start_year')
//                ->from('AaWeibo a')
//                ->leftJoin('a.WeiboContent c')
//                ->leftJoin('a.Aa aa')
//                ->leftJoin('c.User u')
//                ->where('a.aa_id=?',1)
//                ->addWhere('c.is_original=?',1)
//                ->orderBy('c.id DESC')
//                ->limit(25)
//                ->fetchArray();
//
//        return  $weibo;
//    }

//    public function bench_kohana() {
//        $weibo = Doctrine_Query::create()
//                ->select('a.*,u.realname,u.sex,u.speciality,u.start_year')
//                ->from('AaWeibo a')
//                ->leftJoin('a.User u')
//                ->where('a.aa_id=?',1)
//                ->addWhere('a.is_original=?',1)
//                ->orderBy('a.id DESC')
//                ->limit(25)
//                ->fetchArray();
//
//        return  $weibo;
//    }

    public function bench_kohanatwo() {
        $weibo = Doctrine_Query::create()
                ->select('c.*,u.realname,u.sex,u.speciality,u.start_year')
                ->from('WeiboContent c')
                ->leftJoin('c.User u')
                ->where('c.user_id IN (SELECT m.user_id from AaMember m where m.aa_id=1)')
                ->orderBy('c.id DESC')
                ->limit(25)
                ->fetchArray();
        return  $weibo;
    }

    public function bench_kohanathr() {
        $weibo = Doctrine_Query::create()
                ->select('a.id,c.*,u.realname,u.sex,u.speciality,u.start_year')
                ->from('AaWeibo a')
                ->leftJoin('a.WeiboContent c')
                ->leftJoin('c.User u')
                ->where('a.aa_id=?',1)
                ->orderBy('c.id DESC')
                ->limit(25)
                ->fetchArray();

        return  $weibo;
    }

}