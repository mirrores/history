<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-05-05 14:24:56 --- ERROR: Doctrine_Record_UnknownPropertyException [ 0 ]: Unknown record property / related component "open_photos" on "Wedding" ~ DOCROOT\candybox\Doctrine\Record\Filter\Standard.php [ 55 ]
2014-05-05 14:25:48 --- ERROR: Doctrine_Record_UnknownPropertyException [ 0 ]: Unknown record property / related component "open_photos" on "Wedding" ~ DOCROOT\candybox\Doctrine\Record\Filter\Standard.php [ 55 ]
2014-05-05 14:50:02 --- ERROR: ErrorException [ 8 ]: Undefined variable: q ~ APPPATH\classes\controller\admin\wedding.php [ 646 ]
2014-05-05 14:50:26 --- ERROR: ErrorException [ 8 ]: Undefined variable: type ~ APPPATH\classes\controller\admin\wedding.php [ 663 ]
2014-05-05 14:52:26 --- ERROR: Doctrine_Connection_Mysql_Exception [ 42 ]: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'w.img_size:' in 'field list'. Failing Query: "SELECT `w`.`id` AS `w__id`, `w`.`category` AS `w__category`, `w`.`wedding_id` AS `w__wedding_id`, `w`.`title` AS `w__title`, `w`.`intro` AS `w__intro`, `w`.`author` AS `w__author`, `w`.`email` AS `w__email`, `w`.`finish_year` AS `w__finish_year`, `w`.`speciality` AS `w__speciality`, `w`.`tel` AS `w__tel`, `w`.`qq` AS `w__qq`, `w`.`img_path` AS `w__img_path`, `w`.`original_img_path` AS `w__original_img_path`, `w`.`img_size:` AS `w__img_size:`, `w`.`address` AS `w__address`, `w`.`company` AS `w__company`, `w`.`user_id` AS `w__user_id`, `w`.`award_name` AS `w__award_name`, `w`.`is_recommend` AS `w__is_recommend`, `w`.`created_at` AS `w__created_at` FROM `wedding_photography` `w` ORDER BY `w`.`id` DESC LIMIT 20" ~ DOCROOT\candybox\Doctrine\Connection.php [ 1082 ]
2014-05-05 14:52:38 --- ERROR: Doctrine_Connection_Mysql_Exception [ 42 ]: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'w.img_size:' in 'field list'. Failing Query: "SELECT `w`.`id` AS `w__id`, `w`.`category` AS `w__category`, `w`.`wedding_id` AS `w__wedding_id`, `w`.`title` AS `w__title`, `w`.`intro` AS `w__intro`, `w`.`author` AS `w__author`, `w`.`email` AS `w__email`, `w`.`finish_year` AS `w__finish_year`, `w`.`speciality` AS `w__speciality`, `w`.`tel` AS `w__tel`, `w`.`qq` AS `w__qq`, `w`.`img_path` AS `w__img_path`, `w`.`original_img_path` AS `w__original_img_path`, `w`.`img_size:` AS `w__img_size:`, `w`.`address` AS `w__address`, `w`.`company` AS `w__company`, `w`.`user_id` AS `w__user_id`, `w`.`award_name` AS `w__award_name`, `w`.`is_recommend` AS `w__is_recommend`, `w`.`created_at` AS `w__created_at` FROM `wedding_photography` `w` ORDER BY `w`.`id` DESC LIMIT 20" ~ DOCROOT\candybox\Doctrine\Connection.php [ 1082 ]
2014-05-05 14:53:13 --- ERROR: Doctrine_Connection_Mysql_Exception [ 42 ]: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'w.img_size:' in 'field list' ~ DOCROOT\candybox\Doctrine\Connection.php [ 1082 ]
2014-05-05 14:54:41 --- ERROR: ErrorException [ 8 ]: Undefined variable: type ~ APPPATH\views\admin_wedding\photography.php [ 27 ]
2014-05-05 15:00:54 --- ERROR: ErrorException [ 8 ]: Undefined index: name ~ APPPATH\views\admin_wedding\photography.php [ 57 ]
2014-05-05 15:48:49 --- ERROR: ErrorException [ 8 ]: Undefined variable: u ~ APPPATH\views\admin_wedding\photography.php [ 60 ]
2014-05-05 16:13:03 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '?>', expecting ']' ~ APPPATH\views\admin_wedding\photography.php [ 47 ]
2014-05-05 16:16:28 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected 'endforeach' (T_ENDFOREACH) ~ APPPATH\views\admin_wedding\photography.php [ 55 ]