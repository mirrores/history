<?php

/**
 * BaseWeddingPhotography
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $category
 * @property integer $wedding_id
 * @property string $title
 * @property string $intro
 * @property string $author
 * @property string $email
 * @property string $finish_year
 * @property string $speciality
 * @property string $tel
 * @property string $qq
 * @property string $img_path
 * @property string $original_img_path
 * @property integer $img_size
 * @property string $address
 * @property string $company
 * @property integer $user_id
 * @property string $award_name
 * @property boolean $is_recommend
 * @property timestamp $created_at
 * @property Wedding $Wedding
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWeddingPhotography extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('wedding_photography');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('category', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('wedding_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('title', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('intro', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('author', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('email', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('finish_year', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('speciality', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('tel', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('qq', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('img_path', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('original_img_path', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('img_size', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('address', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('company', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('user_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('award_name', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('is_recommend', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
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
    }
}