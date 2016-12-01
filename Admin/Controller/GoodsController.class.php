<?php 
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller{

	//商品增
	public function goodsAdd(){
		
			


		if (!IS_POST) {
			$cats = D('Admin/Cat');
			$this->assign('cat',$cats->getTree());
			// dump($cats->getTree());
			// exit;
			$this->display();
		}else{
			// dump($_POST);
			$goods = D('Goods');

			if (!$goods->create()) {
				echo $goods->getError();				
			}else{
				$upload = new \Think\Upload();
				// $upload->macSize = 3145728;
				$upload->exts = array('jpg','gif','png','jepg');
				$upload->rootPath = 'Public/Upload/';
				$info = $upload->upload();
				// dump($info);
				// exit;
				if (!$info) {
					dump($upload->getError());
				}else{

				$_POST['goods_img'] = $upload->rootPath.$info['goods_img']['savepath'].$info['goods_img']['savename'];
				// dump($_POST['goods_img']);
				// exit;
				$img = new \Think\Image();
				$img->open($_POST['goods_img']);
				$thumb_path = 'Public/Upload/thumb/'.$info['goods_img']['savename'];
				$img->thumb(200,200,2)->save($thumb_path);
				$_POST['thumb_img'] = $thumb_path;
				}
				// dump($_POST);
				// exit;
				$goods->add();
				$this->success('ok','',3);
			}
		}
		
	}

	//商品列表
	public function goodsList(){
		 if (!IS_POST) {
		
			$goods = D('goods');//实列化

			$num = $goods->count();//数行数,

			$page = new \Think\Page($num,15);//实列化tp框架内的分类页;在总数为$num条内容的情况下以每页显示15条的方式输出;

			$show = $page->show();//用上一步实列化出来的对象来吊用内部的show这个方法赋值为show;

			$goodslist = $goods->order('goods_id')->limit($page->firstRow.','.$page->listRows)->select();


			// var_dump($goodslist);
			// exit();
			$this->assign('goodslist',$goodslist);

			$this->assign('pages',$show);

			$this->display();

		}else{
			  // dump($_POST);
			  // exit;
			$goods = D('goods');//实列化

			$num = $goods->count();//数行数,

			$page = new \Think\Page($num,15);//实列化tp框架内的分类页;在总数为$num条内容的情况下以每页显示15条的方式输出;

			$show = $page->show();//用上一步实列化出来的对象来吊用内部的show这个方法赋值为show;

			$goodslist = $goods->where(I())->order('goods_id')->limit($page->firstRow.','.$page->listRows)->select();


			// var_dump($goodslist);
			// exit();
			$this->assign('goodslist',$goodslist);

			$this->assign('pages',$show);

			$this->display();
		}
		
	}


	//商品修改
	public function goodsedit(){
			$goods_id = I('get.goods_id');
			$goodsmodel = D('goods');
		if(!IS_POST){
			// $catmodel = new Admin\Model\CatModel();
			// $catlist = $catmodel->select();
			// $this->assing('cat',$catlist);
			$goodsinfo = $goodsmodel->find($goods_id);
			/*dump($goodsinfo);
			exit;*/
			$this->assign('goods',$goodsinfo);
			$this->display();

		}else{
			$id=I('get.goods_id');
			$goodsmodel->where($id)->save();
			$this->success('ok','goodslist',3);

		}
	}


	//商品删除
	public function goodsdel(){
		$goods = D('goods');
		$goods_id = I('get.goods_id');
		if ($goods->delete($goods_id)) {
			$this->success('删除成功','',3);
		}
	}





 }
