<?php 
namespace Admin\Controller;
use Think\Controller;
class userController extends Controller{
	public function yzm(){
		$this->display();
	}
	public function yz(){
		$verify = new \Think\Verify();
		$verify->imagew = 140;
		$verify->imageh = 40;
		$verify->length = 4;
		$verify->useNoise = true;
		$verify->entry(); 

	}

	public function checkyzm(){

		$verify = new \Think\Verify();
		var_dump(I('post.yzm'));
		// exit;

		if($verify->check(I('yzm'))){
			echo '正确,mu~en~一个~~';

	}else{
		echo'错啦,罚站~';
	}
}
}
 ?>
