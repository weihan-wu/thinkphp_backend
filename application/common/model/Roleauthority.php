<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Roleauthority extends Model
{
  use SoftDelete;
  protected $pk = "roleAuthority_id";
  protected $createTime = "roleAuthority_create_time";
  protected $updateTime = "roleAuthority_update_time";
  protected $deleteTime = "roleAuthority_delete_time";
}
