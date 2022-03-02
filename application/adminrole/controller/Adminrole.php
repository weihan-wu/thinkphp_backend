<?php

namespace app\adminrole\controller;

use app\admin\controller\Base;
use app\common\service\Adminrole as AdminRoleService;

class Adminrole extends Base
{
  function index()
  {
    $res = (new AdminRoleService())->getRoleList();
    $this->result($res, 1);
  }

  /**
   * 分配角色
   */
  function save()
  {
    $admin_id = input('adminrole_admin_id');
    $role_id = input('adminrole_role_id');
    $info = (new AdminRoleService())->getRelation($admin_id);
    if (sizeof($info) != 0) {
      $res = (new AdminRoleService())->updateByAdminID($info[0]['adminrole_admin_id'], $role_id);
      if (!$res) {
        $this->error('修改失败');
      }
      $this->success('修改成功');
    } else {
      $res = (new AdminRoleService())->create(input());
      if (!$res) {
        $this->error('添加失败');
      }
      $this->success('添加成功');
    }
  }

  /**
   * 读取管理员所拥有角色
   */
  function read()
  {
    $info = (new AdminRoleService())->getRelation(input('adminrole_admin_id'));
    $list = (new AdminRoleService())->getRoleList()->toArray();
    if ($info) {
      $tmp = explode(',', $info[0]['adminrole_role_id']);
      foreach ($list as $key => $value) {
        if (in_array($value['role_id'], $tmp)) {
          $list[$key]['check'] = true;
        } else {
          $list[$key]['check'] = false;
        }
      }
    } else {
      foreach ($list as $key => $value) {
        $list[$key]['check'] = false;
      }
    }
    $this->result($list, 1);
  }

  function hasRoles() {
    $admin_id = input('admin_id');
    $info = (new AdminRoleService())->getRelation($admin_id);
    if (sizeof($info) == 0) {
      $this->result($info,1);
    }
    $arr = explode(',',$info[0]['adminrole_role_id']);
    foreach ($arr as $key => $value) {
      $arr[$key] = intval($value);
    }
    $this->result($arr,1);
  }
}
