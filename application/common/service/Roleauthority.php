<?php


namespace app\common\service;

use app\common\model\Roleauthority as RoleAuthModel;
use app\common\model\Rule as RuleModel;
class Roleauthority
{
  function getRoleInfo() {
    //����Ȩ��ҳ����ʱֻ���в˵��ķ��䣬��ť����ķ��������
    return RuleModel::where('rule_type','1')->select();
  }

  function getRoleAuth($id) {
    return RoleAuthModel::where('roleAuthority_role_id',$id)->select();
  }

  function delete($id) {
    return RoleAuthModel::destroy($id);
  }

  function create($data) {
    return RoleAuthModel::create($data);
  }

  function updateByRoleID($role_id,$rule_id) {
    return RoleAuthModel::where('roleAuthority_role_id',$role_id)->setField('roleAuthority_rule_id',$rule_id);
  }

  function getRuleByRoleID($role_id) {
    return RoleAuthModel::where('roleAuthority_role_id',$role_id)->value('roleAuthority_rule_id');
  }
}
