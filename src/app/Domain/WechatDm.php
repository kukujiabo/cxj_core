<?php
namespace App\Domain;

use App\Service\Components\Wechat\WechatAppSv;

class WechatDm {

  protected $_wxsv;

  public function __construct() {
  
    $this->_wxsv = new WechatAppSv();
  
  }

  /**
   * 微信服务入口
   *
   */
  public function pubIndex($data) {
  
    $wxsv = new WechatAppSv('share_pub');

    return $wxsv->pubIndex($data);
  
  }

  /**
   * 编辑微信应用配置
   */
  public function editAppConf($appName, $appid, $appsecret, $title) {
  
    return $this->_wxsv->editAppConf($appName, $appid, $appsecret, $title); 

  }

  /**
   * 读取微信访问令牌
   */
  public function getAccessToken() {
  
    return $this->_wxsv->getAccessToken();
  
  }

  /**
   * 获取openID
   */
  public function getOpenId($code) {
  
    return $this->_wxsv->getOpenId($code);
  
  }

  /**
   * 微信小程序登录
   */
  public function wechatMiniLogin($appName, $code) {
  
    return $this->_wxsv->wechatMiniLogin($appName, $code);
  
  }

  public function MiniMsg($data) {
  
    return $this->_wxsv->miniMsg($data['touser'], $data['template_id'], $data['form_id'], $data['page'], $data['data'], $data['emphasis']);
  
  }

}
