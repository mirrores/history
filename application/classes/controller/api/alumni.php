<?php

//论坛
class Controller_Api_Alumni extends Layout_Mobile {

    //判断是否为校友
    function action_match() {
        $condition['realname'] = $this->getParameter('realname');
        $condition['start_year'] = $this->getParameter('start_year');
        $condition['graduation_year'] = $this->getParameter('graduation_year');
        $condition['speciality'] = $this->getParameter('speciality');
        $alumnis = Model_Alumni::getOneAlumni($condition);
        if ($alumnis) {
            $data['match'] = 'true';
        } else {
            $data['match'] = 'false';
        }
        $this->response($data,null, null);
    }

}

?>
