<?php

namespace app\common\validate;

use think\Validate;

class BaseValidate extends Validate
{
  public function goCheck($scene = false)
  {
    $params = request()->param();
    $check = $scene ? $this->scene($scene)->check($params) : $this->check($params);
    if (!$check)  $this->error($this->getError());
    return true;
  }
}
