<?php

/**
 * BaseBanner
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $filename
 * @property integer $aa_id
 * @property integer $club_id
 * @property integer $classroom_id
 * @property string $title
 * @property string $format
 * @property string $url
 * @property integer $order_num
 * @property boolean $is_display
 * @property Aa $Aa
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBanner extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('banner');
        $this->hasColumn('filename', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('aa_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('club_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('classroom_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('title', 'string', 60, array(
             'type' => 'string',
             'length' => '60',
             ));
        $this->hasColumn('format', 'string', 10, array(
             'type' => 'string',
             'length' => '10',
             ));
        $this->hasColumn('url', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('order_num', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             ));
        $this->hasColumn('is_display', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Aa', array(
             'local' => 'aa_id',
             'foreign' => 'id'));
    }
}