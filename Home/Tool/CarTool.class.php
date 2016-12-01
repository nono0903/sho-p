<?php 
namespace Home\Tool;

abstract class ACartTool {
	/**
	* 向购物车中添加1个商品
	* @param $goods_id int 商品id
	* @param $goods_name String 商品名
	* @param $shop_price float 价格
	* @return boolean
	*/
	abstract public function add($goods_id,$goods_name,$market_price,$shop_price);
	/**
	* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
	* @param $goods_id int 商品id
	*/
	abstract public function decr($goods_id);
	/**
	* 从购物车删除某商品
	* @param $goods_id 商品id
	*/
	abstract public function del($goods_id);
	/**
	* 列出购物车所有的商品
	* @return Array
	*/
	abstract public function items();
	/**
	* 返回购物车有几种商品
	* @return int
	*/
	abstract public function calcType();
	/**
	* 返回购物车中商品的个数
	* @return int
	*/
	abstract public function calcCnt();
	/**
	* 返回购物车中商品的总价格
	* @return float
	*/
	abstract public function calcMoney();
	/**
	* 清空购物车
	* @return void
	*/
	abstract public function clear();
}

class CarTool extends ACartTool{
	public static $ins = null;
	public $item = array();


	public static function getIns(){
			if (self::$ins == null){
				self::$ins = new self();
			}
			return self::$ins;
		}

	final protected function __construct(){

		
			$this->item = session('?cart')?session('cart'):array();
		
		
	}
	
	
	/**
	* 向购物车中添加1个商品
	* @param $goods_id int 商品id
	* @param $goods_name String 商品名
	* @param $shop_price float 价格
	* @return boolean
	*/
	public function add($goods_id,$goods_name,$shop_price,$market_price){
		if(isset($this->item[$goods_id])){
			$this->item[$goods_id]['num']+=1;
		}else{
		$goods = array('goods_name'=>$goods_name,'market_price'=>$market_price,'shop_price'=>$shop_price,'num'=>1);
		$this->item[$goods_id] = $goods;
		}
		  // session('cart',$this->item);

	 }
	 //按照抽象类封装方法,创建1个空数组item,在执行add添加的时候先做判断,如果检测到这个item的数组里存在有键为行参传过来的goods_id的时候执行num+1,否则创建这个2维数组

	/**
	* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
	* @param $goods_id int 商品id
	*/
	public function decr($goods_id){
		if (isset($this->item[$goods_id])) {
			$this->item[$goods_id]['num'] -= 1;
		}
		if ($this->item[$goods_id]['num']<=0) {
		 	$this->del($goods_id);
		 } 

	}
	
	/**
	* 从购物车删除某商品
	* @param $goods_id 商品id
	*/
	public function del($goods_id){
		//也可以写成$this->item[$goods_id]=array();
		unset($this->item[$goods_id]);

	}
	
	/**
	* 列出购物车所有的商品
	* @return Array
	*/
	public function items(){
		return $this->item;

	}
	
	/**
	* 返回购物车有几种商品
	* @return int
	*/
	public function calcType(){
		return count($this->item);

	}
	
	/**
	* 返回购物车中商品的个数
	* @return int
	*/
	public function calcCnt(){
		$num = 0;
		foreach ($this->item as  $v) {
			$num+=$v['num'];
		}
		return $num;

	}
	
	/**
	* 返回购物车中商品的总价格
	* @return float
	*/
	public function calcMoney(){
		$money = 0;
		foreach ($this->item as $v) {
			$money += $v['shop_price']*$v['num'];
		}
		return $money;
	}
	
	/**
	* 清空购物车
	* @return void
	*/
	public function clear(){
		$this->item = array();
	}

	/**
	 *
     */
	public function __destruct(){
		// $cart = $this->items();
        session('cart',$this->item);
		// session('cart');
		
	}
		
		
}

// 

// namespace Home\Tool;
// abstract class ACartTool {
// 		/**
// 		* 向购物车中添加1个商品
// 		* @param $goods_id int 商品id
// 		* @param $goods_name String 商品名
// 		* @param $shop_price float 价格
// 		* @return boolean
// 		*/
// 		abstract public function add($goods_id,$goods_name,$market_price,$shop_price);

