<?php
namespace App\Api;

/**
 * 4.1 七牛云存储接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-04
 */
class Qiniu extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'getAccessToken' => [
      
        'bucket' => 'bucket|string|true||存储空间名称'

      ],

      'editConfig' => [
      
        'access_key' => 'access_key|string|true||access key',

        'access_secret' => 'access_secret|string|true||access secret'
      
      ]
    
    ]);
  
  }

  /**
   * 获取访问令牌
   *
   * @return string token
   */
  public function getAccessToken() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->getAccessToken($params['bucket']);
  
  }

  /**
   * 编辑 access key, access secret
   *
   * @return int num
   */
  public function editConfig() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->editConfig($params['access_key'], $params['access_secret']);
  
  }

}
