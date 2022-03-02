<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Rule extends Model
{
  protected $pk = "rule_id";
  use SoftDelete;
  protected $createTime = "rule_create_time";
  protected $updateTime = "rule_update_time";
  protected $deleteTime = "rule_delete_time";
}
