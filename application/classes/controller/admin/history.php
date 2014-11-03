<?php

//历史沿革
class Controller_Admin_History extends Layout_Admin {

    function before() {
        parent::before();
        //自定义初始化内容
    }

    //列表展示
    function action_index() {

        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;


        $count = Doctrine_Query::create()
                ->select('hi.id')
                ->from('HistoryInfo hi')
                ->where('hi.is_hidden=0');

        $historys = Doctrine_Query::create()
                ->select('hi.date,hi.name,hc.name as college,hd.name as depart,hi.content,hi.grapheme,hp.name as professional,hi.create_date,hd.id as depart_id,hc.id as college_id,hp.id as professional_id')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryCollege hc')
                ->leftJoin('hi.HistoryDepart hd')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('hi.is_hidden=0')
                ->orderBy('create_date desc');

        if ($q) {
            $historys = Doctrine_Query::create()
                    ->select('hi.date,hi.name,hc.name as college,hd.name as depart,hi.content,hi.grapheme,hp.name as professional,hi.create_date,hd.id as depart_id,hc.id as college_id,hp.id as professional_id')
                    ->from('HistoryInfo hi')
                    ->leftJoin('hi.HistoryCollege hc')
                    ->leftJoin('hi.HistoryDepart hd')
                    ->leftJoin('hi.HistoryProfessional hp')
                    ->where('hi.is_hidden=0')
                    ->addWhere('hi.name like ? Or hc.name like ? OR  hd.name like ? OR hi.content like ? OR hi.grapheme like ? OR hp.name like ?', array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('hi.date asc');
        }
        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['historys'] = $historys->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_title('历史沿革');
        $this->_render('_body', $view);
    }

    //现在专业列表展示
    function action_professional() {

        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;


        $count = Doctrine_Query::create()
                ->select('id')
                ->from('HistoryProfessional')
                ->where('is_hidden=0');

        $professional = Doctrine_Query::create()
                ->select('hp.name,hc.name as college_id,hd.name as depart_id')
                ->from('HistoryProfessional hp')
                ->leftJoin('hp.HistoryCollege hc')
                ->leftJoin('hp.HistoryDepart hd')
                ->where('hp.is_hidden=0');

        if ($q) {
            $professional = Doctrine_Query::create()
                    ->select('hp.name,hc.name as college_id,hd.name as depart_id')
                    ->from('HistoryProfessional hp')
                    ->leftJoin('hp.HistoryCollege hc')
                    ->leftJoin('hp.HistoryDepart hd')
                    ->where('hp.is_hidden=0')
                    ->addWhere('hp.name like ? Or hc.name like ? OR  hd.name like ? ', array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hp.name using gbk) asc');
        }
        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['professional'] = $professional->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_title('历史沿革');
        $this->_render('_body', $view);
    }

    //学部列表
    function action_depart() {

        //修改和添加
        $id = Arr::get($_GET, 'id');
        $history = Doctrine_Query::create()
                ->from('HistoryDepart')
                ->where('id=?', $id)
                ->fetchOne();
        if ($_POST) {
            $post['name'] = Arr::get($_POST, 'name');
            if (!$history) {
                $history = new HistoryDepart();
                $history->fromArray($post);
                $history->save();
            } else {
                $history->fromArray($post);
                $history->save();
            }
        }

        $view['history'] = $history;


        //搜索列表和列表
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;
        $count = Doctrine_Query::create()
                ->select('hd.id')
                ->from('HistoryDepart hd')
                ->where('is_hidden=0');
        if ($q) {
            $historys = Doctrine_Query::create()
                    ->from('HistoryDepart')
                    ->where('is_hidden=0')
                    ->addWhere('name like ? ', array('%' . $q . '%'));
        } else {
            $historys = Doctrine_Query::create()
                    ->select('id,name')
                    ->from('HistoryDepart')
                    ->where('is_hidden=0');
        }

        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['historys'] = $historys->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_render('_body', $view);
    }

    //院系列表
    function action_college() {

        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;
        $count = Doctrine_Query::create()
                ->select('id')
                ->from('HistoryCollege')
                ->where('is_hidden=0');
        if ($q) {
            $historys = Doctrine_Query::create()
                    ->select('hc.id,hc.name as name, hd.name as depart,hd.id as depart_id')
                    ->from('HistoryCollege as hc')
                    ->leftJoin('hc.HistoryDepart as hd')
                    ->where('hc.is_hidden=0')
                    ->addWhere('hc.name like ? OR  hd.name like ? ', array('%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hc.name using gbk) asc');
        } else {
            $historys = Doctrine_Query::create()
                    ->select('hc.id,hc.name as name, hd.name as depart,hd.id as depart_id')
                    ->from('HistoryCollege as hc')
                    ->leftJoin('hc.HistoryDepart as hd')
                    ->where('hc.is_hidden=0');
        }

        $total_items = $count->count();
        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));
        $view['pager'] = $pager;

        $view['historys'] = $historys->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_render('_body', $view);
    }

