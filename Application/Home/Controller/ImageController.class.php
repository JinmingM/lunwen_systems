<?php
namespace Home\Controller;
use Think\Controller;
/**
 * Created by PhpStorm.
 * User: mjm
 * Date: 2016/7/8
 * Time: 17:12
 */

class ImageController extends Controller
{
    public function index(){
        $this->display();
    }

    //上传头像
    public function uploadImg(){
        import('ORG.UploadFile');
        $upload = new UploadFile();						// 实例化上传类
        $upload->maxSize = 1*1024*1024;					//设置上传图片的大小
        $upload->allowExts = array('jpg','png','gif');	//设置上传图片的后缀
        $upload->uploadReplace = true;					//同名则替换
        $upload->saveRule = 'uniqid';					//设置上传头像命名规则(临时图片),修改了UploadFile上传类
        //完整的头像路径
        $path = './avatar/';
        $upload->savePath = $path;
        if(!$upload->upload()) {						// 上传错误提示错误信息
            $this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
        }else{											// 上传成功 获取上传文件信息
            $info =  $upload->getUploadFileInfo();
            $temp_size = getimagesize($path.$info['0']['savename']);
            if($temp_size[0] < 100 || $temp_size[1] < 100){//判断宽和高是否符合头像要求
                $this->ajaxReturn(0,'图片宽或高不得小于100px！',0,'json');
            }
            $data['picName'] = $info['0']['savename'];
            $data['status'] = 1;
            $data['url'] = __ROOT__.'/avatar/'.$data['picName'];
            $data['info'] = $info;
            $this->ajaxReturn($data,'json');
        }
    }
    //裁剪并保存用户头像
    public function cropImg(){
        //图片裁剪数据
        $params = $this->_post();						//裁剪参数
        if(!isset($params) && empty($params)){
            return;
        }

        //头像目录地址
        $path = './avatar/';
        //要保存的图片
        $real_path = $path.$params['picName'];
        //临时图片地址
        $pic_path = $path.$params['picName'];
        import('ORG.ThinkImage.ThinkImage');
        $Think_img = new ThinkImage(THINKIMAGE_GD);
        //裁剪原图
        $Think_img->open($pic_path)->crop($params['w'],$params['h'],$params['x'],$params['y'])->save($real_path);
        //生成缩略图
        $Think_img->open($real_path)->thumb(100,100, 1)->save($path.$$params['picName'].'_100.jpg');
        $Think_img->open($real_path)->thumb(60,60, 1)->save($path.$$params['picName'].'_60.jpg');
        $Think_img->open($real_path)->thumb(30,30, 1)->save($path.$$params['picName'].'_30.jpg');
        $this->success('上传头像成功');
    }

}