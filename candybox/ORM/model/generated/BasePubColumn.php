<?php

/**
 * BasePubColumn
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $pub_id
 * @property integer $col_id
 * @property string $name
 * @property Publication $Publication
 * @property Doctrine_Collection $PubContents
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePubColumn extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('pub_column');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '6',
             ));
        $this->hasColumn('pub_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('col_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('name', 'string', 40, array(
             'type' => 'string',
             'length' => '40',
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Publication', array(
             'local' => 'pub_id',
             'foreign' => 'id'));

        $this->hasMany('PubContent as PubContents', array(
             'local' => 'col_id',
             'foreign' => 'col_id'));
    }
}