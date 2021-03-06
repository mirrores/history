<?php

/**
 * BaseEleReport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $content_path
 * @property timestamp $create_at
 * @property string $issue
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEleReport extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('ele_report');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '6',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('content_path', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('create_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('issue', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}