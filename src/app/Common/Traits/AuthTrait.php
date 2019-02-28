<?php 
namespace App\Common\Traits;

use App\Library\RedisClient;

/**
 * 鉴权结构
 *
 * @author Meroc Chen 2018-01-30
 */
trait AuthTrait {

  /**
   * 账号密码验证
   *
   * @param string $acctName 账户名称
   * @param string $secret 账户密码
   * @param string $model 校验对象，不传默认使用当前类指向的对象
   *
   * @return mixed 账号密码错误返回false，否则返回true，若对象不存在返回 NULL
   */
  public function acctCheck($acctName, $secret) {
  
    /**
     * 查询账号
     */

    $inst = $this->findOne(array( $this->_acctName => $acctName));
  
    if ($inst) {

      /**
       * 账户存在，比较密文
       */
    
      if ($inst[$this->_secret] == $this->encodeSecret($secret)) {
      
        return true;
      
      } else {

        return false;

      }
    
    } else {

      /**
       * 账户不存在，返回空
       */
    
      return NULL;
    
    }
  
  }

  /**
   * 密文加密
   * 
   * @param string $secret
   *
   * @return string 
   */
  public function encodeSecret($secret) {
  
    return md5($secret);
  
  }

  /**
   * 创建鉴权密钥
   *
   * @param string $key
   *
   * @return string $secretKey
   */
  public function createAuthToken($key) {
  
    $secretKey = md5($account . time()) . md5(rand(100000, 999999));

    $this->update($key, array($this->_auth => $secretKey));

    return $secretKey;
  
  }

  /**
   * 创建 session
   *
   * @param string $account
   * @param string $module
   *
   * @return array
   */
  public function createSession($id, $module) {

    $auth = $this->findOne($id);

    if ($auth[$this->_auth]) {

      /**
       * 创建session时，销毁原来的session
       */
    
      RedisClient::remove($module, $auth[$this->_auth]);
    
    }

    $sessionTime = time();

    $auth['session_time'] = $sessionTime;

    $token = $this->createAuthToken($id);

    $auth[$this->_auth] = $token;

    RedisClient::set($module, $token, $auth);

    $userData = [
    
      "{$this->_acctName}" => empty($auth[$this->_acctName]) ? false: true,
    
      "{$this->_userName}" => $auth[$this->_userName],

      "unionid" => $auth['wx_unionid'] ? true : false,

      "pubopenid" => $auth['wx_pubopenid'] ? true : false,

      "session_time" => $sessionTime

    ];

    $session = [
    
      'token' => $token,

      'auth' => $userData
    
    ];

    return $session;
  
  }

  /**
   * 销毁 session
   *
   * @param string $account
   * @param string $module
   *
   * @return array
   */
  public function destroySession($account, $module) {
  
    $auth = $this->findOne(array($this->_acctName => $account));

    $this->update($auth['id'], array($this->_auth => ''));

    if ($auth[$this->_auth]) {

      RedisClient::remove($module, $auth[$this->_auth]);

    }
  
  }

  /**
   * 创建新对象，允许不使用密码
   *
   * @param string $account
   * @param string $password
   *
   * @return
   */
  public function createAuth($account, $password = null) {
  
    $new = [
    
      $this->_acctName => $account,

      'created_at' => date('Y-m-d H:i:s')
    
    ];

    if ($password) {

      $new[$this->_secret] = $this->encodeSecret($password);

    }
    
    return $this->add($new);
  
  }

  /**
   * 用微信小程序openId创建新对象
   *
   * @param string openId
   * @param string unionId
   *
   * @return
   */
  public function createAuthByWxMiniOpenId($openId, $unionId = NULL) {
  
    $new = [

      'wx_mnopenid' => $openId,

      'created_at' => date('Y-m-d H:i:s'),

      'reference' => 1

    ];

    if ($unionId) {
    
      $new['wx_unionid'] = $unionId;
    
    }

    return $this->add($new);
  
  }

  /**
   * 编辑密文
   *
   * @param string $account
   * @param string $secret
   *
   * @return
   */
  public function editSecret($account, $secret) {
  
    $auth = $this->findOne(array($this->_acctName => $account));

    $encodeSecret = $this->encodeSecret($secret);

    return $this->update($auth['id'], array($this->_secret => $encodeSecret));
  
  }

}
