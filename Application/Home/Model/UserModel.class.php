<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8
 * Time: 0:11
 */
namespace Home\Model;
use Think\Model;
class UsersModel extends Model {

    protected $_validate = array(
        array('uname', 'require', '用户名不能为空！'), //默认情况下用正则进行验证
        array('uname', '', '该用户名已被注册！', 0, 'unique', 1), // 在新增的时候验证name字段是否唯一
        array('upsw', '/^([a-zA-Z0-9@*#]{6,22})$/', '密码格式不正确,请重新输入！', 0),
        array('verify', 'verify_check', '验证码错误', 0, 'function'), // 判断验证码是否正确
    );
    /**
     * 自动完成
     */
    protected $_auto = array (
        array('upsw', 'md5', 3, 'function') , // 对password字段在新增和编辑的时候使md5函数处理
    );

}