<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Adminrole extends Model
{
  protected $pk = "adminrole_id";
  use SoftDelete;
  protected $createTime = "adminrole_create_time";
  protected $updateTime = "adminrole_update_time";
  protected $deleteTime = "adminrole_delete_time";
}
