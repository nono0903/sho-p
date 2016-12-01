<?php 
namespace  Home\Controller;
use Think\Controller;

class GoodsController extends Controller{
	public function goods(){
		$goods_id = I('goods_id');
		// dump($goods_id);
		// exit;
		
		$goods = D('goods');
		$good = $goods->find("$goods_id");

		 $comm = $goods->relationGet('comment');
		 // dump($comm);
		// if($goods){
		// 	$car = \Home\Tool\CarTool::getIns();
		// 	$car->add($goods['goods_id'],$goods['goods_name'],$goods['market_price'],$goods['shop_price']);
		// }
		
		if($good){
			$this->history($good);
			// dump(session('history'));
		}
		// $good->field('cat_id')->find("$goods_id");
		 // dump($good);
		 // exit();
		$mbx = $this->mbx($good['cat_id']) ;
		// dump($mbx);exit;
		// 发送面包屑导航
		$this->assign('mbx',$mbx);
		//发送商品信息到模版
		$this->assign('goods',$good);
		//发送评论信息到模版
		$this->assign('comms',$comm);
		$this->display();
	}

	public function history($info){
		$row = session('?history')?session('history'):array();//三元运算检测是否有session,有的话将session赋一个变量名$row放进去,没有的话建一个空数组;


		$goodsinfo=array();
		$goodsinfo['goods_name'] = $info['goods_name'];
		$goodsinfo['shop_price'] = $info['shop_price'];
		$goodsinfo['goods_id'] = $info['goods_id'];//以上步骤可以直接省略写成$goodsinfo[]=$info;取的是每次点击查询出现的商品.

		$row[$info['goods_id']] = $goodsinfo;//这里就比较绕了,但主要表达的意思是将goodsinfo变成一个二维数组的值,第一层为$row,键名为goods_id,值为goodsinfo这个数组,
		// $row = array_unique($row);
		if(count($row)>7){
			$key = key($row);
			unset($row[$key]);
			//还可以写成array_shift($row);用游标操作释放数组第一个单元,也就是最早查询出来的数据
		}
		// $row = array_reverse($row);
		session('history',$row);
	}

	public function mbx($cat_id){
		$tree = array();
		$cats =D('Admin/Cat');

		$row = $cats->find($cat_id);

		$tree[] = $row;

		while ($row['parent_id']>0) {
					$row = $cats->find($row['parent_id']);
					$tree[] = $row;

				}
				return array_reverse($tree);		
	}

	public function comment(){
		 // dump($_POST);
		 // exit;
		$verify = new \Think\Verify();
		if(!$verify->check(I('post.yzm'))){
			$this->error('验证码错误');
			exit;
		}else{
			$comm = D('Home/Comment');
			if(!$comm->create()){
				$this->error($comm->getError());
			}else{
				if($comm->add()){
					$this->success('评论成功!');
				}
			}
		}
	}

	public function yzm(){
		$yzm= new \Think\Verify();
		$yzm->imageH = 25;
		$yzm->imageW = 110;
		$yzm->fontSize = 14;
		$yzm->useNoise = false;
		$yzm->useCurve = false;
		// $yzm->codeSet = '0123456789';
		$yzm->length = 4;
		$yzm->entry();
	}
}




