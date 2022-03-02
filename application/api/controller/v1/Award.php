<?php

namespace app\api\controller\v1;

use app\common\controller\Base;
use app\common\service\Award as AwardService;

class Award extends Base
{
  private function AwardService()
  {
    return new AwardService();
  }

  public function index()
  {
    $data = $this->AwardService()->getAllAward();
    $this->result($data, 1);
  }

  public function getOne() {
    $id = input('award_id');
    $data = $this->AwardService()->getOneAward($id);
    $this->result($data,1);
  }

  public function save()
  {
    if(!input('award_id')) {
      //添加
      $res = $this->AwardService()->create(input());
      if (!$res) $this->error('添加失败');
    } else {
      //修改
      $res = $this->AwardService()->update(input());
      if (!$res) $this->error('修改失败');
    }
    $this->success('保存成功');
  }

  // 软删除
  public function delete()
  {
    $res = $this->AwardService()->delete(input('award_id'));
    if (!$res) {
      $this->error('下架失败');
    }
    $this->success('下架成功');
  }

  // 软删除恢复
  public function restore() {
    $res = $this->AwardService()->restore(input('award_id'));
    if (!$res) {
      $this->error('上架失败');
    }
    $this->success('上架成功');
  }

  // 真删除
  public function destory() {
    $res = $this->AwardService()->destory(input('award_id'));
    if (!$res) {
      $this->error('删除失败');
    }
    $this->success('删除成功');
  }
}
