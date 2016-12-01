<?php 		
namespace Admin\Model;
Use Think\Model;

class GoodsModel extends Model{
	protected $_validate=array(
		array('goods_name','3,12','需要3到8位的商品名称',1,'length'),
		array('shop_price',array(1,99999),'售价不正确',1,'between',3),
		// array()
		);
	protected $_auto = array(
		array('add_time','time','','function'),
		array('last_up','time','2','function')

		);
}





 ?>