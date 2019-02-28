<?php
namespace App\Api;

/**
 * 1.1 会员接口
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-30
 */
class Member extends BaseApi {

  public function getRules() {
  
    return $this->rules([
    
      'register' => [
      
        'mobile' => 'mobile|string|true||会员手机号',

        'member_name' => 'member_name|string|true||会员名称'
      
      ],

      'listQuery' => [
      
        'focus_id' => 'focus_id|int|false||关注人id',
        'member_id' => 'member_id|int|false||会员id',
        'member_name' => 'member_name|string|false||会员名称',
        'sex' => 'sex|string|false||会员性别',
        'order' => 'order|string|false||排序',
        'fields' => 'fields|string|false||查询字段',
        'page' => 'page|int|false|1|页码',
        'page_size' => 'page_size|int|false|30|每页条数'
      
      ],

      'loginViaCode' => [
      
        'mobile' => 'mobile|string|true||会员手机号',

        'code' => 'code|string|true||验证码'
      
      ],

      'loginViaPassword' => [
      
        'mobile' => 'mobile|string|true||会员手机号',

        'password' => 'password|string|true||验证码'
      
      ],

      'getDetail' => [

        'id' => 'id|int|true||会员id' 

      ],

      'editMember' => [
      
        'id' => 'id|int|true||用户表序号',

        'member_name' => 'member_name|string|false||用户昵称',

        'wx_city' => 'wx_city|string|false||用户城市',

        'wx_province' => 'wx_province|string|false||用户省份',

        'portrait' => 'portrait|string|false||用户头像',
      
        'member_identity' => 'member_identity|string|false||用户 ID',

        'sex' => 'sex|int|false||性别',

        'iv' => 'iv|string|false||密钥',
        
        'session_key' => 'session_key|string|false||会话id',

        'encryptedData' => 'encryptedData|string|false||加密信息'
      
      ],

      'updateMember' => [

        'id' => 'id|int|true||用户表序号',

        'member_name' => 'member_name|string|false||会员名称',

        'member_head' => 'member_head|string|false||会员头像',

        'birth_date' => 'birth_date|string|false||会员标签',

        'signature' => 'signature|string|false||会员签名',

        'sex' => 'sex|int|false||会员性别'

      ],

      'updatePassword' => [

        'member_id' => 'member_id|int|false||用户id',
      
        'old_password' => 'old_password|string|false||旧密码',

        'new_password' => 'new_password|string|true||新密码',

        'code' => 'code|string|true||验证码'
      
      ],

      'existAccount' => [
      
        'account' => 'account|string|true||账号'
      
      ],

      'wechatMiniLogin' => [

        'app_name' => 'app_name|string|true||微信应用名称',
      
        'code' => 'code|string|true||微信code',

        'scene' => 'scene|int|false||小程序场景值',

        'options' => 'options|string|false||登录附带参数',

        'device_type' => 'device_type|string|false||设备类型',

        'device_info' => 'device|string|false||设备信息',

        'ip_address' => 'ip_address|string|false||ip地址',

        'lat' => 'lat|string|false||纬度',

        'lng' => 'lng|string|false||经度'
 
      ],

      'bindEncryptedData' => [

        'app_name' => 'app_name|string|true||微信应用名称',

        'member_id' => 'member_id|int|true||会员id',

        'encryptedData' => 'encryptedData|string|true||加密数据',

        'iv' => 'iv|string|true||解密密钥',

        'session_key' => 'session_key|string|true||会话密钥'
      
      ],

      'checkMemberPhone' => [
      
        'member_id' => 'member_id|int|true||会员id',
      
      ],

      'indexAnalysisData' => [



      ],

      'countMemberData' => [
      
      
      ]
    
    ]);
  
  }

  /**
   * 用户注册接口
   * @desc 用户注册接口
   *
   * @param 
   * @param
   */
  public function register() {

    $params = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->register($params['mobile'], $params['member_name']);
  
  }

  /**
   * 查询会员列表
   * @desc 查询会员列表
   *
   * @return array list
   */
  public function listQuery() {
  
    return $this->dm->listQuery($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 用户手机验证码登录
   * @desc 用户手机验证码登录
   *
   * @return int num
   */
  public function loginViaCode() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->loginViaCode($params['mobile'], $params['code']);
  
  }

  /**
   * 用户账号密码登录
   * @desc 用户账号密码登录接口
   *
   * @return int num
   */
  public function loginViaPassword() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->loginViaPassword($params['mobile'], $params['password']);
  
  }

  /**
   * 编辑用户信息
   * @desc 编辑用户信息
   *
   * @return int num
   */
  public function editMember() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->editMember($params);

  }

  /**
   * 会员修改手机号
   * @desc 会员修改手机号
   *
   * @return boolean true/false
   */
  public function updatePassword() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->updatePassword($params['member_id'], $params['old_password'], $params['new_password']);
  
  }

  /**
   * 检查账号是否存在
   * @desc 检查账号是否存在
   *
   * @return boolean true/false
   */
  public function existAccount() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);
  
    return $this->dm->existAccount($params['account']);
  
  }

  /**
   * 微信小程序登录
   * @desc 微信小程序登录
   *
   * @return 
   */
  public function wechatMiniLogin() {
  
    $params = $this->retriveRuleParams(__FUNCTION__);

    return $this->dm->wechatMiniLogin($params['app_name'], $params['code'], $params['options'], $params['scene'], $params['device_type'], $params['device_info'], $params['ip_address'], $params['lat'], $params['lng']);

  }

  /**
   * 绑定加密手机号
   * @desc 绑定加密手机号
   *
   * @return string phone
   */ 
  public function bindEncryptedData() {

    return $this->dm->bindEncryptedData($this->retriveRuleParams(__FUNCTION__));
  
  }

  /**
   * 用户数量统计数据接口
   * @desc 用户数量统计数据接口
   *
   * @return array data
   */
  public function countMemberData() {
  
    return $this->dm->countMemberData($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 检验会员是否绑定手机号
   * @desc 检验会员是否绑定手机号
   *
   * @return mixed string
   */
  public function checkMemberPhone() {
  
    return $this->dm->checkMemberPhone($this->retriveRuleParams(__FUNCTION__)); 
  
  }

  /**
   * 查询会员资料详情
   * @desc 查询会员资料详情
   *
   * @return mixed string
   */ 
  public function getDetail() {

    return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));

  }

  /**
   * 首页统计数据接口
   * @desc 首页统计数据接口
   *
   * @return array data
   */
  public function indexAnalysisData() {

    return $this->dm->indexAnalysisData();

  }

  /**
   * 会员修改信息
   * @desc 会员修改信息
   *
   * @return array data
   */
  public function updateMember() {

    return $this->dm->updateMember($this->retriveRuleParams(__FUNCTION__));

  }

}
