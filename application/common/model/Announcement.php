<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Announcement extends Model
{
  use SoftDelete;
  protected $pk = "an_id";
  protected $createTime = "an_create_time";
  protected $updateTime = "an_update_time";
  protected $deleteTime = "an_delete_time";
}
