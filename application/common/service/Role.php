<?php


namespace app\common\service;

use app\common\model\Role as RoleModel;
use think\db\Where;
class Role
{
  function getAllRole() {
    $data = input();
    $rows = input('size')?input('size'):5;
    $page = input('page')?input('page'):1;

    if($data){
      $where = [
          'role_name' =>['like','%'.$data['keywords'].'%'],
      ];
      if (!empty($data['begin_time'])&&!empty($data['end_time'])){
        $where = array_merge($where,[
            'role_create_time' =>['between time',[$data['begin_time'],$data['end_time']]]
        ]);
      }
    }

    $items = RoleModel::withTrashed()->where(new Where($where))->page($page,$rows)->select();
    $total = RoleModel::withTrashed()->where(new Where($where))->count();
    $data = [
        'total' =>$total,
        'items' =>$items
    ];
    return $data;
  }

  function delete($id) {
    return RoleModel::destroy($id);
  }

  function create($data) {
    return RoleModel::create($data);
  }

  function update($data) {
    return RoleModel::update($data);
  }

  function restore($id){
    $role = RoleModel::onlyTrashed()->find($id);
    $result = $role->restore();
    return $result;
  }

  function lists() {
    $file = 'role_id,role_name';
    return RoleModel::field($file)->select();
  }
}
