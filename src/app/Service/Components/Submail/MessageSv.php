<?php
namespace App\Service\Components\Submail;

use App\Service\BaseService;
use App\Library\Http;

/**
 * 短信服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-12
 */
class MessageSv extends BaseService {

  /**
   * 服务器地址
   */

  CONST LOG_API_PATH = 'log/message';

  CONST BALANCE_API_PATH = 'balance/sms';

  /**
   * 短信发送日志查询
   *
   * @param string appid
   * @param string signature
   * @param string recipient
   * @param string project
   * @param string resultStatus
   * @param string startDate
   * @param string endDate
   * @param string orderBy
   * @param string page
   * @param string pageSize
   *
   * @return mixed 
   */
  public function msgLog(
    
    $appId, 
    $signature, 
    $recipient = NULL, 
    $project = NULL, 
    $resultStatus = NULL, 
    $startDate = 0, 
    $endDate = 0, 
    $orderBy = 'desc', 
    $page = 1, 
    $pageSize = 30
  
  ) {
  
    $options = [
    
      'appid' => $appId,

      'signature' => $signature,

      'order_by' => $orderBy,

      'offset' => $page - 1,

      'rows' => $pageSize,

      'timestamp' => time()
    
    ];

    if ($recipient) {
    
      $options['recipient'] = $recipient;
    
    }
    if ($project) {
    
      $options['project'] = $project;
    
    }
    if ($resultStatus) {
    
      $options['result_status'] = $resultStatus;
    
    }
    if ($startDate) {
    
      $options['start_date'] = $startDate;
    
    }
    if ($endDate) {
    
      $options['end_date'] = $endDate;
    
    }

    return json_decode(Http::httpRequest(SubmailSv::API_DOMAIN . MessageSv::LOG_API_PATH, $options, '', 'post', '', 5000, 'raw'), true);
  
  }

  /**
   * 获取短信余额
   *
   * @param string appId
   * @param string signature
   *
   * @return number balance
   */
  public function getSmsBalance($appId, $signature) {
  
    $options = [
    
      'appid' => $appId,

      'signature' => $signature,

      'timestamp' => time()
    
    ];

    return json_decode(Http::httpRequest(SubmailSv::API_DOMAIN . MessageSv::BALANCE_API_PATH, $options, '', 'post', '', 5000, 'raw'), true);
  
  }

}
