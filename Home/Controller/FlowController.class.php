<?php 
namespace Home\Controller;
use Think\Controller;
class FlowController extends Controller{
	public function add(){

		$goods = D('Admin/goods')->find(I('get.goods_id'));

		$car = \Home\Tool\CarTool::getIns();
		// $car->clear();
		if($goods){
			$car->add($goods['goods_id'],$goods['goods_name'],$goods['market_price'],$goods['shop_price']);				
		}
			$this->checkout();

		 // var_dump($car->items());
		 //  exit;
		// $this->redirect('User/checkout');
	}


	public function checkout(){
		$car = \Home\Tool\CarTool::getIns();
		dump(session('cart'));
		// exit();
		// $this->add(I());
		// session('cart');
		// $this->redirect('User/checkout');
		
		
		//发送所有商品信息到模版
		//
		$this->assign('che',$car->items());

		//发送商品的总个数
		$this->assign('num',$car->calcCnt());

		//发送购物车中商品的总价格
		$this->assign('money',$car->calcMoney());

		$this->display('User/checkout');
	}
	public function cle(){

			$car = \Home\Tool\CarTool::getIns();
			$car->clear();

			$this->display('User/checkout');


	}

}
// namespace Home\Controller;
// use Think\Controller;
// class FlowController extends Controller{
// 	public function add(){
// 		//$this->display('Goods/checkout');
// 		$goodsinfo = D('goods')->find(I('get.goods_id'));
// 		//var_dump($goodsinfo);
// 		$car = \Home\Tool\CarTool::getIns();
// 		//var_dump($car);
// 		if($goodsinfo){
// 			$car->add($goodsinfo['goods_id'],$goodsinfo['goods_name'],$goodsinfo['shop_price']);
// 		}	
// 		//$car->clear();
// 		// var_dump($car->item);
// 		//var_dump($car->item);
// 	}
// 	public function checkout(){
// 		$this->add();
// 		$this->assign('che',session('cart'));
// 		$this->display('User/checkout');
// 	}
// 	public function cle(){

// 		$car = \Home\Tool\CarTool::getIns();
// 		$car->clear();
// 		$this->display('User/checkout');


// 	}


// }