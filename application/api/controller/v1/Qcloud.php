<?php

namespace app\api\controller\v1;

use app\common\controller\Base;
use Qcloud\Cos\Client;
class Qcloud extends Base
{
  private function __cosClient(){
    return $cosClient = new Client(
        array(
            'schema' => 'http', //协议头部，默认为http
            'region' => config('api.qcloud.region'),
            'credentials'=> array(
                'secretId'  => config('api.qcloud.secretId') ,
                'secretKey' => config('api.qcloud.secretKey')
            )
        )
    );
  }

  function index() {
    try {
      //获取存储桶列表
      //请求成功
      $result = $this->__cosClient()->listBuckets();
      dump($result);
    } catch (\Exception $e) {
      //请求失败
      echo($e);
    }
  }

  public function upload()
  {
    //获取上传的文件
    $file = request()->file('file');
    //获取储存桶对象
    $cosClient = $this->__cosClient();
    $cdn_server = config('api.qcloud.cdnServer');
    //上传
    try {
      $result = $cosClient->Upload(
          $bucket = config('api.qcloud.bucket'),//存储桶名称
          $key = 'images/'.md5(uniqid()).'.'.$_FILES["file"]["name"], //此处的 key 为对象键
          $body = fopen($file->getFileInfo(), "rb")//文件数据
      );
      //拼接CDN地址
      $CDNLocation = $cdn_server . substr($result['Location'],49);
      return json([
          "msg"=>"上传成功",
          "data"=>[
              "RequestId"=>$result['RequestId'],
              "Bucket"=>$result['Bucket'],
              "Key"=>$result['Key'],
              "Location"=>"https://".$result['Location'],
              "CDNLocation"=>$CDNLocation
          ]
      ]);
    } catch (\Exception $e) {

      return json([
          "msg" =>"上传失败",
          "data"=>$e,
      ]);

    }
  }

  public function delete(){
    //获取删除图的key
    $key = input('get.')['key'];
    //获取储存桶对象
    $cosClient = $this->__cosClient();

    //删除
    try {
      $result = $cosClient->deleteObject(array(
          'Bucket' => config('api.qcloud.bucket'),//存储桶名称
          'Key' => $key,
      ));

      return json([
          "msg"=>"删除成功",
          "data"=>[
              "RequestId"=>$result['RequestId'],
              "Bucket"=>$result['Bucket'],
              "Key"=>$result['Key'],
              "Location"=>"https://".$result['Location'],
          ]
      ]);
    } catch (\Exception $e) {
      return json([
          "msg" =>"删除失败",
          "data"=>$e,
      ]);
    }
  }

  public function imageList() {
    //获取储存桶对象
    $cosClient = $this->__cosClient();

    try {
      $result = $cosClient->listObjects(array(
          'Bucket' => config('api.qcloud.bucket'), //存储桶名称
          'Delimiter' => '', //Delimiter表示分隔符, 设置为/表示列出当前目录下的object, 设置为空表示列出所有的object
          'EncodingType' => 'url',//编码格式，对应请求中的 encoding-type 参数
          'MaxKeys' => 1000, // 设置最大遍历出多少个对象, 一次listObjects最大支持1000
      ));
      dump($result);
    }  catch (\Exception $e) {
      return json([
          "msg" =>"获取列表失败",
          "data"=>$e,
      ]);
    }
  }
}
