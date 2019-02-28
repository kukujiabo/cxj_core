<?php
namespace App\Service\Components\RongLian;

use App\Service\System\ConfigSv;
use App\Library\Rest;
use App\Library\Http;

/**
 * 融联云 服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-09
 */
class RongLianSv extends ConfigSv {

  protected $_rest;

  public function __construct() {
  
    $di = \PhalApi\DI();

    $this->_rest = new Rest($di->config->get('rong.api_host'), $di->config->get('rong.api_port'), $di->config->get('rong.api_version'));

    $this->_rest->setAccount($this->getConfig('rong_account_sid'), $this->getConfig('rong_account_token'));

    $this->_rest->setAppId($this->getConfig('rong_appid'));

    $this->_rest->setBodyType('json');

  }



  /**
   * 发送模版消息
   *
   * @param string $to
   * @param string $data
   * @param int $id
   *
   * @return 
   */
  public function sendTemplateMessage($to, $data, $tid) {

    return $this->_rest->sendTemplateSMS($to, $data, $tid);
  
  }

}
