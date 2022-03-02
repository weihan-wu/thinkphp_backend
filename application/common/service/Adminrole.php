<?php


namespace app\common\service;

use app\common\model\Adminrole as AdminRoleModel;
use app\common\model\Role as RoleModel;
class Adminrole
{
  function getRoleList() {
    return RoleModel::field('role_id,role_name')->select();
  }

  function getRelation($admin_id) {
    $field = "adminrole_admin_id,adminrole_role_id";
    return AdminRoleModel::where('adminrole_admin_id',$admin_id)->field($field)->select();
  }

  function delete($id) {
    return AdminRoleModel::destroy($id);
  }

  function create($data) {
    return AdminRoleModel::create($data);
  }

  function updateByAdminID($admin_id,$role_id) {
    return AdminRoleModel::where('adminrole_admin_id',$admin_id)->setField('adminrole_role_id',$role_id);
  }
}
