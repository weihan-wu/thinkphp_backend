<?php

namespace app\api\controller\v1;

use app\common\controller\Base;
use app\common\service\Rule as RuleService;
use app\common\validate\ruleValidate;

class Rule extends Base
{
  /*
   * 请求规则列表
   */
  function index() {
    $info = (new RuleService())->getAllRule();
    if (!$info) {
      $this->error('请求数据失败');
    }
    $this->result($info,1);
  }

  /*
   * 停用规则列表
   */
  function delete($id) {
    $result = (new RuleService())->delete($id);
    if (!$result) {
      $this->error("停用失败");
    }
    $this->success("停用成功");
  }

  function restore($id) {
    $result = (new RuleService())->restore($id);
    $this->success($result > 0 ? '启用成功' : '启用失败');
  }

  /*
   * 保存角色列表
   */
  function save() {
    $data = input();
    $validate = new ruleValidate();
    if(!$validate->check($data)){
      $this->error($validate->getError());
    }
    if (!input('rule_id')) {
      //没有传入id是添加
      $res = (new RuleService())->create(input());
      if (!$res) {
        $this->error('添加失败');
      } else {
        $this->success('添加成功');
      }
    } else {
      $res = (new RuleService())->update(input());
      if (!$res) {
        $this->error('修改失败');
      } else {
        $this->success('修改成功');
      }
    }
  }
}
