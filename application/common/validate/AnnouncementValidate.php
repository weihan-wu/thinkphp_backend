<?php


namespace app\common\validate;


use think\Validate;

class AnnouncementValidate extends Validate
{
  protected $batch = true;

  protected $rule = [
      'an_title' => 'require',
      'an_content' => 'require'
  ];

  protected $message = [
      'an_title.require' => '标题不能为空',
      'an_content.require' => '内容不能为空'
  ];
}
