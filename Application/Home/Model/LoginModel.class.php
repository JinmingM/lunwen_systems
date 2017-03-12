<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/8
 * Time: 0:10
 */
namespace Home\Model;
use Think\Model;
class LoginModel extends Model
{
    // 重新定义表
    protected $tableName = 'user';

    protected $_validate = array(
        array('uname', 'require', '用户名不能为空！'), //默认情况下用正则进行验证
        array('upsw', 'require', '登录密码不能为空！'), // 默认情况下用正则进行验证
        array('verify', 'verify_check', '验证码错误', 0, 'function'), // 判断验证码是否正确
    );

    protected $_auto = array(
        /* 登录的时候自动完成 */
        array('upsw', 'md5', 3, 'function'), // 对password字段使用md5函数处理
    );
}