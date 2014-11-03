<?php

/**
 * BaseNewsTags
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $news_id
 * @property string $name
 * @property News $News
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsTags extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('news_tags');
        $this->hasColumn('news_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 16, array(
             'type' => 'string',
             'length' => '16',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('News', array(
             'local' => 'news_id',
             'foreign' => 'id'));
    }
}