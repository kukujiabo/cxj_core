<?php
namespace App\Domain;

use App\Service\Crm\MemberSv;
use App\Service\Crm\MobileVerifyCodeSv;
use App\Service\Message\SmsSv;
use App\Service\Components\Wechat\WechatAppSv;
use App\Library\RedisClient;

/**
 * 会员
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-30
 */
class MemberDm {

  protected $_memberSv;

  public function __construct() {
  
    $this->_memberSv = new MemberSv();

    $this->_mbv = new MobileVerifyCodeSv();
  
  }

  /**
   * 会员注册
   *
   * @param string $mobile
   * @param string $memberName
   *
   * @return int $id
   */
  public function register($mobile, $memberName) {
  
    /**
     * 返回注册结果
     */
    $id = $this->_memberSv->register($mobile);

    if ($id) {

      $extData = array(
      
        'member_name' => $memberName,

        'member_identity' => \App\getRandomDigit(12)
      
      );
    
      $urs = $this->_memberSv->update($id, $extData);
    
    }

    return $id;

  }

  /**
   * 查询会员列表
   *
   */
  public function listQuery($params) {
  
    return $this->_memberSv->listQuery($params);
  
  }


  /**
   * 通过短信验证码登录
   *
   * @param string $mobile
   * @param string $code
   *
   * @return array $memberInfo
   */
  public function loginViaCode($mobile, $code) {
  
    /**
     * 校验验证码，失败会抛出异常
     */
    $this->_mbv->checkVerifyCode($mobile, $code);
    
    return $this->_memberSv->loginViaAccount($mobile);
  
  }

  /**
   * 账号密码登录
   *
   * @param string $mobile
   * @param string $password
   *
   * @return array $memberInfo
   */
  public function loginViaPassword($mobile, $password) {
  
    return $this->_memberSv->loginViaPassword($mobile, $password);
  
  }

  /**
   * 编辑用户信息
   *
   * @param array $params
   *
   * @return mixed 
   */
  public function editMember($params) {

    $id = $params['id'];

    $data = array();

    if (isset($params['member_name'])) {

      $data['member_name'] = $params['member_name'];
    
    }

    if (isset($params['member_identity'])) {

      $data['member_identity'] = $params['member_identity'];
    
    }

    if (isset($params['wx_city'])) {

      $data['wx_city'] = $params['wx_city'];
    
    }
    if (isset($params['wx_province'])) {

      $data['wx_province'] = $params['wx_province'];
    
    }
    if (isset($params['portrait'])) {

      $data['portrait'] = $params['portrait'];
    
    }
    if (isset($params['sex'])) {

      $data['sex'] = $params['sex'];
    
    }
    if (isset($params['encryptedData'])) {
    
      $wxAppSv = new WechatAppSv();

      $decryptedData = $wxAppSv->wechatDecryptedData($params['session_key'], $params['encryptedData'], $params['iv']);

      $data['wx_unionid'] = $decryptedData->unionId;
    
    }

    if (!empty($data)) {
  
      return $this->_memberSv->editMember($id, $data);

    } else {

      return false;

    }
  
  }

  public function updateMember($options) {

    $id = $options['id'];

    $updateData = [];

    if (isset($options['member_name'])) {

      $updateData['member_name'] = $options['member_name'];

    }
    if (isset($options['member_head'])) {

      $updateData['portrait'] = $options['member_head'];
      
    }
    if (isset($options['signature'])) {

      $updateData['signature'] = $options['signature'];
      
    }
    if (isset($options['birth_date'])) {

      $updateData['birth_date'] = $options['birth_date'];
      
    }
    if (isset($options['sex'])) {

      $updateData['sex'] = $options['sex'];
      
    }

    $result = $this->_memberSv->update($id, $updateData);

    if ($result) {

      // 更新完成后刷新缓存

      $key = md5("member_detail_{$id}");

      RedisClient::set('member_infos', $key, '');

    }

    return $result;

  }


  /**
   * 修改用户密码
   *
   * @param array $params
   *
   * @return mixed 
   */
  public function updatePassword($memberId, $oldPassword, $newPassword) {
  
    return $this->_memberSv->updatePassword($memberId, $oldPassword, $newPassword);
  
  } 

  /**
   * 查看账号是否存在
   *
   * @param string $account
   *
   * @return
   */
  public function existAccount($account) {
  
    return $this->_memberSv->existAccount($account);
  
  }

  /**
   * 微信小程序登录
   */
  public function wechatMiniLogin($appName, $code, $options, $scene) {
  
    return $this->_memberSv->wechatMiniLogin($appName, $code, $options, $scene, $deviceType, $deviceInfo, $ipAddress, $lat, $lng);
  
  }

  public function bindEncryptedData($params) {
  
    return $this->_memberSv->bindEncryptedData($params); 
  
  }

  public function countMemberData() {
  
    return $this->_memberSv->countMemberData();
  
  }

  public function checkMemberPhone($data) {
  
    return $this->_memberSv->checkMemberPhone($data);
  
  }

  public function getDetail($data) {

    return $this->_memberSv->getDetail($data);

  }

  public function indexAnalysisData() {

    $start = date('Y-m-d 00:00:00');

    $end = date('Y-m-d 23:59:59');

    $data = [

      'new_cnt' => $this->_memberSv->countNewMember($start, $end),

      'act_cnt' => $this->_memberSv->countActiveMember($start, $end),

      'bm_cnt' => $this->_memberSv->countMobileBindMember(),

      'mini_cnt' => $this->_memberSv->count([ 'resource_type' => 1 ]),

      'ucode_cnt' => $this->_memberSv->count([ 'resource_type' => 3 ]),

      'ushare_cnt' => $this->_memberSv->count([ 'resource_type' => 2 ]),

      'scode_cnt' => $this->_memberSv->count([ 'resource_type' => 4 ])

    ];

    return $data;

  }


}
