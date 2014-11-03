<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * 使用地址:http://localhost/codebench/
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */


class Bench_Bbs extends Codebench {

    public $loops = 2;

    public function bench_doctrine() {
        $my_comment_ids = Doctrine_Query::create()
                ->select('bbs_unit_id')
                ->from('Comment c')
                ->where('c.user_id = ?', 18119)
                ->groupBy('c.bbs_unit_id')
                ->limit(100)
                ->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
        return $my_comment_ids;
    }

    public function bench_kohana() {

        $my_comment_ids = DB::select('bbs_unit_id')
                ->from('comment')
                ->where('user_id', '=', 18119)
                ->group_by('bbs_unit_id')
                ->limit(100)
                ->execute()
                ->as_array();

        return $my_comment_ids;
    }

}

?>
