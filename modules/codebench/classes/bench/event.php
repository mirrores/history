<?php

defined('SYSPATH') or die('No direct access allowed.');

/**
 * @package    Kohana/Codebench
 * @category   Tests
 * @author     Geert De Deckere <geert@idoe.be>
 */
class Bench_Event extends Codebench {

    public $loops = 15;

    public function bench_kohana_select() {
        $alive = time() - 900;
        $signer= DB::select(DB::expr('s.*, u.id, u.realname, u.account,u.sex,c.name AS group_name'))
                ->select(DB::expr('(SELECT o.id FROM ol o WHERE o.uid=s.user_id AND o.time>' . $alive . ' ) AS online'))
                ->from(array('event_sign', 's'))
                ->join(array('user', 'u'))
                ->on('u.id', '=', 's.user_id')
                ->join(array('event_sign_categorys', 'c'))
                ->on('c.id', '=', 's.category_id')
                ->where('s.event_id', '=', 23886);
        
        return count($signer);
    }


}

?>
