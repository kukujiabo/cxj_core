<?php
namespace App\Service\Components\Submail;

use App\Service\System\ConfigSv;
use Core\Service\CurdSv;

/**
 * submail 服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-09
 */
class SubmailSv extends ConfigSv {

  CONST API_DOMAIN = 'https://api.mysubmail.com/';

  /**
   * 编辑短信appid
   *
   * @param string $appId
   *
   * @return boolean true/false
   */
  public function editSmsAppId($appId) {
  
    return $this->editConfig('submail', 'submail_sms', 'submail_sms_appid', $appId, 'submail appId'); 
  
  }

  /**
   * 编辑短信appkey
   *
   * @param string $appKey
   *
   * @return boolean true/false
   */
  public function editSmsAppKey($appKey) {
  
    return $this->editConfig('submail', 'submail_sms', 'submail_sms_appkey', $appKey, 'submail appkey');
  
  }

  /**
   * 读取短信appId
   *
   * @return string $appId
   */
  public function getSmsAppId() {
  
    return $this->getConfig('submail_sms_appid');
  
  }

  /**
   * 读取短信appKey
   *
   * @return string $appKey
   */
  public function getSmsAppKey() {
  
    return $this->getConfig('submail_sms_appkey');
  
  }

  /**
   * 编辑邮件appid
   *
   * @param string $appId
   *
   * @return boolean true/false
   */
  public function editMailAppId($appId) {
  
    return $this->editConfig('submail', 'submail_mail', 'submail_mail_appid', $appId); 
  
  }

  /**
   * 编辑邮件appkey
   *
   * @param string $appKey
   *
   * @return boolean true/false
   */
  public function editMailAppKey($appKey) {
  
    return $this->editConfig('submail', 'submail_mail', 'submail_mail_appkey', $appId);
  
  }

  /**
   * 读取邮件appId
   *
   * @return string $appId
   */
  public function getMailAppId() {
  
    return $this->getConfig('submail_mail_appid');
  
  }

  /**
   * 读取邮件appKey
   *
   * @return string $appId
   */
  public function getMailAppKey() {
  
    return $this->getConfig('submail_mail_appkey');
  
  }

}