    //修改或添加
    function action_form() {
        $id = Arr::get($_GET, 'id', 0);
        $view['err'] = '';

        $history_depart = Doctrine_Query::create()
                ->from('HistoryDepart')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history_depart'] = $history_depart;

        

        $history_profession = Doctrine_Query::create()
                ->from('HistoryProfessional')
                ->fetchArray();
        $view['history_professional'] = $history_profession;


        $history = Doctrine_Query::create()
                ->from('HistoryInfo hi')
                ->select('hi.*')
                ->where('id=?', $id)
                ->fetchOne();
        $view['history'] = $history;

        $this->_render('_body', $view);
    }

    //现有专业修改或添加
    function action_professionalform() {
        $id = Arr::get($_GET, 'id', 0);
        $q = Arr::get($_POST, 'depart_id');
        $view['err'] = '';

        $history_depart = Doctrine_Query::create()
                ->from('HistoryDepart')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history_depart'] = $history_depart;


        $history_college = Doctrine_Query::create()
                ->from('HistoryCollege')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history_college'] = $history_college;

        $history_professional = Doctrine_Query::create()
                ->from('HistoryProfessional hp')
                ->select('hp.*')
                ->where('id=?', $id)
                ->fetchOne();
        $view['history_professional'] = $history_professional;

        $this->_render('_body', $view);
    }

    //院系修改或添加
    function action_collegeform() {
        $id = Arr::get($_GET, 'id', 0);
        $view['err'] = '';

        $history_depart = Doctrine_Query::create()
                ->from('HistoryDepart')
                ->where('is_hidden=0')
                ->fetchArray();
        $view['history_depart'] = $history_depart;

        $history_college = Doctrine_Query::create()
                ->from('HistoryCollege hc')
                ->select('hc.*')
                ->where('is_hidden=0')
                ->addWhere('id=?', $id)
                ->fetchone();
        $view['history_college'] = $history_college;


        $this->_render('_body', $view);
    }

    //删除专业
    function action_del() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $history = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryInfo')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '删除专业信息';
        $log_data['description'] = '删除了“' . $history['name'] . '”专业信息';
        Common_Log::add($log_data);

