<?php
namespace App\Service\Components\Submail;

use App\Service\BaseService;
use App\Library\Http;
use App\Exception\LogException;

/**
 * 模版接口，包含获取、创建、编辑或删除您的短信模板。
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-09
 */
class TemplateSv extends BaseService {

  /**
   * 服务器地址
   */

  CONST API_PATH = 'message/template.json';

  /**
   * 创建模版
   *
   * @param string $appid
   * @param string $title
   * @param string $signature
   * @param string $content
   *
   * @return boolean true/false
   */
  public function addSmsTemplate($appid, $signature, $title, $smsSignature, $content) {

    $data = [
    
      'appid' => $appid,

      'signature' => $signature,

      'sms_title' => $title,

      'sms_signature' => $smsSignature,

      'sms_content' => $content,
    
    ];

    return $this->_requestApi($data, 'post');
    
  }

  /**
   * 获取模版信息
   *
   * @param string $templateId
   *
   * @return array $info
   */
  public function getSmsTemplate($appid, $appkey, $templateId = NULL) {
  
    $data = [
    
      'appid' => $appid,

      'signature' => $appkey,

      'timestamp' => time()
    
    ];

    if ($templateId) {
    
      $data['template_id'] = $templateId;

    }

    return $this->_requestApi($data, 'get');
  
  }

  /**
   * 更新模版
   *
   * @param
   *
   * @return 
   */
  public function editTemplate($appId, $signature, $templateId, $smsSignature, $title, $content) {
  
    $data = [

      'appid' => $appId,

      'signature' => $signature,

      'template_id' => $templateId,

      'sms_signature' => $smsSignature,
    
      'sms_title' => $title,
    
      'sms_content' => $content

    ];

    return $this->_requestApi($data, 'put');
  
  }

  /**
   * 删除模版
   *
   * @param string $appId
   * @param string $templateId
   *
   * @return
   */
  public function deleteSmsTemplate($appId, $signature, $templateId) {

    if (!$templateId) {
    
      throw new LogException($this->_err->TMPIDMISSMSG, $this->_err->TMPIDMISSCODE);
    
    }
  
    $data = [
    
      'appid' => $appId,

      'signature' => $signature,

      'template_id' => $templateId
    
    ];

    return $this->_requestApi($data, 'delete');
  
  }

  /**
   * 调用submail Api
   *
   * @param array $data
   *
   * @return mixed
   */
  protected function _requestApi($data, $type) {
  
    $response = json_decode(Http::httpRequest(SubmailSv::API_DOMAIN . TemplateSv::API_PATH, $data, '', $type));

    if ($response->status == 'success') {
    
      if ($type == 'get') {
      
        return $response->templates ? $response->templates : $response->template;
      
      } else {
      
        return true;
      
      }
    
    } else {
    
      throw new LogException($response->msg, $response->code);
    
    }
  
  }

}
