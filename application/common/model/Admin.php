<?php

namespace app\common\model;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
  protected $pk = "admin_id";
  use SoftDelete;
  protected $createTime = "admin_create_time";
  protected $updateTime = "admin_update_time";
  protected $deleteTime = "admin_delete_time";
}
