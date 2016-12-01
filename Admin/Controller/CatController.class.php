<?php
namespace Admin\Controller;
use Think\Controller;
class CatController extends Controller {
    public function catadd(){
            $catModel = D('Cat');//通过大D函数创建一个链接数到据库的对象;
        if (!IS_POST) {
            $a = null;
            $list = $this->assign('catlist',$catModel->getTree());
            $this->assign('a',$a);
            // var_dump($catModel->getTree());
            // exit;
            //因为提交页面有以个下拉框,所以及时没有提交也要先把下拉框的内容显示出来;
            $this->display();
        }else{
             
            // dump($info);
            // exit;
            if(!$catModel->create()){
                echo $catModel->getError();
                exit;
            }
        //没有做判断,如果提交内容重复怎么办?如果空提交???
            // if (empty(I('cat_name'))) {
            //  echo '请填写完整信息';
            // }****可以通过create()来验证,会自动吊用数据库做对比,还可以避免重复用unique验证
        if($catModel->add($_POST)){
            $this->success('添加栏目成功','',3);
        }else{
            $this->error('添加栏目失败','',3);
        }
        // $this->redirect('admin/cat/catadd');
        }
    } 



    public function catlist(){
    	$catModel=D('Cat');
    	$catlist=$catModel->getTree();
    	$this->assign('catlist',$catlist);
        $this->display();
    }



    public function catedit(){
    	$catModel=D('Cat');
    	if (!IS_POST) {
    	$this->assign('gettree',$catModel->getTree());
		$this->assign('cat',$catModel->find(I('catid')));
    	$this->display();
    	}else{
    		$cat_id = I('cat_id');
    	
            if ($catModel->where('cat_id='.$cat_id)->save($_POST)) {
                $this->success('修改成功','catlist');
            }
    	} 
    }
    public function catdel(){
    	$catModel=D('Cat');
    	$catModel->delete(I('catid'));
    	$this->redirect('admin/cat/catlist');
    }

    public function yzm(){
        $verify = new \Think\Verify();
        $verify->imagew = 140;
        $verify->imageh = 40;
        $verify->fontSize = 20;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->entry();

    }
    public function checkyzm(){
        $verify = new Think\verify();
        if($verify->check(I('post.yzm'))){

        }
    }
}