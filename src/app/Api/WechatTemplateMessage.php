<?php
namespace App\Api;

/**
 * 2.2 微信模版消息接口
 *
 *
 */
class WechatTemplateMessage extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'getMiniMsgList' => [
      
        'openid' => 'openid|string|true||用户微信openid',

        'page' => 'page|int|false|1|页码',
      
        'page_size' => 'page_size|int|false|10|每页条数'
      
      ],

      'setViewed' => [
      
        'id' => 'id|int|true||消息id'
      
      ],

      'haveUnviewedMsg' => [
      
        'openid' => 'openid|string|true||用户微信openid',
      
      ]
    
    ]); 
  
  }

  /**
   * 查询已发送微信小程序模版消息
   * @desc 查询已发送微信小程序模版消息
   *
   * @return
   */
  public function getMiniMsgList() {
  
    return $this->dm->getMiniMsgList($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 设置消息为已读
   * @desc 设置消息为已读
   *
   * @return
   */
  public function setViewed() {
  
    return $this->dm->setViewed($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 查询是否有未读消息
   * @desc 查询是否有未读消息
   *
   * @return boolean true/false
   */
  public function haveUnviewedMsg() {
  
    return $this->dm->haveUnviewedMsg($this->retriveRuleParams(__FUNCTION__)); 
  
  }

}
