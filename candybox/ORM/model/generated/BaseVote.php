<?php

/**
 * BaseVote
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $aa_id
 * @property integer $user_id
 * @property integer $news_id
 * @property integer $bbs_unit_id
 * @property integer $classroom_id
 * @property integer $event_id
 * @property string $type
 * @property integer $max_select
 * @property string $title
 * @property string $content
 * @property timestamp $create_at
 * @property timestamp $start_date
 * @property timestamp $finish_date
 * @property boolean $is_closed
 * @property integer $hit
 * @property User $User
 * @property Aa $Aa
 * @property Doctrine_Collection $Units
 * @property Doctrine_Collection $VoteOptions
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseVote extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('vote');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('aa_id', 'integer', 6, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '6',
             ));
        $this->hasColumn('user_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('news_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('bbs_unit_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('classroom_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('event_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('type', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('max_select', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('create_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('start_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('finish_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('is_closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('hit', 'integer', 6, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '6',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('Aa', array(
             'local' => 'aa_id',
             'foreign' => 'id'));

        $this->hasMany('BbsUnit as Units', array(
             'local' => 'bbs_unit_id',
             'foreign' => 'id'));

        $this->hasMany('VoteOptions', array(
             'local' => 'id',
             'foreign' => 'vote_id'));
    }
}