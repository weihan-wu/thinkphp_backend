<?php


namespace app\common\service;

use think\db\Where;
use app\common\model\Announcement as AnModel;
use app\common\service\Admin as AdminService;

class Announcement
{
  function getAllAnnouncement()
  {
    $data = input();
    $rows = input('size') ? input('size') : 5;
    $page = input('page') ? input('page') : 1;
    if ($data) {
      $where = [
        'an_title' => ['like', '%' . $data['keywords'] . '%']
      ];
      if (!empty($data['begin_time']) && !empty($data['end_time'])) {
        $where = array_merge($where, [
          'an_create_time' => ['between time', [$data['begin_time'], $data['end_time']]]
        ]);
      }
    }

    $items = AnModel::where(new Where($where))->page($page, $rows)->order('an_create_time', 'desc')->select()->toArray();
    if ($items) {
      foreach ($items as $key => $value) {
        $author = (new AdminService())->getAdminTruename($value['an_author'])->toArray();
        $items[$key] = array_merge($value, $author);
      }
    }
    $total = AnModel::where(new Where($where))->count();
    $data = [
      'total' => $total,
      'items' => $items
    ];
    return $data;
  }

  function getOneAnnouncement($id)
  {
    return AnModel::find($id);
  }

  function delete($id)
  {
    return AnModel::destroy($id);
  }

  function create($data)
  {
    return AnModel::create($data);
  }

  function update($data)
  {
    return AnModel::update($data);
  }
}
