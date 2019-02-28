<?php
namespace App\Api;

/**
 * 2.1 微信服务接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-26
 */
class Wechat extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'editAppConf' => [
      
        'app_name' => 'app_name|string|true||应用名称',

        'appid' => 'appid|string|true||应用appid',

        'appsecret' => 'appsecret|string|true||应用appsecret',

        'title' => 'title|string|true||应用说明'
      
      ],

      'getAccessToken' => [
      
      ],

      'pubIndex' => [

        'signature' => 'signature|string|false||认证签名',

        'timestamp' => 'timestamp|string|false||时间戳',

        'nonce' => 'nonce|string|false||随机数',

        'echostr' => 'echostr|string|false||随机字符串',

        'openid' => 'openid|string|false||用户openid',

        'encrypt_type' => 'encrypt_type|string|false||加密方式',
     
        'msg_signature' => 'msg_signature|string|false||消息签名'
      
      ],

      'getOpenId' => [

        'code' => 'code|string|true||微信code'
      
      ],

      'miniMsg' => [
      
        'touser' => 'touser|string|true||用户openid',
        'template_id' => 'template_id|string|true||模版id',
        'form_id' => 'form_id|string|true||表单id',
        'page' => 'page|string|true||页面路径',
        'data' => 'data|string|true||数据',
        'emphasis' => 'emphasis|string|true||强调文字'
      
      ]
      
    ]);
  
  }

  /**
   * 微信服务号通知入口
   * @desc 微信服务号通知入口
   *
   * @return
   */
  public function pubIndex() {
  
    return $this->dm->pubIndex($this->retriverRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 编辑微信应用配置
   * @desc 编辑微信应用配置
   *
   * @return 
   */
  public function editAppConf() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->editAppConf($params['app_name'], $params['appid'], $params['appsecret'], $params['title']);
  
  }

  /**
   * 获取微信访问令牌
   * @desc 获取微信访问令牌
   *
   * @return
   */
  public function getAccessToken() {
  
    return $this->dm->getAccessToken();
  
  }

  /**
   * 获取微信用户openid
   * @desc 获取微信用户openid
   *
   * @return
   */
  public function getOpenId() {

    $params = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->getOpenId($params['code']);
  
  }

  public function miniMsg() {
  
    return $this->dm->miniMsg($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
