<?php

namespace app\api\controller\v1;

use app\common\controller\Corss;
use Firebase\JWT\JWT;
use think\captcha\Captcha;
use app\common\service\Admin as AdminService;

class Login extends Corss
{

  public function login()
  {
    $account = input('username');
    $password = md5(input('password'));
    $code = input('code');
    $captcha = new Captcha();
    if (!$captcha->checkByCache($code)) {
      $this->error('无效的验证码');
    }
    $result = (new AdminService())->login($account, $password);
    unset($result['admin_password']);
    if (!$result) {
      $this->error('账号或密码错误');
    }

    //使用jwt生成token
    $jwt = new JWT();
    $payload = array(
      //域名
      "iss" => "http://api.sorting.com",
      "aud" => "http://api.sorting.com",
      //时间戳（为当前时间）
      "iat" => time(),
      //令牌过期时间
      //"exp" => time() + 3 ,
      //将用户id放入加密
      "aid" => $result['admin_id']
    );
    $token = $jwt::encode($payload, config('jwt.key'));

    $this->result([
      'token' => $token,
      'userinfo' => $result
    ], 1, '登录成功');
  }

  /**
   * 验证码
   */
  function verify()
  {
    $config = [
      'fontSize' => 30,
      'length' => 4,
      'useNoise' => false
    ];
    $captcha = new Captcha($config);
    return $captcha->entry();
  }
}
