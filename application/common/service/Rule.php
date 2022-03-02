<?php


namespace app\common\service;

use app\common\model\Rule as RuleModel;
use think\db\Where;
class Rule
{
  function getAllRule() {
    $data = input();
    $rows = input('size')?input('size'):5;
    $page = input('page')?input('page'):1;

    if($data){
      $where = [
          'rule_name' =>['like','%'.$data['keywords'].'%'],
      ];
      if (!empty($data['begin_time'])&&!empty($data['end_time'])){
        $where = array_merge($where,[
            'rule_create_time' =>['between time',[$data['begin_time'],$data['end_time']]]
        ]);
      }
    }

    $items = RuleModel::withTrashed()->where(new Where($where))->page($page,$rows)->select();
    $total = RuleModel::withTrashed()->where(new Where($where))->count();
    $data = [
        'total' =>$total,
        'items' =>$items
    ];
    return $data;
  }

  function delete($id) {
    return RuleModel::destroy($id);
  }

  function create($data) {
    return RuleModel::create($data);
  }

  function update($data) {
    return RuleModel::update($data);
  }

  function restore($id){
    $rule = RuleModel::onlyTrashed()->find($id);
    $result = $rule->restore();
    return $result;
  }
}
