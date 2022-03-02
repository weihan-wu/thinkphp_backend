<?php
namespace app\common\validate;
use think\Validate;

class RoleValidate extends Validate
{
  protected $batch = true;

  protected $rule = [
      'role_name' => 'require|max:16|unique:Role',
  ];

  protected $message = [
      'role_name.require' => '角色名不为空',
      'role_name.max' => '角色名长度不多于16',
      'role_name.unique' => '角色名已存在'
  ];

}
