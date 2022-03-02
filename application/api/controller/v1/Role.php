<?php

namespace app\api\controller\v1;

use app\common\controller\Base;
use app\common\service\Role as RoleService;
use app\common\validate\roleValidate;
class Role extends Base
{
  function index() {
    $info = (new RoleService())->getAllRole();
    if (!$info) {
      $this->error('请求数据失败');
    }
    $this->result($info,1);
  }

  function getList() {
    $list = (new RoleService())->lists();
    $this->result($list,1);
  }

  function delete($id) {
    if ($id == 1) {
      $this->error("无权限停用最高管理员");
    }
    $result = (new RoleService())->delete($id);
    if (!$result) {
      $this->error("停用失败");
    }
    $this->success("停用成功");
  }

  function restore($id) {
    $result = (new RoleService())->restore($id);
    $this->success($result > 0 ? '启用成功' : '启用失败');
  }

  function save() {
    $data = input();
    $validate = new roleValidate();
    if(!$validate->check($data)){
      $this->error($validate->getError());
    }
    if (!input('role_id')) {
      //没有传入id是添加
      $res = (new RoleService())->create(input());
      if (!$res) {
        $this->error('添加失败');
      } else {
        $this->success('添加成功');
      }
    } else {
      if (input('role_id') == 1) {
        $this->error("无权限修改最高管理员");
      }
      $res = (new RoleService())->update(input());
      if (!$res) {
        $this->error('修改失败');
      } else {
        $this->success('修改成功');
      }
    }
  }
}
