<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;

class Award extends Model
{
  use SoftDelete;
  protected $pk = "award_id";
  protected $createTime = "award_create_time";
  protected $updateTime = "award_update_time";
  protected $deleteTime = "award_delete_time";
}
