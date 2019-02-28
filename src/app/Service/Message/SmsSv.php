<?php
namespace App\Service\Message;

use App\Service\BaseService;
use App\Service\Crm\MobileVerifyCodeSv;
use App\Service\Components\RongLian\RongLianSv;


/**
 * 短信服务
 *
 * @author Meroc Chen <398515393@qq.com 2017-12-01
 */
class SmsSv extends BaseService {


  /**
   * 发送验证短信
   *
   * @param string $mobile
   *
   * @return array $msg
   */
  public function sendVerify($mobile) {

    $code = MobileVerifyCodeSv::createCode($mobile); 

    $rsv = new RongLianSv();

    return $rsv->sendTemplateMessage($mobile, [ '123', '321'], $rsv->getConfig('rong_verify_tmp_code'));
  
  }


}
