<?php
namespace app\common\validate;
use think\Validate;

class AdminValidate extends Validate
{
  protected $batch = true;

  protected $rule = [
      'admin_username' => 'require|min:4|max:16|unique:Admin',
      'admin_password' => 'min:6|max:20',
      'admin_truename' => 'require',
      'admin_telphone' => 'require|number|min:11',
      'admin_email' => 'require|email'
  ];

  protected $message = [
      'admin_username.require' => '用户名不为空',
      'admin_username.min' => '用户名长度不少于4',
      'admin_username.max' => '用户名长度不多于16',
      'admin_username.unique' => '用户名已存在',
      'admin_password.min' => '密码长度不少于6',
      'admin_password.max' => '密码长度不多于20',
      'admin_telphone.require' => '电话号码不为空',
      'admin_telphone.number' => '电话号码为数字',
      'admin_telphone.min' => '电话号码不少于11位',
      'admin_email.require' => '邮箱不为空',
      'admin_email.email' => '请填写正确的邮箱',
      'admin_truename.require' => '真实姓名不为空'
  ];

  protected $scene = [
      'update' => ['admin_truename','admin_telphone','admin_email']
  ];

}
