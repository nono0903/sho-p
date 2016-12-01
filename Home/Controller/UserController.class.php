<?php 
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller{
	
	public function login(){

		if(!IS_POST){
			$this->display();
		}else{
		$info = D('user');
		$username = I('post.username');
		// dump($username);exit;
		$user = $info->where("username = '$username'")->find();//扯淡的查询条件,必须在值的字段上加引号,要不报错
		// dump($user);exit;
		
		// if(!$user){//多此一举,只填密码提交应该不存在吧
		// 	$this->error('用户不存在!','login',3);
		// 	exit;
		// }else{

		// }
		$salt = $user['salt'];

		// dump(I()) ;
		// exit;
		// echo md5(I('post.password').$salt);
		// exit;

		if(md5(I('post.password').$salt) == $user['password']){
			cookie('username',$user['username']);
			cookie('code',md5($user['username'].C('salt')));
			$this->redirect('/');
			
		}else{

			$error = '用户名或者密码错误!';
			$this->redirect('Home/User/msg',array('error'=>$error));
		}

		}

	}

	public function logout(){
		cookie('username',null);
		cookie('code',null);
		$this->redirect('/');
	}

	
	public function msg(){

		$str = I('get.error');
		$this->assign('str',$str);
		$this->display();
		// $this->redirect('Home/User/msg');
	}

	public function reg(){
		if(!IS_POST){
		$this->display();
		}else{
		 // dump($_POST);
		 //  exit;
		$user = D('user');
		if(!$user->create()){
			echo $user->getError();
			exit;
		}else{
			$rand_str=substr(str_shuffle('asdafaASDASDbySuaiewf165484815'), 2,7);
			$user->password = md5($user->password.$rand_str);
			$user->salt = $rand_str;
			if($user->add()){
				$this->success('注册成功!','login',3);
			}
		}
		}
	}

	public function done(){
		$this->display();
	}

	// public function checkout(){
	// 	$this->assign('che',session('item'));
	// 	$this->display();
	// }




}


