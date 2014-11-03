<?php

defined('SYSPATH') or die('No direct script access.');

class View extends Kohana_View {

        /**
         * 获取VIEW的全局变量
         * @param <type> $key
         * @return <type>
         */
        public static function get_global($key=null) {
                if ($key) {
                        return Arr::get(self::$_global_data, $key);
                }
                return self::$_global_data;
        }

        /**
         * 渲染kindeditor
         * @param <type> $id textarea id
         * @param <type> $attrs ke.attrs
         * @param <type> $init 如果同一页面第二次加载则设为false
         * @return <type>
         */
        public static function keditor($id, $attrs=array()) {
                $base_path = 'kindeditor/';

                $view['skinsPath'] = URL::base() . $base_path . 'skins/';
                $view['pluginsPath'] = URL::base() . $base_path . 'plugins/';

                if (@$attrs['allowUpload']) {
                        //$view['imageUploadJson'] = '/album/uploadAttached/';
                        $view['imageUploadJson'] = URL::base() . $base_path . 'upload_json.php';
                }

                if (@$attrs['allowFileManager']) {
                        $view['fileManagerJson'] = URL::base() . $base_path . 'file_manager_json.php';
                }

                $view['id'] = $id;
                $view['attrs'] = $attrs;
                return array(
                    'init' => Html::script($base_path . 'init.js'),
                    'show' => View::factory('addons/keditor', $view),
                );
        }

        //百度ueditor1.2
//        public static function ueditor($id, $attrs=array()) {
//                return View::factory('addons/ueditor1_2_2', array(
//                            'id' => $id,
//                            'attrs' => $attrs,
//                        ));
//        }

        //百度ueditor1.2.5.1
//        public static function ueditor($id, $attrs=array()) {
//                return View::factory('addons/ueditor1_2_5_1', array(
//                            'id' => $id,
//                            'attrs' => $attrs,
//                        ));
//        }
        
        //百度ueditorueditor1_2_6_0
        public static function ueditor($id, $attrs=array()) {
                return View::factory('addons/ueditor1_2_6_0', array(
                            'id' => $id,
                            'attrs' => $attrs,
                        ));
        }
        
        //百度ueditorueditor1_3_6
        public static function ueditorLast($id, $attrs=array()) {
                return View::factory('addons/ueditor1_3_6', array(
                            'id' => $id,
                            'attrs' => $attrs,
                        ));
        }

}