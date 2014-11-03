<?php

/**
 * BaseClassAbook
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $tel
 * @property string $mobile
 * @property string $qq
 * @property string $msn
 * @property string $address
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseClassAbook extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('class_abook');
        $this->hasColumn('user_id', 'integer', 5, array(
             'type' => 'integer',
             'length' => '5',
             ));
        $this->hasColumn('tel', 'string', 30, array(
             'type' => 'string',
             'length' => '30',
             ));
        $this->hasColumn('mobile', 'string', 30, array(
             'type' => 'string',
             'length' => '30',
             ));
        $this->hasColumn('qq', 'string', 30, array(
             'type' => 'string',
             'length' => '30',
             ));
        $this->hasColumn('msn', 'string', 60, array(
             'type' => 'string',
             'length' => '60',
             ));
        $this->hasColumn('address', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
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