<?php

/**
 * BaseWedding
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $year
 * @property string $title
 * @property timestamp $sign_start
 * @property timestamp $sign_finish
 * @property integer $sign_limit
 * @property timestamp $start
 * @property timestamp $finish
 * @property integer $hits
 * @property timestamp $publish_at
 * @property string $banner_img
 * @property timestamp $photography_start
 * @property timestamp $photography_finish
 * @property integer $num
 * @property string $address
 * @property string $content
 * @property string $intro
 * @property boolean $is_closed
 * @property boolean $is_stop_sign
 * @property boolean $is_suspend
 * @property boolean $is_recommended
 * @property boolean $is_upload_photography
 * @property integer $comments_num
 * @property integer $interested_num
 * @property boolean $open_lottery
 * @property boolean $open_vote
 * @property boolean $open_thinks
 * @property boolean $open_cooperation
 * @property boolean $open_photography
 * @property User $User
 * @property Doctrine_Collection $Albums
 * @property Doctrine_Collection $WeddingSigns
 * @property Doctrine_Collection $WeddingSponsors
 * @property Doctrine_Collection $WeddingWishs
 * @property Doctrine_Collection $WeddingLotterys
 * @property Doctrine_Collection $WeddingPhotographys
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWedding extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('wedding');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '6',
             ));
        $this->hasColumn('year', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 80, array(
             'type' => 'string',
             'length' => '80',
             ));
        $this->hasColumn('sign_start', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('sign_finish', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('sign_limit', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('start', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('finish', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('hits', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('publish_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('banner_img', 'string', 250, array(
             'type' => 'string',
             'length' => '250',
             ));
        $this->hasColumn('photography_start', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('photography_finish', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 1,
             'length' => '4',
             ));
        $this->hasColumn('address', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('intro', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('is_closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_stop_sign', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_suspend', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_recommended', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('is_upload_photography', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('comments_num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('interested_num', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('open_lottery', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('open_vote', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('open_thinks', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('open_cooperation', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('open_photography', 'boolean', null, array(
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

        $this->hasMany('Album as Albums', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));

        $this->hasMany('WeddingSign as WeddingSigns', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));

        $this->hasMany('WeddingSponsors', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));

        $this->hasMany('WeddingWish as WeddingWishs', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));

        $this->hasMany('WeddingLottery as WeddingLotterys', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));

        $this->hasMany('WeddingPhotography as WeddingPhotographys', array(
             'local' => 'id',
             'foreign' => 'wedding_id'));
    }
}