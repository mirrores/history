<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */
class Bench_Isfile extends Codebench {

    public $loops = 1;

    public function bench_file() {
        $mini_pic = Common_Global::getImageBysuffix('http://localhost/static/upload/pic/201209/19/2010620120919155727707_bmiddle.png', 'mini');
        return $mini_pic;
    }

}

?>
