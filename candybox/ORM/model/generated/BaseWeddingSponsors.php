<?php

/**
 * BaseWeddingSponsors
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $wedding_id
 * @property integer $category_id
 * @property string $product_name
 * @property string $company_name
 * @property string $logo_path
 * @property string $product_path
 * @property string $website
 * @property timestamp $created_at
 * @property string $intro
 * @property integer $hits_num
 * @property integer $vote_num
 * @property integer $order_num
 * @property boolean $is_fixed
 * @property Wedding $Wedding
 * @property Doctrine_Collection $WeddingVotes
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWeddingSponsors extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('wedding_sponsors');
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
        $this->hasColumn('category_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => '6',
             ));
        $this->hasColumn('product_name', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('company_name', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('logo_path', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('product_path', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('website', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('created_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('intro', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('hits_num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('vote_num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('order_num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 'order_num',
             'length' => '4',
             ));
        $this->hasColumn('is_fixed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));

        $this->option('type', 'MYISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Wedding', array(
             'local' => 'wedding_id',
             'foreign' => 'id'));

        $this->hasMany('WeddingVote as WeddingVotes', array(
             'local' => 'id',
             'foreign' => 'sponsors_id'));
    }
}