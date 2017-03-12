<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $this->show();
    }
    public function User(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $User=M("user");
        $dengji=I('post.search-sort','','htmlspecialchars');
        if($dengji==1||$dengji==0){
            $count = $User->where(array("dengji"=>$dengji))->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,1);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $list   = $User->where(array("dengji"=>$dengji))->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $show = $Page->show();// 分页显示输出
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }else{
            $count = $User->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $list   =  $User->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $show = $Page->show();// 分页显示输出
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }
    }
    public function Lunwen(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $Lunwen=M("lunwen");
        $key=I('post.key','','htmlspecialchars');
        if($key==""){
            $count = $Lunwen->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $list   = $Lunwen->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $show = $Page->show();// 分页显示输出
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }else{
            $count = $Lunwen->where(array("key"=>$key))->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $list   = $Lunwen->where(array("key"=>$key))->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $show = $Page->show();// 分页显示输出
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }
    }
    public function Pinglun(){
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $Ping=M("pinglun");
        $key=I('post.key','','htmlspecialchars');
        if($key==""){
            $count = $Ping->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $show = $Page->show();// 分页显示输出
            $list   = $Ping->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }else{
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $show = $Page->show();// 分页显示输出
            $list   = $Ping->where(array("uname"=>$key))->limit($Page->firstRow. ',' . $Page->listRows)->order('time')->select();
            $this->assign('list',$list);
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }
    }
    public function checkLogin()
    {
        if(session("name"))
        {
            return true;
        }
        else
        {
            return false;
        };
    }
    public function userlist(){
        //检查权限，若果权限为1，表示现在登录操作的是管理员
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        if(!$this->checkdengji(session("name"))){
            $User=M("user");
            $list = $User->select();
            $this->assign('list',$list);
            $count = $User->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $show = $Page->show();// 分页显示输出
            $this->assign('page',$show);// 赋值分页输出
            $this->display();
        }else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("权限不够");window.history.back();</script>';
        }
    }
    public function deluser(){
        $data=M("user");
        if(!$this->checkdengji(session("name"))){
            //管理员操作
            $list=$data->where(array("uid"=>I("get.id")))->find();
            if($this->checkdengji($list['uname']))
            {
                $re=$data->where(array("uid"=>I("get.id")))->delete();
                $this->redirect("User");
            }else{
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("管理员不能删管理员");window.history.back();</script>';
            }

        }
        else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("权限不够");window.history.back();</script>';
        }
    }
    public function changeuspw()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $uid= I("get.id");
        $this->assign("uid", $uid);
//        echo I('get.id');
        $this->display();
    }

    public function changeuspw1(){
        $User = M("user"); // 实例化user对象
        echo I('get.id');
        $list=$User->where(array("uid"=>I("get.id")))->find();
        print_r($list);
        if($this->checkdengji($list['uname']))
        {
            $userpsw=I('post.nupsw','','htmlspecialchars');
            if($userpsw!="")
            {
                $upsw = md5($userpsw);
//                echo I('get.id');
                $User-> where(array('uid' => I("get.id")))->setField('upsw',$upsw);
                $this->success('密码修改成功', U('/Index/index'));
            }
            else
            {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("密码为空");window.history.back();</script>';
            }
        }
        else
        {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("管理员不能修改管理员");window.history.back();</script>';
        }
    }
    private function checkdengji($username)
    {
        $data=M("user")->field("dengji")->where(array("uname"=>$username))->select();
        return $data[0]["dengji"];
    }
    public function dellunwen(){
        echo I("get.lid");
        $Lunwen=M("lunwen");
        $list=$Lunwen->where(array("lid"=>I("get.lid")))->find();
        $Lunwen->where(array("lid"=>I("get.lid")))->delete();
        $this->redirect("Lunwen");
    }
    public function delpinglun(){
        echo I("get.pid");
        $Ping=M("pinglun");
        $list=$Ping->where(array("pid"=>I("get.pid")))->find();
        $Ping->where(array("pid"=>I("get.pid")))->delete();
        $this->redirect("Pinglun");
    }
}