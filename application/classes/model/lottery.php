<?php

//抽奖
class Model_Lottery {

    /**
      +------------------------------------------------------------------------------
     * 获取抽奖结果
      +------------------------------------------------------------------------------
     */
    public static function getResults($lottery_id, $user_id) {
        $record = array();
        if ($user_id AND $lottery_id) {
            $record = Doctrine_Query::create()
                    ->from('WeddingLotteryResults')
                    ->where('lottery_id=?', $lottery_id)
                    ->addWhere('user_id=?', $user_id)
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        }
        return $record;
    }

    //保存抽奖记录
    public static function saveResults($data) {
        $record = new WeddingLotteryResults();
        $record->fromArray($data);
        $record->lottery_date= date('Y-m-d H:i:s');
        $record->save();
        return $record->id;
    }
    
    //获取抽奖
    public static function getLottery($wedding_id){
        $record = Doctrine_Query::create()
                ->from('WeddingLottery')
                ->where('wedding_id=?',$wedding_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        return $record;
    }

}
