<?php


namespace app\common\service;

use app\common\model\Admin as AdminModel;
use think\db\Where;
class Admin
{
    function login($account,$password) {
      return AdminModel::where('admin_username',$account)->where('admin_password',$password)->find();
    }

    function getAdmin($id) {
      return AdminModel::find($id);
    }

  function getAdminTruename($id) {
    return AdminModel::field('admin_truename as an_authorname')->find($id);
  }

    function getAllAdmin() {
      $data = input();
      $rows = input('size')?input('size'):5;
      $page = input('page')?input('page'):1;
      if($data){
        $where = [
            'admin_username|admin_telphone|admin_email' => ['like','%'.$data['keywords'].'%']
        ];
        if (!empty($data['begin_time'])&&!empty($data['end_time'])){
          $where = array_merge($where,[
              'admin_create_time' =>['between time',[$data['begin_time'],$data['end_time']]]
          ]);
        }
      }

      $items = AdminModel::withTrashed()->where(new Where($where))->field('admin_password',true)->page($page,$rows)->select();
      $total = AdminModel::withTrashed()->where(new Where($where))->count();
      $data = [
          'total' =>$total,
          'items' =>$items
      ];
      return $data;
    }

    function delete($id) {
      return AdminModel::destroy($id);
    }

    function restore($id){
      $user = AdminModel::onlyTrashed()->find($id);
      $result = $user->restore();
      return $result;
    }

    function create($data) {
      return AdminModel::create($data);
    }

    function update($data) {
      return AdminModel::update($data);
    }
}
