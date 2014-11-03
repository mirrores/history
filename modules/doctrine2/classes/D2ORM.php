<?php

defined('E_DEPRECATED') OR die('Doctrine2 need PHP 5.3.x');

class D2ORM
{

    public static $loaded;
    private static $_em = array();
    private static $_config;

    /**
     * doctrine2 orm 初始化工厂
     * @param <type> $conn
     * @return <type> Doctrine\ORM\EntityManager
     */
    public static function em($name='default', $charset='utf8')
    {
        $path = MODPATH . 'doctrine2/';

        // 初始化
        if (count(self::$_em) == 0)
        {
            if (!D2DBAL::$loaded)
            {
                require $path . 'Doctrine/Common/ClassLoader.php';
                self::$loaded = TRUE;
            }

            $loader = new Doctrine\Common\ClassLoader('Doctrine', $path);
            $loader->register();
            $loader = new Doctrine\Common\ClassLoader('Symfony', $path . 'Doctrine');
            $loader->register();
            
            $config = new Doctrine\ORM\Configuration;
            $cache = Kohana::$environment == Kohana::DEVELOPMENT ?
                     new Doctrine\Common\Cache\ArrayCache :
                     new Doctrine\Common\Cache\ApcCache;
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);
            $config->setProxyDir($path . 'Proxies');
            $config->setProxyNamespace('Ko3Proxies');
            $driverImpl = new Doctrine\ORM\Mapping\Driver\YamlDriver($path . 'Metadata');
            $config->setMetadataDriverImpl($driverImpl);
            $config->setResultCacheImpl($cache);

            self::$_config = $config;
        }

        // 设置未创建的 EntityManager
        if (!isset(self::$_em[$name]))
        {
            $connConifg = Kohana::config('doctrine.' . $name);
            $em = Doctrine\ORM\EntityManager::create($connConifg, self::$_config);
            if($connConifg['driver'] == 'pdo_mysql')
            {
                $em->getEventManager()
                   ->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit($charset));
            }
            self::$_em[$name] = $em;
            return $em;
        }

        return self::$_em[$name];

    }

}