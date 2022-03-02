<?php
namespace app\announcement\controller;

use app\common\service\Announcement as AnService;
use app\common\validate\announcementValidate as anValidate;
use think\Controller;

class Announcement extends Controller
{
  private function AnnouncementService(){
    return new AnService();
  }

  function index() {
    $data = $this->AnnouncementService()->getAllAnnouncement();
    $this->result($data,1);
  }

  function getOne() {
    $an_id = input('an_id');
    $res = $this->AnnouncementService()->getOneAnnouncement($an_id);
    $this->result($res,1);
  }

  function save(){
    $validate = new anValidate();
    if (!$validate->check(input())) {
      $this->error($validate->getError());
    }
    if (!input('an_id')) {
      $this->AnnouncementService()->create(input());
      $this->success('添加成功');
    } else {
      $this->AnnouncementService()->update(input());
      $this->success('修改成功');
    }
  }

  function delete() {
    $res = $this->AnnouncementService()->delete(input('an_id'));
    if (!$res) {
      $this->error('删除失败');
    }
    $this->success('删除成功');
  }
}
