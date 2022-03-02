<?php

namespace app\admin\controller;

use think\App;
use think\Controller;

class Corss extends Controller
{
  protected $enableDestruct = true;

  public function __construct(App $app = null)
  {
    parent::__construct($app); // TODO: Change the autogenerated stub
    //允许跨域
    if (config('cors.on')) {
      isset($_SERVER['HTTP_ORIGIN']) &&
      in_array($_SERVER['HTTP_ORIGIN'], config('cors.allow_host')) &&
      header("access-control-allow-origin: " . $_SERVER['HTTP_ORIGIN']);
      header("access-control-allow-headers: *");
      header("access-control-allow-methods: GET,POST,PUT,DELETE,HEAD,OPTIONS");
      header("access-control-allow-credentials: true");
      header('X-Powered-By: WAF/2.0');
    }
    //预检跨域过滤
    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS') {
      $this->enableDestruct = false;
      exit();
    }

  }
}
