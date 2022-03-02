<?php


namespace app\common\service;

use think\db\Where;
use app\common\model\Award as AwardModel;
class Award
{
  function getAllAward()
  {
    $data = input();
    $rows = input('size') ? input('size') : 5;
    $page = input('page') ? input('page') : 1;
    if ($data) {
      $where = [
          'award_name' => ['like', '%' . $data['keywords'] . '%']
      ];
      if (!empty($data['begin_time']) && !empty($data['end_time'])) {
        $where = array_merge($where, [
            'award_create_time' => ['between time', [$data['begin_time'], $data['end_time']]]
        ]);
      }
    }

    $items = AwardModel::withTrashed()->where(new Where($where))->page($page, $rows)->select();
    $total = AwardModel::withTrashed()->where(new Where($where))->count();
    $data = [
        'total' => $total,
        'items' => $items
    ];
    return $data;
  }

  function getOneAward($id)
  {
    return AwardModel::find($id);
  }


  function create($data)
  {
    return AwardModel::create($data);
  }

  function update($data)
  {
    return AwardModel::update($data);
  }

  /*
   * 软删除
   */
  function delete($id)
  {
    return AwardModel::destroy($id);
  }

  /*
   * 软删除恢复
   */
  function restore($id){
    $award = AwardModel::onlyTrashed()->find($id);
    $result = $award->restore();
    return $result;
  }

  /*
   * 真删除
   */
  function destory($id) {
    $award = AwardModel::withTrashed()->get($id);
    $result = $award->delete(true);
    return $result;
  }
}
