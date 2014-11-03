<?php

/**
 * CandyBox Class For All Web Project.
 * @copyright LP.Studio
 * @author linyupark@gmail.com
 */
define('CANDYPATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('CANDYURL', '/candybox/');

class Candy {
        const ORM_PATH = 'ORM'; // ORM生成类存放目录
        const NATIVE_DB = 'NativeDb'; //嵌入式文件数据库目录
        const MARK_ERR = 'err#'; //candyForm中使用
        const MARK_SUCCESS = 'success#'; //同上
        const MARK_RESP = 'resp#';

        public static $_imported = array(); // 纪录已加载的组件
        // 包含组件名=>loader文件
        private static $components = array(
            'doctrine' => 'Doctrine/Core.php',
            'phpExcel' => 'PHPExcel/PHPExcel.php',
            'phpExce2005' => 'PHPExcel/PHPExcel/Writer/Excel5.php',
            'phpExce2007' => 'PHPExcel/PHPExcel/Writer/Excel2007.php',
            'yaml' => 'sfYaml/sfYaml.php',
            'coremail' => 'coremail_api.php',
            'excelMaker' => 'SimpleExcel/xml.php',
            'excelReader' => 'ExcelReader/reader.php',
            'swiftMailer' => 'SwiftMailer/swift_required.php',
            'socket' => 'Socket/socket.php',
            'sinaWeiboApi'=>'SinaWeiboApi/saetv2.ex.class.php',
            'arrayToxml'=>'ArrayToXml/array2xml.php',
            'ckeditor' => 'Editor/ckeditor/ckeditor.js',
            'ckfinder' => 'Editor/ckfinder/ckfinder.js',
            'jscolor' => 'jscolor/jscolor.js',
            'httpDownload' => 'HttpDownload/download.php',
            'slideshow' => array(
                'Slideshow/js/slideshow.js',
                'Slideshow/css/slideshow.css',
            ),
            'fancy' => array(
                'FancyUpload/Swiff.Uploader.js',
                'FancyUpload/Fx.ProgressBar.js',
                'FancyUpload/FancyUpload2.js',
                'FancyUpload/default.css'
            ),
            'datepicker' => array(
                'DatePicker/datepicker.js',
                'DatePicker/datepicker_vista/datepicker_vista.css'),
            'facebox' => array(
                'Facebox/facebox.js',
                'Facebox/facebox/facebox.css'),
        );

        public static function init() {
                session_name('session');
                spl_autoload_register('Candy::autoload');
        }

        public static function autoload($classname) {
                $path = CANDYPATH . 'Autoload/';
                $file = str_replace('_', '/', $classname);
                if (file_exists($path . $file . '.php')) {
                        require_once $path . $file . '.php';
                        return TRUE;
                }
                return FALSE;
        }

        /**
         *
         * @param <string> $com 加载指定组件
         */
        public static function import($com) {
                $components = self::$components;

                if (!array_key_exists($com, $components)) {
                        throw new Exception($com . ' Not Exist!');
                }

                // 加载
                if (!in_array($com, self::$_imported)) {

                        // 纪录
                        self::$_imported[] = $com;

                        if (is_string($components[$com])) {
                                $_com = array($components[$com]);
                        } else {
                                $_com = $components[$com];
                        }

                        $str = '';

                        foreach ($_com as $c) {
                                if (strstr($c, '.php')) {
                                        require_once $c;
                                }

                                if (strstr($c, '.js')) {
                                        $str .= '<script type="text/javascript" src="' . CANDYURL . $c . '"></script>';
                                }

                                if (strstr($c, '.css')) {
                                        $str .= '<link rel="stylesheet" href="' . CANDYURL . $c . '" type="text/css" media="screen" /> ';
                                }
                        }

                        // 附加操作
                        if ($com == 'doctrine') {
                                spl_autoload_register('Doctrine_Core::autoload');
                                self::dbConf();
                        }
                        //echo 'import '.$com;
                        return $str;
                }
        }

        /**
         * sqlite:////full/unix/path/to/file.db?mode=0666
         * mysql://username:password@localhost:port/test
         * @param string $adapter
         * @return object Doctrine lazy connection
         */
        public static function dbConn($adapter, $name, $charset='utf8') {
                self::import('doctrine');
                $manager = Doctrine_Manager::getInstance();
                $conn = $manager->connection($adapter, $name);
                $conn->setCharset($charset);
                return $conn;
        }

        /**
         * doctrine import 后的设置工作
         */
        private static function dbConf() {
                $manager = Doctrine_Manager::getInstance();

                // 设置对应的缓存驱动
                $native_db_path = CANDYPATH . self::NATIVE_DB . '/cache/result_cache.sqlite';
                $cache_conn = self::dbConn('sqlite:///' . $native_db_path, 'result_cache');

                $cache_db_driver = new Doctrine_Cache_Db(
                                array('connection' => $cache_conn,
                                    'tableName' => 'result'));

                if (!file_exists($native_db_path)) {
                        $cache_db_driver->createTable();
                }

                $manager->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $cache_db_driver);
                $manager->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, 1);
                $manager->setAttribute(Doctrine_Core::ATTR_QUOTE_IDENTIFIER, 1);
                spl_autoload_register('Candy::autoloadModel');
        }

        public static function genORMModel($generateBaseClasses=true) {
                self::import('doctrine');
                Doctrine_Core::generateModelsFromYaml(
                        CANDYPATH . self::ORM_PATH . '/yml', CANDYPATH . self::ORM_PATH . '/model', array(
                    'baseClassesDirectory' => 'generated',
                    'generateBaseClasses' => $generateBaseClasses,
                        )
                );
        }

        /**
         * 自动加载生成的model类
         * @param <type> $class
         * @return <boolean>
         */
        public static function autoloadModel($class) {
                $import = new Doctrine_Import_Schema();
                $folder = $import->getOption('baseClassesDirectory');

                $model_path = CANDYPATH . self::ORM_PATH . '/model/' . $class . '.php';
                $base_path = CANDYPATH . self::ORM_PATH . '/model/' . $folder . '/' . $class . '.php';

                if (file_exists($model_path)) {
                        require_once $model_path;
                        return true;
                }

                if (file_exists($base_path)) {
                        require_once $base_path;
                        return true;
                }

                return false;
        }

        public static function genORMTable() {
                self::import('doctrine');
                Doctrine_Core::createTablesFromModels(CANDYPATH . self::ORM_PATH . '/model');
        }

        public static function initCKFinder($ckeditor) {
                $_SESSION['candyCKF'] = true;
                return 'CKFinder.SetupCKEditor(' . $ckeditor . ', "' . CANDYURL . 'Editor/ckfinder/");';
        }

        // 打扫
        public static function cleanup() {
                if (in_array('doctrine', self::$_imported)) {
                        spl_autoload_register('Doctrine_Core::autoload');
                        spl_autoload_unregister('Candy::autoloadModel');
                }
                spl_autoload_unregister('Candy::autoload');
        }

}
