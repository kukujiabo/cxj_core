<?php
namespace App\Domain;

use App\Service\Components\Wechat\WechatTemplateMessageSv;

class WechatTemplateMessageDm {

  protected $_wtmSv;

  public function __construct() {
  
    $this->_wtmSv = new WechatTemplateMessageSv(); 
  
  }

  public function getMiniMsgList($data) {
  
    return $this->_wtmSv->getMiniMsgList($data); 
  
  }

  public function setViewed($data) {
  
    return $this->_wtmSv->setViewed($data['id']);
  
  }

  public function haveUnviewedMsg($data) {
  
    return $this->_wtmSv->haveUnviewedMsg($data['openid']);
  
  }

}
