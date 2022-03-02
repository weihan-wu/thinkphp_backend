<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Role extends Model
{
  protected $pk = "role_id";
  use SoftDelete;
  protected $createTime = "role_create_time";
  protected $updateTime = "role_update_time";
  protected $deleteTime = "role_delete_time";
}
