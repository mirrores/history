<?php

class Db_Wedding {
    
    //支持单位分类
    public static function sponsorsCategory(){
        return array(
            array('id'=>1,'name'=>'合作单位'),
            array('id'=>2,'name'=>'鸣谢单位')
        );
    }
    
    //支持单位分类
    public static function getSponsorsCategoryName($id){
        foreach (self::sponsorsCategory() as $c) {
            if($c['id']==$id){
                return $c['name'];
            }
        }
    }
    
    //获取抽奖id
    public static function getLottery($wedding_id){
        $record = Doctrine_Query::create()
                ->from('WeddingLottery')
                ->where('wedding_id=?',$wedding_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        return $record;
    }

    //获取婚礼基本介绍
    public static function getById($id) {
        $wedding = DB::select(DB::expr('e.*'))
                ->from(array('wedding', 'e'))
                ->where('e.id', '=', $id)
                ->execute()
                ->as_array();
        return $wedding ? $wedding[0] : array();
    }

    //获取婚礼基本介绍
    public static function getByYear($year = 0) {
        $wedding = DB::select(DB::expr('e.*'))
                ->from(array('wedding', 'e'))
                ->where('e.year', '=', $year)
                ->execute()
                ->as_array();
        return $wedding ? $wedding[0] : array();
    }

    //获取最新一届活动
    public static function getLatest() {
        $wedding = DB::select(DB::expr('e.*'))
                ->from(array('wedding', 'e'))
                ->order_by('e.year','DESC')
                ->order_by('e.id','DESC')
                ->execute()
                ->as_array();
        return $wedding ? $wedding[0] : array();
    }

    //获取婚礼报名人数
    public static function getCountSigner($id) {
        return Doctrine_Query::create()
                ->select('s.id')
                ->from('WeddingSign s')
                ->where('wedding_id = ?', $id)
                ->count();
    }

    //获取报名总人数
    public static function getSigner($id, $limit = 10) {
        $signer = Doctrine_Query::create()
                ->select('s.id,s.wedding_id,s.user_id,s.bridegroom_name,s.bride_name,s.sign_at,s.love_declaration,s.photo_path')
                ->from('WeddingSign s')
                ->where('wedding_id = ?', $id)
                ->limit($limit)
                ->orderBy('s.id DESC')
                ->fetchArray();
        return $signer;
    }

    //热门新人
    public static function hotSigner($id, $limit = 10) {
        $signer = Doctrine_Query::create()
                ->select('s.id,s.wedding_id,s.user_id,s.bridegroom_name,s.bride_name,s.sign_at,s.love_declaration,s.photo_path,s.good_num,s.hits_num')
                ->from('WeddingSign s')
                ->where('wedding_id = ?', $id)
                ->limit($limit)
                ->orderBy('s.good_num DESC,s.hits_num DESC')
                ->fetchArray();
        return $signer;
    }

    //获取某一报名信息
    public static function getOneSign($id) {
        $sign = DB::select()
                ->from('wedding_sign')
                ->where('id', '=', $id)
                ->execute()
                ->as_array();
        return $sign ? $sign[0] : array();
    }

    //修改婚礼某字段值
    public static function update($id, $fields) {
        return DB::update('wedding')->set($fields)->where('id', '=', $id)->execute();
    }

    //修改bool类型值
    public static function setBoolValue($id, $field) {
        $wedding = self::getById($id);
        if ($wedding AND isset($wedding[$field])) {
            $bool = $wedding[$field] == 1 ? 0 : 1;
            $itmes = array();
            $itmes[$field] = $bool;
            return self::update($id, $itmes);
        } else {
            return false;
        }
    }

    //用户是否已经参加某婚礼
    public static function isJoined($wedding_id, $user_id = 0) {
        $r = Doctrine_Query::create()
                ->select('id')
                ->from('WeddingSign')
                ->where('wedding_id = ? AND user_id = ?', array($wedding_id, $user_id))
                ->execute(array(), 6);
        return (bool) $r;
    }

    //获取婚礼相册
    public static function getAlbum($wedding_id) {
        return array();
    }

    //是否具有婚礼管理权限
    //参数:婚礼数据
    public static function isManager() {
        $sess = Session::instance();
        // 网站管理员
        if ($sess->get('role') == '管理员') {
            return TRUE;
        }
        return FALSE;
    }

    //删除婚礼
    public static function delete($id) {

        //删除报名信息
        DB::delete('wedding_sign')->where('wedding_id', '=', $id)->execute();

        //删除评论
        //Db_Comment::delete(array('wedding_id' => $id));
        //删除相册及照片
        //Db_Album::delete(array('wedding_id' => $id));
        //从婚礼表删除
        DB::delete('wedding')->where('id', '=', $id)->execute();
    }

    //删除某一条报名信息
    public static function deleteSignById($id) {
        DB::delete('wedding_sign')->where('id', '=', $id)->execute();
    }

    //删除某一婚礼所有报名信息
    public static function deleteSignByWedding($wedding_id) {
        DB::delete('wedding_sign')->where('wedding_id', '=', $wedding_id)->execute();
    }

//返回当前用户对某一婚礼的控制权限
    public static function getPermission() {

        $sess = Session::instance();
        $user_role = $sess->get('role');

        //默认权限
        $permission = array();

        if ($user_role == '管理员') {
            $permission['is_edit_permission'] = True;
            $permission['is_control_permission'] = True;
            $permission['is_system_permission'] = True;
        } else {
            $permission['is_edit_permission'] = False;
            $permission['is_control_permission'] = False;
            $permission['is_system_permission'] = False;
        }
        return $permission;
    }

    //获取某一用户报名信息
    public static function getUserSign($wedding_id, $user_id) {

        $sign = Doctrine_Query::create()
                ->from('WeddingSign')
                ->where('wedding_id=?', $wedding_id)
                ->addWhere('user_id=?', $user_id)
                ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
        return $sign;
    }

}

?>
