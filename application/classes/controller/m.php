<?php

class Controller_M extends Layout_Mobile {

    function action_index() {
        $view = array();
        $view['news'] = Doctrine_Query::create()
                        ->from('News n')
                        ->where('n.is_draft = ?', FALSE)
                        ->select('n.id,n.title,n.create_at,n.title_color,n.is_pic')
                        ->orderBy('n.create_at DESC')
                        ->limit(5)
                        ->fetchArray();
        $this->_title('浙大校友网');
        $this->_render('_body', $view);
    }

    function action_photo() {
        $view = array();
        $img_path = '';
        $file_name = date("YmdHis");
        $view['img_path']='';
        if ($_POST) {
            if (isset($_FILES['file'])) {
                //如果存在附件
                if ($_FILES['file']['size'] > 0) {
                    //上传的图片附件
                    $valid = Validate::factory($_FILES);
                    $valid->rules('file', Model_News::$up_rule);
                    if (!$valid->check()) {
                        $view['err'] .= $valid->outputMsg($valid->errors('validate'));
                    } else {
                        // 处理图片附件
                        $path = DOCROOT . Model_News::FOCUS_PATH;
                        Upload::save($_FILES['file'], $file_name, $path);
                        //原尺寸
                        Image::factory($path . $file_name)
                                ->resize(null, null, Image::NONE)
                                ->save($path . $file_name . '.jpg');

                        Image::factory($path . $file_name)
                                ->resize(200, 150, Image::NONE)
                                ->save($path . $file_name . '_resize.jpg');

                        $view['img_path'] = URL::base() . Model_News::FOCUS_PATH . $file_name. '_resize.jpg';
                    }
                }
            }
        }
          $this->_render('_body', $view);
    }

}

?>
