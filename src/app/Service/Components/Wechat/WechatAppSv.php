<?php
namespace App\Service\Components\Wechat;

use App\Service\System\ConfigSv;
use App\Library\RedisClient;
use App\Library\WXBizDataCrypt;
use App\Library\WXBizMsgCrypt;

/**
 * 微信应用服务类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatAppSv extends ConfigSv {

  protected $_appid;

  protected $_appsecret;

  protected $_appName;

  public function __construct($appName = 'share_lab_mini') {

    $this->_appName = $appName;
  
    $this->_appid = $this->getConfig("{$appName}_appid");

    $this->_appsecret = $this->getConfig("{$appName}_appsecret");
  
  }

  /**
   * 微信公众号服务入口
   *
   */
  public function pubIndex($data) {

    /**
     * 先对所有数据进行保存
     */
    $wxRawSv = new WxRawDataSv();

    $id = $wxRawSv->add([
    
      'signature' => $data['signature'],

      'nonce' => $data['nonce'],

      'echostr' => $data['echostr'],
      
      'timestamp' => $data['timestamp'],

      'openid' => $data['openid'],

      'encrypt_type' => $data['encrypt_type'],

      'msg_signature' => $data['msg_signature'],

      'raw_data' => $rawData
    
    ]);

    $token = $this->getConfig("{$this->_appName}_token");

    if ($data['signature'] && $data['echostr']) { // 服务号认证信息

      if (WechatAuth::pubAuth($data['signature'], $data['timestamp'], $data['nonce'], $token)) {
      
        exit($data['echostr']);
      
      } else {
      
        exit('');
      
      }
    
    } else if ($data['msg_signature']) { // 服务号推送事件

      $rawData = file_get_contents('php://input');

      $aesKey = $this->getConfig("{$this->_appName}_encodingaeskey");

      $pc = new WXBizMsgCrypt($token, $aesKey, $this->_appid);

      $decryptMsg = '';

      $res = $pc->decryptMsg($data['msg_signature'], $data['timestamp'], $data['nonce'], $rawData, $decryptMsg);

      if ($res != 0) {

        /**
         * 解密失败，记入错误日志中，不能抛出异常
         */
        Logs::error(__CLASS__, "decode: {$encrypt} failed! ");
        
        return;
        
      }

      $decodeXML = (array)simplexml_load_string($decryptMsg, 'SimpleXMLElement', LIBXML_NOCDATA);

    }
  
  }

  /**
   * 添加应用配置
   *
   * @param string appName
   * @param string appId
   * @param string appSecret
   *
   * @return
   */
  public function editAppConf($appName, $appId, $appSecret, $title) {
  
    $res1 = $this->editConfig('wechat', 'app', "{$appName}_appid", $appId, $title);

    $res2 = $this->editConfig('wechat', 'app', "{$appName}_appsecret", $appSecret, $title);

    return $res1 || $res2;
  
  }

  /**
   * 获取微信访问令牌
   *
   * @return string accessToken
   */
  public function getAccessToken() {
  
    return WechatAuth::getAccessToken($this->_appid, $this->_appsecret);  
  
  }

  /**
   * 获取openid
   *
   * @param string code
   *
   * @return object
   */
  public function getOpenId($code) {
  
    return WechatAuth::getOpenId($this->_appid, $this->_appsecret, $code);
  
  }

  /**
   * 获取微信小程序二维码
   *
   * @param string 
   *
   * @return object
   */
  public function getMiniTempCode($scene, $page, $width, $autoColor, $lineColor, $hyaline) {

    return WechatTools::getMiniTempCode(self::getAccessToken(), $scene, $page, $width, $autoColor, $lineColor, $hyaline);
  
  }

  /**
   * 解密微信加密数据
   *
   * @param array 
   *
   * @return 
   */
  public function wechatDecryptedData($sessionKey, $encryptedData, $iv) {

    $pc = new WXBizDataCrypt($this->_appid, $sessionKey);

    $errCode = $pc->decryptData($encryptedData, $iv, $data);

    if ($errCode == 0) {
    
      return json_decode($data);
    
    } else {
    
      $this->throwError($errCode, $this->_err->DECRYPTEDFAILEDCODE);
    
    }
  
  }

  /**
   * 推送小程序模版消息
   *
   */
  public function miniMsg($toUser, $templateId, $formId, $page, $data, $emphasis, $relatId, $type) {
  
    $accessToken = self::getAccessToken();

    $wtmSv = new WechatTemplateMessageSv();
  
    return $wtmSv->miniMsg($toUser, $templateId, $formId, $page, $data, $emphasis, $relatId, $accessToken, $type);
  
  }

}
