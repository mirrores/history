<?php

/**
 * BaseUserInvite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property integer $user_id
 * @property integer $receiver_user_id
 * @property string $receiver_email
 * @property string $receiver_name
 * @property string $message
 * @property timestamp $create_date
 * @property timestamp $read_date
 * @property timestamp $accept_date
 * @property integer $parent_invite_id
 * @property boolean $is_read
 * @property boolean $is_accept
 * @property boolean $is_closed
 * @property User $User
 * @property User $RUser
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserInvite extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user_invite');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('type', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('receiver_user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('receiver_email', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('receiver_name', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('create_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('read_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('accept_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('parent_invite_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_read', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_accept', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('User as RUser', array(
             'local' => 'receiver_user_id',
             'foreign' => 'id'));
    }
}