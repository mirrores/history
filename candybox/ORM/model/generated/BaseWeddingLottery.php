<?php

/**
 * BaseWeddingLottery
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $img_path
 * @property integer $wedding_id
 * @property integer $event_id
 * @property integer $award_probability
 * @property integer $user_id
 * @property string $remark
 * @property timestamp $start_date
 * @property timestamp $end_date
 * @property timestamp $created_at
 * @property Wedding $Wedding
 * @property Event $Event
 * @property User $User
 * @property Doctrine_Collection $WeddingAwardss
 * @property Doctrine_Collection $WeddingLotteryResultss
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWeddingLottery extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('wedding_lottery');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('img_path', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('wedding_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('event_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('award_probability', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('user_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('remark', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('start_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('end_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('created_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Wedding', array(
             'local' => 'wedding_id',
             'foreign' => 'id'));

        $this->hasOne('Event', array(
             'local' => 'event_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('WeddingAwards as WeddingAwardss', array(
             'local' => 'id',
             'foreign' => 'lottery_id'));

        $this->hasMany('WeddingLotteryResults as WeddingLotteryResultss', array(
             'local' => 'id',
             'foreign' => 'lottery_id'));
    }
}