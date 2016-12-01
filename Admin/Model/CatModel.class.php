<?php 
    namespace Admin\Model;
    use Think\Model;
        class CatModel extends Model{

            public $_validate=array(
            array('cat_name','2,10','需要2到10位的商品名称',1,'length',3),
            array('cat_name','','栏目名重复',1,'unique')

            // protected $_validate=array(
            //     array('cat_name','2,12','栏目名需要2到12位',1,'length',3),
            //     // array()
            );

            protected $cats = array();//设定一个空数组,用来存放select出来的对象
            public function __construct() {//构造函数
                parent::__construct();//继承父类的构造函数,否则会把父类覆盖掉
                $this->cats = $this->select();//自动执行select(),并把查询出来的对象赋给之前创建的cat,也可以不用在之前创建cat,直接把查询出来的对象赋给cat;
            }


                /*从0开始,到6,或者到10结束*/
            public function getTree($parent_id=0 , $lev=0) {// 0 创建方法,并设置parent_id初始值为0,也就是最顶层    // 7 为展示子类与父类层级关系,设置一个参数为$lev = 0,

                $tree = array();// 3-0在执行3-1 之前创建一个空数组

            foreach($this->cats as $v) {// 1 遍历循环打印数组,把select出的2维数组转化为一位数组

                if($v['parent_id'] == $parent_id) {// 2 当数组内的parent_id等于传进来的默认值0的时候执行以下代码

                $v['lev'] = $lev;   //8 在每次循环的时候把这个层级数插进去,ps:第一次为0

                $tree[] = $v;// 3-1 把符合if条件下的一位数组存在$tree这个空数组里

                                    //4 这里有一步合并在下面的代码,实际为$this->gettree($v['cat_id']),以递归检测当cat_id为父id的时候还有没有子类,有继续循环1234步骤,没有继续执行后面代码  

                $tree = array_merge($tree , $this->getTree($v['cat_id'] , $lev+1));// ***5***也是重要的一步,合并parent_id为0以及parent_id为cat_id时查询出来的数组,之后继续向下执行代码 但后面没有代码,返回,并结束前面等待结束的代码      // 9  在 执行第4步的时候,如果有子类,冰吊用gettree这个方法的时候,将$lev这个参数加1,

                }

            }

                return $tree;// 6 && 10 第4没有子栏目的时候当前步骤为 6 否则当前步骤为 10  返回结果到这个方法也叫函数;

                }


        }