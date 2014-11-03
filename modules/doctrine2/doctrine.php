<?php

defined('E_DEPRECATED') OR die('Doctrine2 need PHP 5.3.x');

require_once 'Doctrine/Common/ClassLoader.php';

use Doctrine\Common\ClassLoader,
 Doctrine\ORM\EntityManager,
 Doctrine\ORM\Configuration;

// auto loader
$classLoader = new ClassLoader('Doctrine', __DIR__);
$classLoader->register();
$classLoader = new ClassLoader('Symfony', __DIR__.'/Doctrine');
$classLoader->register();


// cache ----------------------------------
$config = new Configuration;
$cache = new Doctrine\Common\Cache\ArrayCache;
#$cache = new \Doctrine\Common\Cache\ApcCache;
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);


// proxy ----------------------------------
$config->setProxyDir(__DIR__.'/Proxies');
$config->setProxyNamespace('Ko3Proxies');
# $config->setAutoGenerateProxyClasses(true);
# $config->setAutoGenerateProxyClasses(false);
// mapping driver --------------------------------------------------------
#$driverImpl = new \Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/Metadata');
$driverImpl = new Doctrine\ORM\Mapping\Driver\YamlDriver(__DIR__.'/Metadata');
$config->setMetadataDriverImpl($driverImpl);


// db connections -----------------------
$connectionOptions = array(
    //'driver' => 'pdo_sqlite',
    //'path' => __DIR__ . '/test.s3db'
    'user' => 'zuaa',
    'password' => '123123',
    'host' => 'localhost',
    'dbname' => 'ko3woody',
    'port' => '3306',
    'driver' => 'pdo_mysql',
);

try {
    $em = EntityManager::create($connectionOptions, $config);
    if ($connectionOptions['driver'] == 'pdo_mysql')
    {
        $em->getEventManager()->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8'));
    }
}
catch (Exception $e) {
    echo 'doctrine2 connection error, check your cli.php';
    var_dump($connectionOptions);
    exit;
}

$helperSet = new Symfony\Component\Console\Helper\HelperSet(array(
            'db' => new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
            'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
        ));


\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
