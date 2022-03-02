<?php
namespace app\common\validate;
use think\Validate;

class ruleValidate extends Validate
{
  protected $batch = true;

  protected $rule = [
      'rule_name' => 'require|max:16|unique:Rule',
  ];

  protected $message = [
      'rule_name.require' => '规则名不得为空',
      'rule_name.max' => '规则名最大不超过16字符',
      'rule_name.unique' => '规则已存在'
  ];

}
