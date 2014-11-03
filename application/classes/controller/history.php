<?php

/*
 * 历史沿革
 */

class Controller_History extends Layout_Main {

    function before() {
        parent::before();
    }

    //首页
    function action_index() {
        $history = Doctrine_Query::create()
                ->select('id,name')
                ->from('HistoryCollege')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history'] = $history;

        $this->_title('历史沿革');
        $this->_render('_body', $view);
    }

    //前台搜索功能
    function action_searh() {
        $q = urldecode(Arr::get($_GET, 'q'));
        $id = Arr::get($_GET, 'id');
        $view['q'] = $q;

        $count = Doctrine_Query::create()
                ->select('hi.id')
                ->from('HistoryInfo hi')
                ->where('is_hidden=0');
        $history = Doctrine_Query::create()
                ->select('id,name')
                ->from('HistoryCollege')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history'] = $history;
        if ($q) {

            $historys = Doctrine_Query::create()
                    ->select('hi.name,hc.name as college_id,hd.name as depart_id,hi.grapheme,hp.name as professional_name,hi.professional_id,hp.id as id')
                    ->from('HistoryInfo hi')
                    ->leftJoin('hi.HistoryCollege hc')
                    ->leftJoin('hi.HistoryDepart hd')
                    ->leftJoin('hi.HistoryProfessional hp')
                    ->where('hi.is_hidden=0')
                    ->addWhere('hi.name like ? Or hc.name like ? OR  hd.name like ?  OR hp.name like ? OR hi.grapheme like ?', array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hi.name using gbk) asc');
        }
        if ($id) {
            $historys = Doctrine_Query::create()
                    ->select('hi.name,hc.name as college_id,hd.name as depart_id,hi.grapheme,hp.name as professional_name,hi.professional_id,hp.id as id')
                    ->from('HistoryInfo hi')
                    ->leftJoin('hi.HistoryCollege hc')
                    ->leftJoin('hi.HistoryDepart hd')
                    ->leftJoin('hi.HistoryProfessional hp')
                    ->where('hi.is_hidden=0')
                    ->addWhere('college_id=?', $id)
                    ->orderBy('convert(hi.name using gbk) asc');
        }
        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 20,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['historys'] = $historys->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_title('历史沿革');
        $this->_render('_body', $view);
    }

    //展示页
    function action_view() {
        $id = Arr::get($_GET, 'id');
        $cid=Arr::get($_GET, 'cid');
        if($id){
             $history=  Doctrine_Query::create()
                ->select('hp.name as name')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('hp.id=?',$id)
                ->fetchOne();
        $historys = Doctrine_Query::create()
                ->select('hc.name as faculty_id,hi.name,hi.date,hi.content,professional_id')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryCollege hc')
                ->leftJoin('hi.HistoryDepart hd')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('hi.is_hidden=0')
                ->addWhere('professional_id=?', $id)
                ->orderBy('date')
                ->fetchArray();
        }
        if($cid){
             $history=  Doctrine_Query::create()
                ->select('hp.name as name')
               ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('hp.id=?',$cid)
                ->fetchOne();
             $historys = Doctrine_Query::create()
                ->select('hc.name as faculty_id,hi.name,hi.date,hi.content,professional_id')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryCollege hc')
                ->leftJoin('hi.HistoryDepart hd')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('hi.is_hidden=0')
                ->addWhere('hp.id=?', $cid)
                ->orderBy('date')
                ->fetchArray();
        }
        $view['history'] = $history;
        $view['historys'] = $historys;
        $this->_render('_body', $view);
    }

    //校友反馈
    function action_from() {
        $id = Arr::get($_GET, 'id', 0);
        $view['err'] = '';


        $historyalumnis = Doctrine_Query::create()
                ->from('HistoryAlumni ha')
                ->select('ha.*')
                ->where('id=?', $id)
                ->fetchOne();
        $view['historyalumnis'] = $historyalumnis;

        $this->_render('_body', $view);
    }

