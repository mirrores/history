<?php
class Controller_Card extends Layout_Main{
    public function before() {
	parent::before();
    }

    //龙卡首页
    function action_Index(){

	$id=  Arr::get($_GET,'id');

           $content= Doctrine_Query::create()
	    ->from('Content')
            ->where('type='.Model_Content::ZU_CARD_ID);
	   
	if($id){
	     $content->addWhere('id=?',$id);
	}
	else{
	      $content->orderBy('order_num ASC')
		      ->limit(1);
	}

	     $content=$content->fetchOne(array(),  Doctrine_Core::HYDRATE_ARRAY);

	if (!$content) {
	    $this->request->redirect('main/notFound');
	 }

	$this->_title($content['title']);
	$this->_render('_body',  compact('menus','content','id'));
    }

    //在线申请
    function action_Apply(){
	$menus=  Model_content::cardMenu();
	$id=  Arr::get($_GET,'local_id');
	$user_id=$this->_sess->get('id');
	$realname=null;
	$mobile=null;

	if($user_id){
	$user = Doctrine_Query::create()
		    ->select('mobile')
                    ->addSelect('u.realname AS realname')
                    ->from('UserContact uc')
		    ->leftJoin('uc.User u')
                    ->where('uc.user_id = ?', $user_id)
                    ->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
	$realname=$user['realname'];
	$mobile=$user['mobile'];
	}



	$err=null;
	$success=null;

	if($_POST){

            // 链接内容数据
            $valid = Validate::setRules($_POST, 'card');
            $post = $valid->getData();
            if( ! $valid->check()){
                $err .= $valid->outputMsg($valid->errors('validate'));
            } else {
                    $link = new CardApply();
		    $post['user_id']=$this->_sess->get('id');
		    $post['apply_at']=date('Y-m-d H:i:s');
                    $link->fromArray($post);
                    $link->save();
		    $success='恭喜您，您的申请已经提交，感谢您的支持！请等候我们的客服与您联系。';
            }
        }
	$this->_title('信用卡申请表');
	$this->_render('_body',  compact('menus','id','err','realname','mobile','success'));
    }

    function action_login(){
        $name=  Arr::get($_POST,'name');
	$password=Arr::get($_POST,'password');
	$err=Null;

	if($_POST){

	if(empty($name)||empty($password)){
	    $err='用户名或密码不能为空';
	}
	else{
	    if($name=='admin'&&$password=='zucard888'){
	      $this->_sess->set('card_admin', md5($password));
	      $this->_redirect('card_admin/');
	      break;

	    }
	    else{
                   $err='很抱歉，用户名或密码错误，请重试!';
	    }
	}
		}
	$this->_render('_body',  compact('err'));


    }
}
?>
