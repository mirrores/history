<?php

defined('E_DEPRECATED') OR die('Doctrine2 need PHP 5.3.x');

class D2DBAL
{

    public static $loaded;
    private static $_db = array();
    //private static $_config;

    /**
     * doctrine2 DBAL 初始化工厂
     * @param <type> $conn
     * @return <type>
     */
    public static function conn($name='default', $charset='utf8')
    {
        $path = MODPATH . 'doctrine2/';

        // 初始化
        if (count(self::$_db) == 0)
        {
            if (!D2ORM::$loaded)
            {
                require $path . 'Doctrine/Common/ClassLoader.php';
                self::$loaded = TRUE;
            }

            $loader = new Doctrine\Common\ClassLoader('Doctrine', $path);
            $loader->register();

            //$config = new \Doctrine\DBAL\Configuration;
            //self::$_config = $config;
        }

        // 设置未创建的 conn
        if (!isset(self::$_db[$name]))
        {
            $connConifg = Kohana::config('doctrine.' . $name);
            $evm = null;
            if($connConifg['driver'] == 'pdo_mysql')
            {
                $evm = new Doctrine\Common\EventManager;
                $evm->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit($charset));
            }
            $conn = Doctrine\DBAL\DriverManager::getConnection($connConifg, null, $evm);
            self::$_db[$name] = $conn;
            return $conn;
        }

        return self::$_db[$name];

    }

}