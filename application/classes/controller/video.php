<?php

class Controller_Video extends Layout_Main {

    function action_index() {
        $video = Doctrine_Query::create()
                ->select('v.*')
                ->from('Video v')
                ->where('v.id IS NOT NULL');

        $video->orderBy('id DESC');

        $total_video = $video->count();

        $pager = Pagination::factory(array(
                    'total_items' => $total_video,
                    'items_per_page' => 12,
                    'view' => 'pager/common',
        ));

        $view['pager'] = $pager;
        $view['video'] = $video->offset($pager->offset)
                ->limit($pager->items_per_page)
                ->fetchArray();

        $this->_title('校友讲堂');
        $this->_render('_body', $view);
    }

    function action_view() {
        $id = Arr::get($_GET, 'id');
        $video = Doctrine_Query::create()
                ->from('Video')
                ->where('id=?', $id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);

        $view['video'] = $video;

        if (!$video) {
            $this->request->redirect('main/notFound');
        }

        $this->_title($video['title']);
        $this->_render('_body', $view);
    }

}

?>