        $del = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 1)
                ->where('id=?', $cid)
                ->execute();
    }

    //删除现有专业
    function action_professionaldel() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $history = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryProfession')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '删除专业信息';
        $log_data['description'] = '删除了“' . $history['name'] . '”专业信息';
        Common_Log::add($log_data);

        $del = Doctrine_Query::create()
                ->delete('HistoryProfessional')
                ->where('id=?', $cid)
                ->execute();
    }

    //删除学部
    function action_delDepart() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $depart = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryDepart')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '删除学部';
        $log_data['description'] = '删除了学部“' . $depart['name'] . '”及所有该学部下的所有院系和专业';
        Common_Log::add($log_data);

        $delDepart = Doctrine_Query::create()
                ->update('HistoryDepart')
                ->set('is_hidden=?', 1)
                ->where('id=?', $cid)
                ->execute();
        $delCollege = Doctrine_Query::create()
                ->update('HistoryCollege')
                ->set('is_hidden=?', 1)
                ->where('depart_id=?', $cid)
                ->execute();

        $del = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 1)
                ->where('depart_id=?', $cid)
                ->execute();
    }

    //删除院系
    function action_delCollege() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $college = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryCollege')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '删除院系';
        $log_data['description'] = '删除了院系“' . $college['name'] . '”及所有该院系下的专业';
        Common_Log::add($log_data);


        $delCollege = Doctrine_Query::create()
                ->update('HistoryCollege')
                ->set('is_hidden=?', 1)
                ->where('id=?', $cid)
                ->execute();

        $del = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 1)
                ->where('college_id=?', $cid)
                ->execute();
    }

    //删除学部列表
    function action_delDepartIndex() {
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;
        $count = Doctrine_Query::create()
                ->select('hd.id')
                ->from('HistoryDepart hd')
                ->where('is_hidden=1');
        if ($q) {
            $departs = Doctrine_Query::create()
                    ->from('HistoryDepart')
                    ->where('is_hidden=1')
                    ->addWhere('name like ? ', array('%' . $q . '%'))
                    ->orderBy('convert(name using gbk) asc');
        } else {
            $departs = Doctrine_Query::create()
                    ->select('id,name')
                    ->from('HistoryDepart')
                    ->where('is_hidden=1')
                    ->orderBy('convert(name using gbk) asc');
        }
        $total_items = $count->count();
        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));
        $view['pager'] = $pager;

        $view['departs'] = $departs->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_render('_body', $view);
    }

    //删除院系列表
    function action_delCollegeIndex() {
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;
        $count = Doctrine_Query::create()
                ->select('hc.id')
                ->from('HistoryCollege hc')
                ->where('is_hidden=1');
        if ($q) {
            $colleges = Doctrine_Query::create()
                    ->select('hc.id,hc.name as name, hd.name as depart_id')
                    ->from('HistoryCollege as hc')
                    ->leftJoin('hc.HistoryDepart as hd')
                    ->where('hc.is_hidden=1')
                    ->addWhere('hc.name like ? OR  hd.name like ? ', array('%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hc.name using gbk) asc');
        } else {
            $colleges = Doctrine_Query::create()
                    ->select('hc.name,hd.name as depart_id')
                    ->from('HistoryCollege as hc')
                    ->leftJoin('hc.HistoryDepart as hd')
                    ->where('hc.is_hidden=1')
                    ->orderBy('convert(hc.name using gbk) asc');
        }
        $total_items = $count->count();
        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));
        $view['pager'] = $pager;

        $view['colleges'] = $colleges->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_render('_body', $view);
    }

    //删除专业列表
    function action_delIndex() {
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;

        $count = Doctrine_Query::create()
                ->select('hi.id')
                ->from('HistoryInfo hi')
                ->where('is_hidden=1');

        $historys = Doctrine_Query::create()
                ->select('hi.date,hi.name,hc.name as college_id, hd.name as depart_id,hi.content,hi.grapheme,hp.name as professional_id')
                ->from('HistoryInfo as hi')
                ->leftJoin('hi.HistoryCollege as hc')
                ->leftJoin('hi.HistoryDepart as hd')
                ->leftJoin('hi.HistoryProfessional as hp')
                ->where('hi.is_hidden=1')
                ->orderBy('convert(hi.name using gbk) asc');

        if ($q) {
            $historys = Doctrine_Query::create()
                    ->select('hi.date,hi.name,hc.name as college_id, hd.name as depart_id,hi.content,hi.grapheme,hp.name as professional_id')
                    ->from('HistoryInfo as hi')
                    ->leftJoin('hi.HistoryCollege as hc')
                    ->leftJoin('hi.HistoryDepart as hd')
                    ->leftJoin('hi.HistoryProfessional as hp')
                    ->where('hi.is_hidden=1')
                    ->addWhere('hi.name like ? Or hc.name like ? OR  hd.name like ? OR hi.content like ? OR hi.grapheme like ?', array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hi.name using gbk) asc');
        }
        $total_items = $count->count();
        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));
        $view['pager'] = $pager;

        $view['historys'] = $historys->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();


        $this->_render('_body', $view);
    }

    //恢复学部
    function action_BackDepart() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $depart = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryDepart')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '恢复学部';
        $log_data['description'] = '恢复了学部“' . $depart['name'] . '”及所有该学部下的所有院系和专业';
        Common_Log::add($log_data);

        $backDepart = Doctrine_Query::create()
                ->update('HistoryDepart')
                ->set('is_hidden=?', 0)
                ->where('id=?', $cid)
                ->execute();
        $backCollege = Doctrine_Query::create()
                ->update('HistoryCollege')
                ->set('is_hidden=?', 0)
                ->where('depart_id=?', $cid)
                ->execute();

        $back = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 0)
                ->where('depart_id=?', $cid)
                ->execute();
    }

    //恢复院系
    function action_BackCollege() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');



        $college = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryCollege')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '恢复院系';
        $log_data['description'] = '恢复了院系“' . $college['name'] . '”及所有该院系下的专业';
        Common_Log::add($log_data);

        $backCollege = Doctrine_Query::create()
                ->update('HistoryCollege')
                ->set('is_hidden=?', 0)
                ->where('id=?', $cid)
                ->execute();
        $back = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 0)
                ->where('college_id=?', $cid)
                ->execute();
    }

    //恢复专业
    function action_Back() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_GET, 'cid');

        $history = Doctrine_Query::create()
                ->select('*')
                ->from('HistoryInfo')
                ->where('id=?', $cid)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $log_data = array();
        $log_data['type'] = '恢复专业信息';
        $log_data['description'] = '恢复了“' . $history['name'] . '”专业信息';
        Common_Log::add($log_data);

        $back = Doctrine_Query::create()
                ->update('HistoryInfo')
                ->set('is_hidden=?', 0)
                ->where('id=?', $cid)
                ->execute();
    }

    //下载成员名单
    function action_export() {
        $this->auto_render = FALSE;
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;
        $this->request->headers['Content-Type'] = 'application/ms-excel';

        //导入excel类
        Candy::import('excelMaker');

        if ($q) {
            $historys = Doctrine_Query::create()
                    ->select('hi.date,hi.name,hc.name as college_id, hd.name as depart_id,hi.content,hi.grapheme,hp.name as professional_id')
                    ->from('HistoryInfo  hi')
                    ->leftJoin('hi.HistoryCollege  hc')
                    ->leftJoin('hi.HistoryDepart  hd')
                    ->leftJoin('hi.HistoryProfessional hp')
                    ->where('hi.is_hidden=0')
                    ->addWhere('hi.name like ? Or hc.name like ? OR  hd.name like ? OR hi.content like ? OR hi.grapheme like ? OR hp.name like ?', array('%' . $q . '%','%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))
                    ->orderBy('convert(hi.name using gbk) asc')
                    ->fetchArray();
            $xls[1] = array('时间', '专业', '院系', '学部', '现所属专业', '字母', '变革信息',);

            //以下顺序必须与以上中文名称对应
            foreach ($historys as $i => $m) {
                $xls[$i + 2][] = $m['date'];
                $xls[$i + 2][] = $m['name'];
                $xls[$i + 2][] = $m['college_id'];
                $xls[$i + 2][] = $m['depart_id'];
                $xls[$i + 2][] = $m['professional_id'];
                $xls[$i + 2][] = $m['grapheme'];
                $xls[$i + 2][] = $m['content'];
            }
        } else {
            $historys = Doctrine_Query::create()
                    ->select('hi.date,hi.name,hc.name as college_id, hd.name as depart_id,hi.content,hi.grapheme,hp.name as professional_id')
                    ->from('HistoryInfo  hi')
                    ->leftJoin('hi.HistoryCollege  hc')
                    ->leftJoin('hi.HistoryDepart  hd')
                    ->leftJoin('hi.HistoryProfessional hp')
                    ->where('hi.is_hidden=0')
                    ->orderBy('convert(hi.name using gbk) asc')
                    ->fetchArray();
            $xls[1] = array('专业', '院系', '学部', '现所属专业', '字母');

            //以下顺序必须与以上中文名称对应
            foreach ($historys as $i => $m) {
                $xls[$i + 2][] = $m['name'];
                $xls[$i + 2][] = $m['college_id'];
                $xls[$i + 2][] = $m['depart_id'];
                $xls[$i + 2][] = $m['professional_id'];
                $xls[$i + 2][] = $m['grapheme'];
            }
        }

        $excel = new Excel_Xml('UTF-8');
        $excel->addArray($xls);
        $excel->generateXML('history');
    }

    //校友反馈信息列表
    function action_lists() {
        $q = urldecode(Arr::get($_GET, 'q'));
        $view['q'] = $q;

        $count = Doctrine_Query::create()
                ->select('ha.id')
                ->from('HistoryAlumni ha');

        $historyalumnis = Doctrine_Query::create()
                ->select('ha.content,ha.image,u.realname as user_id,create_date,is_read,is_implement')
                ->from('HistoryAlumni ha')
                ->leftJoin('ha.User u')
                ->orderBy('create_date desc');

        if ($q) {
            $historyalumnis = Doctrine_Query::create()
                    ->select('ha.content,ha.image,u.realname as user_id,create_date,is_read,is_implement')
                    ->from('HistoryAlumni ha')
                    ->leftJoin('ha.User u')
                    ->addWhere('ha.content like ? ', array('%' . $q . '%'))
                    ->orderBy('create_date desc');
        }
        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['historyalumnis'] = $historyalumnis->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_title('历史沿革');
        $this->_render('_body', $view);
    }

    //校友反馈信息查看
    function action_view() {
        $id = Arr::get($_GET, 'id');
        $historyalumnis = Doctrine_Query::create()
                ->from('HistoryAlumni')
                ->where('id=?', $id)
                ->fetchOne();

        $view['historyalumnis'] = $historyalumnis;
        $this->_render('_body', $view);
    }

    //自动提示
    public function action_Autocomplete() {
        $this->auto_render = FALSE;
        $q = Arr::get($_GET, 'searchDbInforItem');
        $record = Doctrine_Query::create()
                ->select('id as value, name as label')
                ->from('HistoryProfessional')
                ->where('name like "%' . $q . '%"')
                ->orderBy('id ASC')
                ->fetchArray();
        echo json_encode($record);
    }

    //ajax院系选择
    public function action_collegeid() {
        $this->auto_render = FALSE;
        $q = Arr::get($_POST, 'depart_id');
        $record = Doctrine_Query::create()
                ->select('id,name')
                ->from('HistoryCollege')
                ->where('depart_id=?', $q)
                ->orderBy('id ASC')
                ->fetchArray();
        echo json_encode($record);
    }

    //点击学部列出该学部下所有的院系
    function action_collegelist() {
        $id = Arr::get($_GET, 'id');
        $count = Doctrine_Query::create()
                ->select('id')
                ->from('HistoryCollege')
                ->where('is_hidden=0')
                ->addwhere('depart_id=?',$id);
        $college = Doctrine_Query::create()
                ->select('hc.id,hc.name,hd.name as depart_id')
                ->from('HistoryCollege hc')
                ->leftJoin('hc.HistoryDepart hd')
                ->where('is_hidden=0')
                ->addwhere('depart_id=?', $id);
        
        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['college'] = $college->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();
        $this->_render('_body', $view);
    }

    //点击现在专业显示跟现在专业相关的信息
    function action_professionallist() {
        $id = Arr::get($_GET, 'id');
        $count = Doctrine_Query::create()
                ->select('id')
                ->from('HistoryInfo')
                ->where('is_hidden=0');
        $history = Doctrine_Query::create()
                ->select('hi.date,hi.name,hc.name as college,hd.name as depart,hi.content,hi.grapheme,hp.name as professional,hi.create_date,hd.id as depart_id,hc.id as college_id,hp.id as professional_id')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryCollege hc')
                ->leftJoin('hi.HistoryDepart hd')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('professional_id=?', $id)
                ->addWhere('is_hidden=0')
                ->orderBy('date');

        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['history'] = $history->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();
        $this->_render('_body', $view);
    }

    //点击院系展示院系下的专业
    function action_list() {
        $id = Arr::get($_GET, 'id');
        $count = Doctrine_Query::create()
                ->select('id')
                ->from('HistoryInfo')
                ->where('is_hidden=0');
        $history = Doctrine_Query::create()
                ->select('hi.date,hi.name,hc.name as college,hd.name as depart,hi.content,hi.grapheme,hp.name as professional,hi.create_date,hd.id as depart_id,hc.id as college_id,hp.id as professional_id')
                ->from('HistoryInfo hi')
                ->leftJoin('hi.HistoryCollege hc')
                ->leftJoin('hi.HistoryDepart hd')
                ->leftJoin('hi.HistoryProfessional hp')
                ->where('college_id=?', $id)
                ->addWhere('is_hidden=0')
                ->orderBy('date');

        $total_items = $count->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_items,
                    'items_per_page' => 15,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;

        $view['history'] = $history->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();
        $this->_render('_body', $view);
    }

    //是否已读反馈信息
    function action_read() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_POST, 'cid');
        $historyalumni = Doctrine_Query::create()
                ->from('HistoryAlumni')
                ->where('id = ?', $cid)
                ->fetchOne();
        if ($historyalumni['is_read'] == TRUE) {
            $historyalumni['is_read'] = FALSE;
        } else {
            $historyalumni['is_read'] = TRUE;
        }
        $historyalumni->save();
    }

    //是否对校友反馈信息进行处理
    function action_do() {
        $this->auto_render = FALSE;
        $cid = Arr::get($_POST, 'cid');
        $historyalumni = Doctrine_Query::create()
                ->from('HistoryAlumni')
                ->where('id = ?', $cid)
                ->fetchOne();
        if ($historyalumni['is_implement'] == TRUE) {
            $historyalumni['is_implement'] = FALSE;
        } else {
            $historyalumni['is_implement'] = TRUE;
        }
        $historyalumni->save();
    }

}
