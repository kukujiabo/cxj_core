<?php
namespace App\Service\Components\Qiniu;

use App\Service\System\ConfigSv;
use App\Library\RedisClient;
use App\Library\Http;
use Core\Service\CurdSv;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


/**
 * 七牛云存储服务
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class QiniuSv extends ConfigSv {

  protected $_expireTime = 3600;

  /**
   * 添加配置
   *
   * @param string $accessKey
   * @param string $accessSecret
   *
   * @return boolean $id
   */
  public function editKey($accessKey) {

    return $this->editConfig('qiniu', 'qiniu_account', 'qiniu_access_key', $accessKey);
  
  }

  /**
   * 编辑密钥
   *
   * @param string $accessKey
   * @param string $accessSecret
   *
   * @return boolean $id
   */
  public function editSecret($accessSecret) {
  
    return $this->editConfig('qiniu', 'qiniu_account', 'qiniu_access_secret', $accessSecret);
  
  }

  /**
   * 读取 access key
   *
   * @return string access key
   */
  public function getKey() {
  
    return $this->getConfig('qiniu_access_key');
  
  }

  /**
   * 读取 access secret
   *
   * @return string access token
   */
  public function getSecret() {
  
    return $this->getConfig('qiniu_access_secret');
  }

  /**
   * 读取 access secret
   *
   * @return string access token
   */
  public function getAccessToken($bucket = 'common') {
  
    $token = RedisClient::get('qiniu_tokens', $bucket);

    if (time() > $token->expire_time) {
    
      /**
       * token 已过期，需要重新获取
       */
      $auth = new Auth($this->getKey(), $this->getSecret());

      $returnBody = array(
                
        'key' => "$(key)",

        'hash' => "$(etag)",

        'bucket' => "$(bucket)",

        'name' => "$(x:name)"
                              
      );

      $policy = array(
            
        'returnBody' => json_encode($returnBody)
                  
      );

      $data = $auth->uploadToken($bucket, null, $this->_expireTime, $policy, true);
      
      $token = [ 'data' => $data, 'expire_time' => time() + $this->_expireTime ];

      RedisClient::set('qiniu_tokens', $bucket, $token);

    }

    return $token; 

  }

  /**
   * 上传base64编码图片到七牛
   *
   * @param string base64
   *
   * @return
   */
  public function uploadByteImage($imageBytes, $bucket = 'common') {

    $uploadToken = $this->getAccessToken($bucket);
  
    $uploadMgr = new UploadManager();

    list($ret, $err) = $uploadMgr->put($uploadToken->data, null, $imageBytes); 

    return $err ? $err : $ret;
  
  }

}
