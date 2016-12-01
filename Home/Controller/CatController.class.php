<?php 
namespace Home\Controller;
use Think\Controller;

class CatController extends Controller{
	public function cat(){
		//栏目商品
		$goods= D('Admin/goods');
		$id = I('get.cat_id');
		//分页制作
		$count = $goods->where('cat_id='.$id)->count();
		// dump($num);
		$Page = new\Think\Page($count,6);
		$show = $Page->show();
		$goodslist = $goods->where('cat_id='.$id)->limit($Page->firstRow.','.$Page->listRows)->select();

		
		// dump($show);
		$this->assign('count',$count);
		$this->assign('page',$show);
		
		
		$this->assign('goodslist',$goodslist);
		//栏目导航
		$cats = D('Admin/Cat');
    	$this->assign('cats',$cats->getTree());
    	
    	
    	//销售排行
    	$top = D('goods')->where('is_on_sale')->order('click_count desc')->limit(7)->select();
    	$this->assign('top',$top);


    	//浏览历史记录
    	$this->assign('history',array_reverse(session('history')));
    	// dump(array_reverse(session('history')));
    	// exit;

        $this->display();
    	
	}

	public function catall(){
		$cat=D('Admin/cat');
		$id=I('get.cat_id');
		$cats = $cat->field('cat_id')->where('parent_id='.$id)->select();
		$str = array();
		foreach ($cats as $k => $v) {
			$str[] = $v['cat_id'];	
		}
		$id = implode(',', $str);
		// dump($id);exit;
		$goods = D('Admin/goods');
		$num = $goods->where('cat_id in ('.$id.')')->count();
    	// $page = new \Think\Page($num,8);
    	$Page = new \Think\Page($num,8);
		$goodslist = $goods->where('cat_id in ('.$id.')')->limit($Page->firstRow.','.$Page->listRows)->select();

		//分页显示
    	
    	$show = $Page->show();
    	$this->assign('page',$show);
    	$this->assign('num',$num);
		// dump($goodslist);
		
		// $goodslist = $goods->query("select * from goods where cat_id in (".$id.")");
		// dump($goodslist);

		$this->assign('goodslist',$goodslist);

		//栏目导航
		$cats = D('Admin/Cat');
    	$this->assign('cats',$cats->getTree());
    	
    	
    	//销售排行
    	$top = D('goods')->where('is_on_sale')->order('click_count desc')->limit(7)->select();
    	$this->assign('top',$top);

    	//session设置浏览历史
    	// dump(session());
    	$this->assign('history',array_reverse(session('history')));

    	

		$this->display();
	
	}
	
}





 ?>