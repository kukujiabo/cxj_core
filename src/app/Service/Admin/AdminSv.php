<?php
namespace App\Service\Admin;

use App\Service\BaseService;
use App\Common\Traits\AuthTrait;
use App\Exception\LogException;
use App\Exception\ErrorCode;
use Core\Service\CurdSv;
use App\Library\RedisClient;

/**
 * 管理员服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-08
 */
class AdminSv extends BaseService {

  use CurdSv;

  use AuthTrait;

  protected $_acctName = 'account';

  protected $_secret = 'password';

  protected $_auth = 'auth_token';


  /**
   * 管理员登录
   *
   * @param string $account
   * @param string $password
   *
   * @return 
   */
  public function login($account, $password) {

    /**
     * 校验账号密码
     */
    $auth = $this->acctCheck($account, $password);
  
    if ($auth) {

      /**
       * 校验通过
       */
      $admin = $this->findOne(array($this->_acctName => $account));

      $sessionData = $this->createSession($admin['id'], 'admin_auth');

      /**
       * 返回访问令牌
       */

      return $sessionData['token'];

    } elseif ($auth === FALSE) {

      /**
       * 账号密码错误
       */
    
      throw new LogException($this->_err->APMISMSG, $this->_err->APMISCODE);
    
    } elseif ($auth === NULL) {

      /**
       * 账号不存在
       */
    
      throw new LogException($this->_err->AEPTMSG, $this->_err->AEPTCODE);
    
    }
  
  }

}
