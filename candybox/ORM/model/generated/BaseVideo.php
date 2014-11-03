<?php

/**
 * BaseVideo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $video_path
 * @property string $img_path
 * @property string $intro
 * @property integer $order_num
 * @property timestamp $create_at
 * @property integer $hits
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseVideo extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('video');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('video_path', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('img_path', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('intro', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('order_num', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('create_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('hits', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}