    //增校友反馈
    function action_usercreate() {
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_alumni');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['content'] = Arr::get($_POST, 'content');
                $post['image'] = isset($post['imgage']) ? $post['imgage'] : null;
                $post['user_id'] = Arr::get($_POST, 'user_id');
                $post['create_date'] = $post['create_date'] ? $post['create_date'] : date('Y-m-d H:i:s');
                $history = new HistoryAlumni();
                $history->fromArray($post);
                $history->save();
            }
        }
    }

    //新增专业历史
    function action_create() {
        $create_from = Arr::get($_POST, 'create_from');

        if ($_POST) {
            if (!$_POST['depart_id']) {
                echo Candy::MARK_ERR . '请选择学部分类';
                exit;
            }
            $v = Validate::setRules($_POST, 'history_info');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['content'] = Arr::get($_POST, 'content');
                $post['name'] = Arr::get($_POST, 'name');
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['college_id'] = Arr::get($_POST, 'college_id');
                $post['professional_id'] = Arr::get($_POST, 'professional_id');
                $post['grapheme'] = Arr::get($_POST, 'grapheme');
                $post['date'] = Arr::get($_POST, 'date');
                $post['create_date'] = $post['create_date'] ? $post['create_date'] : date('Y-m-d H:i:s');
                $history = new HistoryInfo();
                $history->fromArray($post);
                $history->save();

                //发布成功
                if ($history->id) {
                    echo $history->id;
                }


                if ($this->_role == '管理员') {
                    $log_data = array();
                    $log_data['type'] = '新增专业';
                    $log_data['description'] = '新增专业“' . $post['name'] . '”';
                    Common_Log::add($log_data);
                }

                if ($create_from == 'sys_admin') {
                    $this->_redirect('admin_history');
                }
            }
        }
    }

    //更新专业历史
    function action_update() {
        $create_from = Arr::get($_POST, 'create_from');
        $id = Arr::get($_POST, 'id');
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_info');
            if (!$_POST['depart_id']) {
                echo Candy::MARK_ERR . '请选择分类';
                exit();
            }
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['college_id'] = Arr::get($_POST, 'college_id');
                $post['professional_id'] = Arr::get($_POST, 'professional_id');
                $post['name'] = Arr::get($_POST, 'name');
                $post['content'] = Arr::get($_POST, 'content');
                $post['date'] = Arr::get($_POST, 'date');
                $post['grapheme'] = Arr::get($_POST, 'grapheme');

                $history = Doctrine_Query::create()->from('HistoryInfo')
                        ->where('id = ?', $id)
                        ->fetchOne();

                unset($post['id']);
                $history->synchronizeWithArray($post);
                $history->save();

                if ($this->_role == '管理员') {
                    $log_data = array();
                    $log_data['type'] = '修改专业';
                    $log_data['description'] = '修改了专业“' . $post['name'] . '”';
                    Common_Log::add($log_data);
                }
            }
        }
        if ($create_from == 'sys_admin') {
            $this->_redirect('admin_history');
        }
    }

    //新增现有专业
    function action_professionalcreate() {
        $create_from = Arr::get($_POST, 'create_from');
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_professional');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['college_id'] = Arr::get($_POST, 'college_id');
                $post['name'] = Arr::get($_POST, 'name');
                $history = new HistoryProfessional();
                $history->fromArray($post);
                $history->save();
            }
        }
        //发布成功
        if ($history->id) {
            echo $history->id;
        }
        if ($create_from == 'sys_admin') {
            $this->_redirect('admin_history');
        }
    }

    //现有专业更新
    function action_professionalupdate() {
        $create_from = Arr::get($_POST, 'create_from');
        $id = Arr::get($_POST, 'id');
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_professional');
            if (!$_POST['depart_id']) {
                echo Candy::MARK_ERR . '请选择分类';
                exit();
            }
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['college_id'] = Arr::get($_POST, 'college_id');
                $post['name'] = Arr::get($_POST, 'name');

                $history = Doctrine_Query::create()->from('HistoryProfessional')
                        ->where('id = ?', $id)
                        ->fetchOne();

                unset($post['id']);
                $history->synchronizeWithArray($post);
                $history->save();
            }
        }
        if ($create_from == 'sys_admin') {
            $this->_redirect('admin_history');
        }
    }

    //新增院系
    function action_collegecreate() {
        $create_from = Arr::get($_POST, 'create_from');
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_college');
            $post = $v->getData();
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['name'] = Arr::get($_POST, 'name');
                $history = new HistoryCollege();
                $history->fromArray($post);
                $history->save();
            }
        }
        //发布成功
        if ($history->id) {
            echo $history->id;
        }
        if ($create_from == 'sys_admin') {
            $this->_redirect('admin_history');
        }
    }

    //院系更新
    function action_collegeupdate() {
        $create_from = Arr::get($_POST, 'create_from');
        $id = Arr::get($_POST, 'id');
        if ($_POST) {
            $v = Validate::setRules($_POST, 'history_college');
            if (!$_POST['depart_id']) {
                echo Candy::MARK_ERR . '请选择分类';
                exit();
            }
            if (!$v->check()) {
                echo Candy::MARK_ERR . $v->outputMsg($v->errors('validate'));
            } else {
                $post['depart_id'] = Arr::get($_POST, 'depart_id');
                $post['name'] = Arr::get($_POST, 'name');

                $history = Doctrine_Query::create()->from('HistoryCollege')
                        ->where('id = ?', $id)
                        ->fetchOne();

                unset($post['id']);
                $history->synchronizeWithArray($post);
                $history->save();
            }
        }
        if ($create_from == 'sys_admin') {
            $this->_redirect('admin_history');
        }
    }

    //搜索
    function action_search() {
        $q = urldecode(Arr::get($_GET, 'q'));

        $history = Doctrine_Query::create()
                ->from('HistoryInfo hi')
                ->leftJoin('HistoryCollege hc')
                ->leftJoin('HistoryDepart hd')
                ->where('hi.name like ? Or hc.name like ? OR  hd.name like ? OR hi.content like ?', array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%'));
        $pager = Pagination::factory(array(
                    'total_items' => $history->count(),
                    'items_per_Page' => 10,
                    'view' => 'page/common',
        ));
        $view['pager'] = $pager;
        $view['q'] = $q;
        $view['history'] = $history->limit($pager->items_per_page)
                ->offset($pager->offset)
                ->fetchArray();
        $this->_title('有关"' . $q . '"的专业');
        $this->_redirect('_body', $view);
    }

}
