<?php


namespace app\admin\controller;

use app\common\service\Admin as AdminService;
use app\common\validate\adminValidate;

class Admin extends Base
{
  /*
   * 获取管理员列表
   */
 function index() {
  $info = (new AdminService())->getAllAdmin();
  $this->result($info,1);
 }

 /*
  * 软删除管理员
  */
 function delete($id) {
   if ($id == 1) {
     $this->error("无权限停用最高管理员");
   }
   $result = (new AdminService())->delete($id);
   if (!$result) {
     $this->error("停用失败");
   }
   $this->success("停用成功");
 }

  /**
   * 软删除恢复
   * @param $id 管理员id
   */
  function restore($id) {
    $result = (new AdminService())->restore($id);
    $this->success($result > 0 ? '启用成功' : '启用失败');
  }

  /**
   * 管理员添加与修改的保存
   */
  function save() {
    $data = input();
    if (!input('admin_id')) {
      $default_pwd = 123456;
      $data['admin_password'] = $default_pwd;
      $validate = new adminValidate();
      if(!$validate->check($data)){
        $this->error($validate->getError());
      }
      $data['admin_password'] = md5($default_pwd);
      (new AdminService())->create($data);
      $this->success('添加成功！');
    } else {
      $validate = new adminValidate();
      if(!$validate->scene('update')->check($data)){
        $this->error($validate->getError());
      }
      (new AdminService())->update($data);
      $this->success('修改成功！');
    }
  }
}
