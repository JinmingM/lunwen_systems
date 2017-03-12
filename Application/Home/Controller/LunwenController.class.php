<?php
namespace Home\Controller;
use Think\Controller;

class LunwenController extends Controller {
    public function uploadLunwen()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        if(!session("name")){
            $this->error('请登录！',U('User/login'),2);
        }
        $this->display();

    }
    public function uploadLunwen1()
    {
        if(session("name")){
            $lunwentitle=I('post.title','','htmlspecialchars');
            $lunwenmiaoshu=I('post.miaoshu','','htmlspecialchars');
            $lunwengrade=I('post.grade','','htmlspecialchars');
            $lunwenkey=I('post.key','','htmlspecialchars');
            $username = $_SESSION['name'];
            $User = M("User");
            $result = $User->where(array("uname"=>$username))->find();
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('pdf', 'txt', 'doc');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $upload->saveName =      $lunwentitle;
            $upload->autoSub  = true;
            $upload->subName  =  array('date','Ymd','__FILE__');
            // 上传文件
            $info   =   $upload->upload();
            if($lunwentitle!="" && $lunwenmiaoshu!=""){
                if($lunwengrade>=1&&$lunwengrade<=100)
                {
                    $Lunwen = M('lunwen');
                    $ar['title'] = $lunwentitle;
                    $ar['miaoshu'] = $lunwenmiaoshu;
                    $ar['key'] = $lunwenkey;
                    $ar['grade'] = $lunwengrade;
                    $ar['cishu'] = 0;
                    $ar['time'] = Date('Y-m-d H:i:s');
                    $ar['url'] = 'Uploads/'.$info['file']['savepath'].$info['file']['savename'];
                    $ar['uid'] = $result['uid'];
                    // $Lunwen->create();
                    if($info === false) {// 上传错误提示错误信息
                        $this->error($upload->getError());
                    }
                    else{
                        $Lunwen->add($ar);
                        $this->success('上传成功！', U('Lunwen/uploadLunwen'));
                    }
                }else{
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("积分必须大与 0 小于 100 ！");window.history.back();</script>';
                }
            }else{
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("标题或内容不能为空！");window.history.back();</script>';
            }
        } else{
//            echo '<script type="text/javascript">alert("请登录！")</script>';
//            redirect('User/login', 2, '页面跳转中...');
            $this->error('请登录！',U('User/login'),2);
        }

    }
    public function download()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        if(session("name")){
            $Lunwen=M("lunwen");
            $result = $Lunwen->find();
            $list = $Lunwen->select();
            $User=M("user");
//            print M("lunwen")->count();
            for($i =0 ;$i<M("lunwen")->count();$i++)
            {
                $list2[$i] = $User->where(array("uid"=>$list[$i]['uid']))->find();//找到上传者对应的数组
            }
//            print_r($list2);
            for($i =0 ;$i<M("lunwen")->count();$i++)
            {
                $list[$i]['uname']=$list2[$i]['uname']."";//把上传者的名字传到list数组中
            }
            import("@.ORG.Page");
            $this->assign('list1',$list);
            $count  = $Lunwen->count();// 查询满足要求的总记录数
            $pagecount = 10;
            $page = new \Think\Page($count , $pagecount);
//            $page->parameter = $row; //此处的row是数组，为了传递查询条件
            $page->setConfig('first','首页');
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $page->setConfig('last','尾页');
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
            $show = $page->show();
            $list   = $Lunwen->limit($page->firstRow. ',' . $page->listRows)->order('time')->select();
            for($i =0 ;$i<10;$i++)
            {
                $list2[$i] = $User->where(array("uid"=>$list[$i]['uid']))->find();//找到上传者对应的数组
            }
//            print_r($list2);
            for($i =0 ;$i<10;$i++)
            {
                $list[$i]['uname']=$list2[$i]['uname']."";//把上传者的名字传到list数组中
                $list[$i]['iurl']=$list2[$i]['iurl']."";//把上传者的头像传到list数组中
            }
//            print_r($list);
            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->display();
        }else{
//            echo '<script type="text/javascript">alert("请登录！")</script>';
//            redirect('User/login', 2, '页面跳转中...');
            $this->error('请登录！',U('User/login'),2);
        }
    }
    public function download1()
    {

        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $username= session("name");
        $title= I("get.title");
        $this->assign("title", $title);
        $Lunwen=M("lunwen");
        $Down=M("download");
        $list = $Lunwen->where(array("title"=>$title))->find();
        $User=M("user");
        $list1 = $User->where(array("uid"=>$list['uid']))->find();//上传者信息
        $list2 = $User->where(array("uname"=>session("name")))->find();//下载者信息
        $a=$list['grade'];
        $c=$list2['grade']-$a;
        if($c>=0)//判断是否积分够
        {
            if($Down->where(array("lid"=>$list['lid']))->where(array("uid"=>$list2['uid']))->select())//判断是否下载过
            {
                $Lunwen->where(array("title"=>$title))->setInc('cishu',1);// 下载加1
            }else{
                $User->where(array("uid"=>$list['uid']))->setInc('grade',$a); // 上传用户的积分加$a
                $User->where(array("uname"=>session("name")))->setDec('grade',$a); // 下载用户的积分减$a
                $Lunwen->where(array("title"=>$title))->setInc('cishu',1); // 下载加1
                $ar['lid'] = $list['lid'];
                $ar['uid'] = $list2['uid'];
                $Down->add($ar);//导入下载历史
            }
            $this->assign('title',$title);
            $this->assign('list',$list);
            $this->assign('list1',$list1);
            $this->display();
        }else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("积分不足！");window.history.back();</script>';
        }

    }
    public function addgrade()
    {
//        if(1){
//            $username = $_SESSION['name'];
//            $this->assign("username", $username);
//            $username= session("name");
//            $Lunwen=M("lunwen");
////        $list = $Lunwen->where(array("title"=>$title))->find();
//            $User=M("user");
//            $list1 = $User->where(array("uid"=>$list['uid']))->find();//论文的主人
//            $list2 = $User->where(array("uname"=>session("name")))->find();//下载者
//            $a=$list['grade'];
//            $c=$list2['grade']-$a;
////        $Lunwen->where(array("title"=>$title))->setInc('cishu',1); // 文章阅读数加1
//            $User->where(array("uid"=>$list['uid']))->setInc('grade',$a); // 用户的积分加$a
//            $Down=M("download");
//            $list3 = $Down->where(array("lid"=>$list['lid']))->find();
//            if($list3['uid']=$list2['uid']){
//                $User->where(array("uname"=>session("name")))->setDec('grade',$a); // 用户的积分减$a
//            }else{
//            }
//        }else{
//            echo '<script type="text/javascript">alert("积分不足！");window.history.back();</script>';
//        }

    }
    public function findLunwen()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $zi= I('post.zi');
        $this->findLunwen1($zi);
        $this->display();
    }
    public function findLunwen1($zi)
    {
        if($zi)
        {
            $Lunwen=M("lunwen");
            $condition["title"] = array("like", "%".$zi);
            $condition["key"] = array("like", "%".$zi);
            $list = $Lunwen->where($condition)->select();
            $count = $Lunwen->where($condition)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('prev', "上一页");//上一页
            $Page->setConfig('next', '下一页');//下一页
            $Page->setConfig('first', '首页');//第一页
            $Page->setConfig('last', "末页");//最后一页
            $Page -> setConfig ( 'theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%' );
            $show = $Page->show();// 分页显示输出
            $this->assign('page',$show);// 赋值分页输出
            $this->assign('list',$list);
        }else{
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("关键字为空！");window.history.back();</script>';
        }
    }
    public function parper()
    {
        $username = $_SESSION['name'];
        $this->assign("username", $username);
        $title= I("get.title");
        $this->assign("title", $title);
        $Lunwen=M("lunwen");
        $list = $Lunwen->where(array("title"=>$title))->find();
        $User=M("user");
        $list1 = $User->where(array("uid"=>$list['uid']))->find();
        $this->assign('list',$list);
        $this->assign('list1',$list1);
        //print_r($list1);
        $Pinglun=M("pinglun");
        import("@.ORG.Page");
        $count = $Pinglun->where(array("lid"=>$list['lid']))->count();// 查询满足要求的总记录数
        $pagecount = 5;
        $page = new \Think\Page($count , $pagecount);
//            $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
        $show = $page->show();
        $list2 = $Pinglun->where(array("lid"=>$list['lid']))->limit($page->firstRow. ',' . $page->listRows)->select();
        for($i =0 ;$i<M("pinglun")->where(array("lid"=>$list['lid']))->count();$i++)
        {
            $list3 = $User->where(array("uname"=>$list2[$i]['uname']))->find();
            //print_r($list3);
            $list2[$i]['iurl']=$list3['iurl']."";//把上传者的名字传到list数组中
        }
        $this->assign('list2',$list2);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }
    public function pinglun()
    {
        if(session("name")){
            $ping=I('post.ping','','htmlspecialchars');
            $title= I("get.title");
            $username = $_SESSION['name'];
            $User = M("User");
            $result = $User->where(array("uname"=>$username))->find();
            if($ping!=""){
                $Pinglun = M('pinglun');
                $ar['neirong'] = $ping;
                $list = $User->where(array("uname"=>$username))->find();
                $ar['uid'] = $list['uid'];
                $Lunwen = M('lunwen');
                $list1 = $Lunwen->where(array("title"=>$title))->find();
                $ar['lid'] = $list1['lid'];
                $ar['uname'] = $username;
                $ar['time'] = Date('Y-m-d H:i:s');
                $condition['uname'] = $username;
                $condition['lid'] = $list1['lid'];
                if($Pinglun->where($condition)->select() )
                {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("你已经评论过！");window.history.back();</script>';
                }else{
                    $Pinglun->add($ar);
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("评论成功！");window.history.back();</script>';
                }

            }else{
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo '<script type="text/javascript">alert("评论不能为空！");window.history.back();</script>';
            }
        }else{
            $this->error('请登录！',U('User/login'),2);
        }
    }
}