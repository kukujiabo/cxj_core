<?php
namespace App\Service\Crm;

use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Model\MobileVerifyCode;
use App\Library\Sms;
use App\Exception\LogException;

/**
 * 验证码管理服务 
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-01
 */
class MobileVerifyCodeSv extends BaseService {

  protected $_sms;

  use CurdSv;

  /**
   * 发送验证码
   *
   * @param string $mobile
   *
   * @array return $state
   */
  public function sendVerifyCode($mobile) {

    /**
     * 先检查上一次发送时间，间隔不超过60秒不予重发
     */
    $msg = MobileVerifyCode::findLastByMobile($mobile); 

    if ($msg) {

      $restTime = time() - strtotime($msg['created_at']);
    
      if ($restTime < 60) {
      
        throw new LogException((60 - $restTime), $this->_err->VMTIMECODE);
      
      }
    
    }
  
    $code = $this->createCode($mobile);

    $tpCode = 'vIyS63';

    return Sms::sendSms($mobile, $tpCode, array('code' => $code));
  
  }


  /**
   * 生成验证码
   *
   * @param string $mobile
   *
   * @return array $data
   */
  public function createCode($mobile) {
  
    $code = rand(1000, 9999);

    $last = MobileVerifyCode::findLastByMobile($mobile);

    $duration = time() - $last['send_at'];
    
    $data = array(
      'code' => $code,
      'mobile' => $mobile,
      'created_at' => date('Y-m-d H:i:s'),
      'send_at' => time(),
      'expire_at' => time() + 300,
      'status' => 0
    );

    MobileVerifyCode::add($data);

    return $code;

  }

  /**
   * 检查验证码
   *
   * @param string $code
   * @param string $mobile
   *
   * @return boolean true/false
   */
  public function checkVerifyCode($mobile, $code) {

    if (empty($mobile)) {
    
      throw new LogException($this->_err->VRMOBILEEPTMSG, $this->_err->VRMOBILEEPTCODE);
    
    }

    if (empty($code)) {
    
      throw new LogException($this->_err->VRCODEEPTMSG, $this->_err->VRCODEEPTCODE);
    
    }
  
    $verifyCode = MobileVerifyCode::getLastItemByCodeMobile($code, $mobile);

    if (!$verifyCode || $verifyCode['expire_at'] < time() || $verifyCode['status'] == 1) {

      throw new LogException($this->_err->VRMOBILWRONGCODE, $this->_err->VRMOBILWRONGMSG);
    
    }

    return MobileVerifyCode::setUsed($verifyCode['id']);
  
  }


}
