<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $User = M('user');
        $list = $User->order('grade desc')->limit(3)->select();
        $this->assign('list',$list);
        $this->display();
    }

    public function index2(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $User = M('user');
        $list = $User->order('grade desc')->limit(3)->select();
        $this->assign('list',$list);
        $Lunwen = M('lunwen');
        $list1 = $Lunwen->order('cishu desc')->limit(3)->select();
        for($i =0 ;$i<3;$i++)
        {
            $list2[$i] = $User->where(array("uid"=>$list1[$i]['uid']))->find();
        }
        for($i =0 ;$i<3;$i++)
        {
            $list1[$i]['uname']=$list2[$i]['uname']."";
        }
//        foreach($list1 as $v){
//            echo $v['uname']."";
//        }
//        echo "<hr>";
        $this->assign('list1',$list1);
        $this->assign('list2',$list2);
        $this->display();
    }

}