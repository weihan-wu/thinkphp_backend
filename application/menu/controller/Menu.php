<?php

namespace app\menu\controller;
use app\admin\controller\Base;
use app\common\model\Adminrole as AdminRoleModle;
use app\common\model\Roleauthority as RoleAuthModel;
use app\common\model\Rule as RuleModel;
class Menu extends Base
{
  /**
   * 菜单列表
   * //通过角色id，获取对应的所属角色的路由规则
   */
  function index() {
    //通过当前登录的用户ID来获取该用户所拥有的角色
    $adminRole = new AdminRoleModle();
    $role_ids = $adminRole->where('adminrole_admin_id',$this->aid)->value('adminrole_role_id');
    $role_ids_arr = explode(',',$role_ids);

    //通过当前登录用户所拥有的角色ID查询这些角色拥有那些操作权限
    $roleAuth = new RoleAuthModel();
    $ruleAuth_ids = $roleAuth->whereIn('roleAuthority_role_id',$role_ids_arr)->column('roleAuthority_rule_id');

    //拼接当前用户所拥有的路由规则
    $tmp = '';
    foreach ($ruleAuth_ids as $key=>$value) {
      $tmp .= ',' . $value;
    }
    $tmps = substr($tmp,1);

    //查询所有路由规则的详情
    $rule = new RuleModel();
    $fields = 'rule_id as id,rule_name as name,rule_path as path,rule_component as component,rule_icon as icon,rule_pid';
    $rule_list = $rule->whereIn('rule_id',$tmps)->where('rule_type','1')->field($fields)->select()->toArray();
    if (!$rule_list) {
      $this->error('当前账号无权限，请联系管理员！');
    }
    $menus = $this->getTree($rule_list);
    $this->result($menus,1);
  }

  protected function getTree($list,$pk='id',$pid='rule_pid',$child='children',$root=0) {
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
