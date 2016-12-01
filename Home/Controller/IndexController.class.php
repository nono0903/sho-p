<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

		//所有分类
    	$cats = D('Admin/Cat');
    	$this->assign('cats',$cats->getTree());
    	//热销商品
    	$hot = D('goods')->where('is_hot')->order('goods_id desc')->limit(4)->select();
    	$this->assign('hots',$hot);

    	//精品推荐
    	$best = D('goods')->where('is_best')->order('click_count desc')->limit(4)->select();
    	$this->assign('best',$best);
    	
    	//销售排行
    	$top = D('goods')->where('is_on_sale')->order('click_count desc')->limit(7)->select();
    	$this->assign('top',$top);

        $this->display();
    }
    // public function hot(){
    // 	$hot = D('goods')->where('is_hot')->order('goods_id desc')->limit(4)->select();
    // 	// dump($hot);
    	
    // }
}