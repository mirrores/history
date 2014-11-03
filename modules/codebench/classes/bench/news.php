<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */
class Bench_News extends Codebench {

    public $loops = 4;

    public function bench_doctrine() {
        // 焦点(图片)新闻
        $news = Doctrine_Query::create()
                ->select('n.id,n.title,n.img_path')
                ->from('News n')
                ->where('n.is_draft = ?', FALSE)
                ->addWhere('n.is_focus = ?', True)
                ->orderBy('n.id DESC')
                ->limit(5)
                ->fetchArray();
        return $news;
    }

    public function bench_kohana() {
       Db_Content::getStaticPic();
    }

}