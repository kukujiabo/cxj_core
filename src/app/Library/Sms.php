<?php
namespace App\Library;

/**
 * 短信管理类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class Sms {

  public function sendSms($mobile, $tpCode, $vars) {
  
    $message_configs = array(

      'appid' => '17822',

      'appkey' => '6bb2222e91bb4315310fd197260b9430',

      'sign_type' => 'normal'

    );

    $submail = new \MESSAGEXsend($message_configs);

    $submail->setTo($mobile);

    $submail->SetProject($tpCode);

    foreach($vars as $key => $var) {

      $submail->AddVar($key, $var); 
    
    }

    $xsend = $submail->xsend();

    return $xsend;
  
  }

}
