<?php
namespace App\Service\Components\Wechat;

use App\Library\RedisClient;
use App\Library\Http;

/**
 * 微信权限服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatAuth {

  /**
   * 获取微信接口访问令牌
   *
   * @param string appid
   * @param string appsecret
   *
   * @return
   */
  public static function getAccessToken($appid, $appsecret) {

    $accessToken = RedisClient::get('wechat_auth', $appid);

    if (!$accessToken || !$accessToken->access_token || $accessToken->expire_at < time()) {

      $url = str_replace(array('{APPID}', '{APPSECRET}'), array($appid, $appsecret), WechatApi::GET_ACCESS_TOKEN);

      $result = json_decode(Http::httpGet($url));  

      if ($result->errcode) {
      
        //todo record error.
      
      }
      
      $newAccessToken = [
      
        'access_token' => $result->access_token,

        'expire_at' => time() + $result->expires_in - 5
      
      ];

      RedisClient::set('wechat_auth', $appid, $newAccessToken);

      return $result->access_token;

    } else {
    
      return $accessToken->access_token;
    
    }
  
  }

  /**
   * 获取用户openid
   *
   * @param string appid
   * @param string appsecret
   * @param string code
   *
   * @return
   */
  public static function getOpenId($appid, $appsecret, $code) {
  
    /**
     * 读取配置url
     */
    $url = str_replace(

      array('{APPID}', '{APPSECRET}', '{CODE}'), 

      array($appid, $appsecret, $code), 

      WechatApi::GET_MIN_OPENID

    );
  
    $result = json_decode(Http::httpGet($url));

    if ($result->errcode) {
    
      //todo handle api error
    
    }

    return $result;

  }

  /**
   * 微信服务号服务器认证
   */
  public static function pubAuth($signature, $timestamp, $nonce, $token) {

    $signArr = [$timestamp, $nonce, $token];

    sort($signArr, SORT_STRING);
  
    $sig2 = sha1(implode($signArr));

    return $signature == $sig2;
  
  }

}
