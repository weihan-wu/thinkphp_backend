<?php

namespace app\api\controller\v1;

use app\common\controller\Base;
use app\common\service\Roleauthority as RoleAuthService;
class Roleauthority extends Base
{
  /*
   * 获取角色与权限之间的关系
   */
  function index() {
    $res = (new RoleAuthService())->getRoleInfo()->toArray();
    $tree = $this->getTree($res);
    $this->result($tree,1);
  }

  /**
   * 根据role_id查询到角色与权限的关系后再进先修改或保存操作
   */
  function save() {
    $role_id = input('roleAuthority_role_id');
    $rule_id = input('roleAuthority_rule_id');
    $info = (new RoleAuthService())->getRoleAuth($role_id)->toArray();
    if ($info) {
      $res = (new RoleAuthService())->updateByRoleID($info[0]['roleAuthority_role_id'],$rule_id);
      if (!$res) {
        $this->error('修改失败');
      }
      $this->success('修改成功');
    } else {
      $res = (new RoleAuthService())->create(input());
      if (!$res) {
        $this->error('添加失败');
      }
      $this->success('添加成功');
    }
  }

  function getRuleByRoleId() {
    $role_id = input('roleAuthority_role_id');
    $rule_ids = (new RoleAuthService())->getRuleByRoleID($role_id);
    $rule_ids = explode(',',$rule_ids);
    foreach ($rule_ids as $key => $value) {
      $rule_ids[$key] = intval($value);
    }
    $this->result($rule_ids,1);
  }

  protected function getTree($list,$pk='rule_id',$pid='rule_pid',$child='children',$root=0) {
    if (!is_array($list)) {
      return [];
    }
    //创建基于主键的数组引用
    $aRefer = [];
    foreach ($list as $key => $data) {
      $aRefer[$data[$pk]] = &$list[$key];
    }

    foreach ($list as $key => $data) {
      //判断是否存在parent
      $parentId = $data[$pid];
      if ($root === $parentId) {
        $tree[] = &$list[$key];
      } else {
        if (isset($aRefer[$parentId])) {
          $parent = &$aRefer[$parentId];
          $parent[$child][] = &$list[$key];
        }
      }
    }
    return $tree;
  }
}
