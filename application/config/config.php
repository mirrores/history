<?php

//网站参数
return array(
    'base' => array(
        'id' => 'zuaa',
        'university_name' => '浙江大学',
        'orgname' => '浙江大学校友会',
        'sitename' => '浙大校友网',
        'alumni_name' => '浙大校友',
        'domain_name' => 'zuaa.zju.edu.cn',
        'manager_mail' => 'zuaa@zju.edu.cn',
        'manager_name'=>'周老师',
        'manager_tel'=>'0571-88981225',
        'webdev_mail'=>'seeyoup@qq.com'
    ),
    'modules' => array(
        'invite' => True,
        'news_contribute' => True,
        'publication_contribute' => True,
        'register_mail' => True,
        'binding' => True,
    ),
    'reg' => array(
        'all_step' => 5,
        'is_verify_role' => '校友(未审核)'
    ),
);