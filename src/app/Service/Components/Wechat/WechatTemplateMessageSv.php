<?php
namespace App\Service\Components\Wechat;

use App\Service\BaseService;
use App\Library\Http;
use Core\Service\CurdSv;


/**
 * 微信模版消息管理
 *
 */
class WechatTemplateMessageSv extends BaseService {

  use CurdSv;

  /**
   * 新增微信小程序消息
   *
   */
  public function miniMsg($toUser, $templateId, $formId, $page, $data, $emphasis, $relatId, $token, $type) {
  
    $postData = [
    
      'touser' => $toUser,

      'template_id' => $templateId,
      
      'form_id' => $formId,

      'page' => $page,

      'data' => $data

      //'emphasis_keyword' => $emphasis
    
    ];

    $options = [

      'relat_id' => $relatId,
    
      'status' => 0,

      'type' => $type,

      'created_at' => date('Y-m-d H:i:s')
    
    ];

    $newMessage = array_merge($postData, $options);

    $newMessage['data'] = json_encode($data);

    $msgId = $this->add($newMessage);

    $api = WechatApi::SEND_MINI_TMP_MSG;

    $url = str_replace('{ACCESS_TOKEN}', $token, $api);

    $response = json_decode(Http::httpPost($url, json_encode($postData), '', '', 5000, 'raw'));

    if ($response->errcode == 0) {
    
      return $this->update($msgId, [ 'status' => 1 ]);
    
    } else {

      $this->update($msgId, [ 'response' => json_encode($response) ] );
    
      return 0;
    
    }
  
  }

  /**
   * 标记消息为已读
   */
  public function setViewed($id) {
  
    return $this->update($id, [ 'status' => 2, 'view_at' => date('Y-m-d H:i:s') ]); 
  
  }

  /**
   * 查询小程序模版消息列表
   */
  public function getMiniMsgList($data) {
  
    $query = [];

    if ($data['openid']) {
    
      $query['touser'] = $data['openid'];
    
    } 

    return $this->queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);
  
  }

  public function haveUnviewedMsg($openid) {
  
    return $this->queryCount([ 'touser' => $openid, 'status' => 1 ]); 
  
  }

}
