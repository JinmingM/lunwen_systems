<?php
namespace Home\Controller;
use Think\Controller;
/**
 * Class UsersController
 * @package Home\Controller
 */
class UserController extends Controller {


    public function login()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $this->display();
    }
    public function login1(){
        $username=I('post.uname','','htmlspecialchars');
        $userpsw=I('post.upsw','','htmlspecialchars');
        $verify=I('post.verify','','htmlspecialchars');
        if($username!="" && $userpsw!="")
        {
            $User = M("user"); // 实例化user对象
            if($this->checkUser($username,$userpsw))
            {
                if($this->check_verify($verify,$id = '' ))
                {
                    session("name",$username);
                    if(!$this->checkdengji($username))
                    {
                       // echo R('Admin/Index/index');
                        $this->display();
                    }else{
                        $this->success('登录成功,正跳转至系统首页...', U('Index/index2'));
                    }
                }
                else{
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("验证码不正确，请重新输入");window.history.back();</script>';
                }
            }
            else
            {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("用户名或者密码不正确，请重新输入");window.history.back();</script>';
            }
        }
        else
        {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("用户名或者密码为空");window.history.back();</script>';
        }
    }

    public function logout()
    {
        session("name",null);
        $this->display("Index/index");
    }

    public function regisier()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $this->display();

    }

    public function regisiter1()
    {
        $username=I('post.uname','','htmlspecialchars');
        $userpsw=I('post.upsw','','htmlspecialchars');
        if($username!="" && $userpsw!=""){
            if(M("user")->where(array("uname"=>$username))->select())
            {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("用户已经存在，请重新选择用户名。");window.history.back();</script>';
            }
            else
            {
                $user['upsw'] = array('upsw','md5',3,'function');
                $User = M('user');
                $ar['grade'] = 10;
                $ar['dengji'] = 1;
                $ar['upsw'] = $userpsw;
                $ar['uname'] = $username;
                $ar['time'] = Date('Y-m-d H:i:s');

                if($User->auto($user)->create($ar))
                {
                    if($User->add())
                    {
                        $this->success('注册成功,正跳转至系统首页...', U('Index/index2'));
                    };
                }
                else
                {
                    $this->show("用户名或密码格式错误");
                };
            }
        }
        else
        {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("用户名或者密码不能为空");window.history.back();</script>';
        }
    }
    public function grade()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $User=M("user");
        $list = $User->where(array("uname"=>$username))->find();
        print_r($list);
        $this->assign("list", $list);
        $this->display();
    }
    public function changeupsw()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $this->display();
    }
    public function changeupsw1(){
        //首先要检查用户是否登录
        if (!$this->checkLogin()){
            $this->error("用户没有登录",__APP__);
        }
        else{
            $username1 = $_SESSION['name'];
            $username=I('post.uname','','htmlspecialchars');
            $userpsw=I('post.upsw','','htmlspecialchars');
            $usernpsw=I('post.nupsw','','htmlspecialchars');
            $verify=I('post.verify','','htmlspecialchars');
            if(!($username != $username1))
            {
                if($username!="" && $userpsw!=""&&$usernpsw!="")
                {
                    $User = M("user"); // 实例化user对象
                    $username = $_SESSION['name'];
                    $upsw = md5($usernpsw);
                    if($this->checkUser($username,$userpsw))
                    {
                        if($this->check_verify($verify,$id = '' ))
                        {
//                        $data = array('upsw'=>$upsw);
                            $User-> where(array('uname' => $username))->setField('upsw',$upsw);
                            $this->success('密码修改成功', U('Index/index2'));
                        }
                        else{
                            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                            echo '<script type="text/javascript">alert("验证码不正确，请重新输入！");window.history.back();</script>';
                        }
                    }
                    else
                    {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo '<script type="text/javascript">alert("修改密码失败！");window.history.back();</script>';
                    }
                }
                else
                {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("用户名或者密码为空!");window.history.back();</script>';
                }
            }else{
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("用户名与登录不匹配！");window.history.back();</script>';
            }

        }

    }
    private function checkUser($uname,$upsw)
    {
        $array["uname"]=$uname;
        $array["upsw"]=md5($upsw);
        $data=M("user")->where($array);
        if($data->select())
        {
            return true;
        }
        else
        {
            return false;
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
        //检查权限，若果权限为0，表示现在登录操作的是管理员
        $data=M("user");
        if(!$this->checkdengji(session("name"))){
            //管理员操作
            $list=$data->where(array("uid"=>I("get.id")))->find();
            if($this->checkdengji($list['uname']))
            {
                $re=$data->where(array("uid"=>I("get.id")))->delete();
                $this->redirect("userlist?p=0");
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
    public function rchangeuspw()
    {
        $uid= I("get.id");
        $this->assign("uid", $uid);
        $this->display();
    }

    public function rchangeuspw1(){
        //检查权限，若果权限为0，表示现在登录操作的是管理员
        if(!$this->checkdengji(session("name"))){
            //管理员操作
            $User = M("user"); // 实例化user对象
            $list=$User->where(array("uid"=>I("get.id")))->find();
            if($this->checkdengji($list['uname']))
            {
                $usernpsw=I('post.nupsw','','htmlspecialchars');
                if($usernpsw!="")
                {
                    $upsw = md5($usernpsw);
                    // echo I('get.id');
                    $User-> where(array('uid' => I("get.id")))->setField('upsw',$upsw);
                    $this->success('密码修改成功', U('User/userlist'));
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
        else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("权限不够");window.history.back();</script>';
        }
    }
    public function touxiang()
    {
        $username = $_SESSION['name'];
        echo $username;
        $this->assign("username", $username);
        $this->display();

    }
    public function touxiang1()
    {
        if (session("name")) {
            $touxiangkey = I('post.key', '', 'htmlspecialchars');
            $username = $_SESSION['name'];
            $User = M("User");
            echo $username;
            $result = $User->where(array("uname" => $username))->find();
            print_r($result);
            $no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
            $upload->savePath = ''; // 设置附件上传（子）目录
            $upload->saveName = $no;
            $upload->autoSub = true;
            $upload->subName = array('date', 'Ymd', '__FILE__');
//            print_r($upload);
            // 上传文件
            $info = $upload->upload();
            if ($info) {
                print_r($info);
                $Image = M('Image');
                $ar['time'] = Date('Y-m-d H:i:s');
                $ar['url'] = 'Uploads/' . $info['image']['savepath'] . $info['image']['savename'];
                $ar['uid'] = $result['uid'];
                $User->iurl = $ar['url'];
                $User->where(array("uname" => $username))->save();
                // $Lunwen->create();
                if ($info === false) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    $Image->add($ar);
                    $this->success('上传成功！', U('User/touxiang'));
                }
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("请选择图片文件！");window.history.back();</script>';
            }

        }
    }



    private function checkdengji($username)
    {
        $data=M("user")->field("dengji")->where(array("uname"=>$username))->select();
        return $data[0]["dengji"];
    }
    public function verify()
    {
        // 实例化Verify对象
        $verify = new \Think\Verify();
        // 配置验证码参数
        $verify->fontSize = 14;     // 验证码字体大小
        $verify->length = 4;        // 验证码位数
        $verify->imageH = 34;       // 验证码高度
        $verify->useImgBg = true;   // 开启验证码背景
        $verify->useNoise = false;  // 关闭验证码干扰杂点
        $verify->entry();
    }
    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
}
