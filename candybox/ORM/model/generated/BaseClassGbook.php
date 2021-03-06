<?php

/**
 * BaseClassGbook
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $pid
 * @property integer $class_member_id
 * @property integer $class_room_id
 * @property timestamp $content
 * @property timestamp $post_at
 * @property ClassMember $ClassMember
 * @property ClassRoom $ClassRoom
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseClassGbook extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('class_gbook');
        $this->hasColumn('id', 'integer', 5, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '5',
             ));
        $this->hasColumn('pid', 'integer', 5, array(
             'type' => 'integer',
             'length' => '5',
             ));
        $this->hasColumn('class_member_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('class_room_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('content', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('post_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ClassMember', array(
             'local' => 'class_member_id',
             'foreign' => 'id'));

        $this->hasOne('ClassRoom', array(
             'local' => 'class_room_id',
             'foreign' => 'id'));
    }
}