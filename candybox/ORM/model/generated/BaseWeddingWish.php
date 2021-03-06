<?php

/**
 * BaseWeddingWish
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $wedding_id
 * @property integer $user_id
 * @property boolean $is_closed
 * @property string $content
 * @property timestamp $created_at
 * @property Wedding $Wedding
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWeddingWish extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('wedding_wish');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('wedding_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('user_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('is_closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
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

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}