// 		/**
// 		* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
// 		* @param $goods_id int 商品id
// 		*/
// 		abstract public function decr($goods_id);

// 		/**
// 		* 从购物车删除某商品
// 		* @param $goods_id 商品id
// 		*/
// 		abstract public function del($goods_id);

// 		/**
// 		* 列出购物车所有的商品
// 		* @return Array
// 		*/
// 		abstract public function items();

// 		/**
// 		* 返回购物车有几种商品
// 		* @return int
// 		*/
// 		abstract public function calcType();

// 		/**
// 		* 返回购物车中商品的个数
// 		* @return int
// 		*/
// 		abstract public function calcCnt();

// 		/**
// 		* 返回购物车中商品的总价格
// 		* @return float
// 		*/
// 		abstract public function calcMoney();

// 		/**
// 		* 清空购物车
// 		* @return void
// 		*/
// 		abstract public function clear();
// }
// class CarTool extends ACartTool{
// 		//2.搞一个静态属性,存放数据
// 		public static $ins = null;
// 		public $item = array();

// 		//4.自动运行,而且不可以继承重写,你new就自动执行__construct(),就报错了,而final不能被继承
// 		final protected function __construct(){
// 			if(session('?cart')){
// 				$this->item = session('cart');
// 			}
// 			//$this->item = session('cart');
// 		}

// 		//1.先改成静态的,外部不允许new了,然后放在静态属性里面
// 		public static function getIns(){
// 			//3.进行判断
// 			if(self::$ins == null){
// 				self::$ins = new self();
// 			}
// 			return self::$ins;
// 		}
// 		/**
// 		* 向购物车中添加1个商品
// 		* @param $goods_id int 商品id
// 		* @param $goods_name String 商品名
// 		* @param $shop_price float 价格
// 		* @return boolean
// 		*/
// 		public function add($goods_id,$goods_name,$market_price,$shop_price){
// 				if(isset($this->item[$goods_id])){
// 					$this->item[$goods_id]['num']+=1;
// 				}else{
// 					$goods= array('goods_name'=>$goods_name,'shop_price'=>$shop_price,'num'=>1);
// 					$this->item[$goods_id] =$goods;
// 				}
				
// 		}

// 		/**
// 		* 减少购物车中1个商品数量,如果减少到0,则从购物车删除该商品
// 		* @param $goods_id int 商品id
// 		*/
// 		public function decr($goods_id){
// 			//先判断购物车中有没有商品,有的话-1
// 			if(isset($this->item[$goods_id])){
// 				$this->item[$goods_id]['num']-=1;
// 			}
// 			//再判断如果到0了,不能再减少了,需要删除
// 			if($this->item[$goods_id]['num']<=0){
// 				$this->del($goods_id);
// 			}
// 		}

// 		/**
// 		* 从购物车删除某商品
// 		* @param $goods_id 商品id
// 		*/
// 		public function del($goods_id){
// 			unset($this->item[$goods_id]);
// 		}

// 		/**
// 		* 列出购物车所有的商品/把已经添加的数组,列出来
// 		* @return Array
// 		*/
// 		public function items(){
// 			return $this->item;
// 		}

// 		/**
// 		* 返回购物车有几种商品/数一下二维数组有几个键
// 		* @return int
// 		*/
// 		public function calcType(){
// 			return count($this->item);
// 		}

// 		/**
// 		* 返回购物车中商品的个数
// 		* @return int
// 		*/
// 		public function calcCnt(){
// 			$cnt = 0;
// 			foreach($this->item as $v){
// 				$cnt+=$v['num'];
// 			}
// 			return $cnt;
// 		}

// 		/**
// 		* 返回购物车中商品的总价格
// 		* @return float
// 		*/
// 		public function calcMoney(){
// 			$money = 0;
// 			//拿出多少种商品,每一种商品有多少件*每件商品的价格
// 			foreach($this->item as $v){
// 				$money+=$v['num']*$v['shop_price'];
// 			}
// 			return $money;
// 		}

// 		/**
// 		* 清空购物车
// 		* @return void
// 		*/
// 		public function clear(){
// 			$this->item = array();
// 		}

// 		public function __destruct(){
// 			//5.存session
// 			session('cart',$this->item);
// 		}
// }
