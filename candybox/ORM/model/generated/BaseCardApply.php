<?php

/**
 * BaseCardApply
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $realname
 * @property string $mobile
 * @property integer $user_id
 * @property timestamp $apply_at
 * @property string $card_type
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCardApply extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('card_apply');
        $this->hasColumn('id', 'integer', 3, array(
             'type' => 'integer',
             'length' => '3',
             ));
        $this->hasColumn('realname', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('mobile', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('user_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('apply_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('card_type', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}