<?php
namespace App\Api;

/**
 * 0.1 管理员接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-02
 */
class Admin extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'login' => [
      
        'account' => 'account|string|true||账号',

        'password' => 'password|string|true||密码'
      
      ],

      'sessionAdminInfo' => [

        'id' => 'id|int|true||管理员id'
      
      ]
    
    ]);
  
  }

  /**
   * 管理员登录
   * @desc 管理员登录
   *
   * @return token
   */
  public function login() {

    return $this->dm->login($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 当前会话管理员信息
   * @desc 当前会话管理员信息
   *
   * @return array info
   */
  public function sessionAdminInfo() {
  
    return $this->dm->sessionAdminInfo($this->retriveRuleParams(__FUNCTION__)); 

  }

}
