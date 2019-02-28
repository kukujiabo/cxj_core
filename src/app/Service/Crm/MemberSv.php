<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Common\Traits\AuthTrait;
use App\Exception\LogException;
use App\Exception\ErrorCode;
use Core\Service\CurdSv;
use App\Library\RedisClient;
use App\Service\Components\Wechat\WechatAppSv;
use App\Service\CMS\LabelSv;

/**
 * 1.会员服务类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class MemberSv extends BaseService {

  use AuthTrait;

  use CurdSv;

  protected $_acctName = 'mobile';

  protected $_secret = 'password';

  protected $_auth = 'auth_token';

  protected $_userName = 'member_name';

  /**
   * 用户账号直接登录（需前置校验通过）
   *
   * @param string $account
   * @param string $password
   *
   * @return 
   */
  public function loginViaAccount($account) {
  
    $auth = $this->findOne(array($this->_acctName => $account));

    if (!$auth) {

      /**
       * 账号不存在
       */
    
      throw new LogException($this->_err->AEPTMSG, $this->_err->AEPTCODE);
    
    }

    return $this->createSession($auth['id'], 'member_auth'); 

  }

  /**
   * 查询会员列表
   *
   * @param array $params
   *
   * @return array list
   */
  public function listQuery($params) {
  
    $query = [];

    $cntQuery = [];

    $fields = $params['fields'] ? $params['fields'] : '*';

    $sql = "";

    if (!$params['focus_id']) {

      $sql = " SELECT {$fields} FROM member a WHERE 1=1 ";

    } else {

      $sql = " SELECT {$fields}, b.id as fid, IF(a.id = {$params['focus_id']}, 1, 0) AS is_self FROM member a LEFT JOIN member_favorite b ON a.id = b.focus_id AND b.member_id = {$params['focus_id']} WHERE 1=1 ";

    }

    if (isset($params['member_name'])) {

      $sql .= " AND a.member_name LIKE '%?%' ";

      array_push($query, $params['member_name']);

      $cntQuery['member_name'] = $params['member_name'];

    }

    if (isset($params['sex'])) {

      $sql .= " AND a.sex = ? ";

      array_push($query, $params['sex']);

      $cntQuery['sex'] = $params['sex'];

    }

    if (isset($params['resource_id'])) {

      $sql .= " AND a.resource_id = ? ";

      array_push($query, $params['resource_id']);

      $cntQuery['resource_id'] = $params['resource_id'];

    }

    if ($params['order']) {

      $sql .= " ORDER BY {$params['order']} ";

    }

    $offset = ($params['page'] - 1) * $params['page_size'];

    $sql .= " LIMIT ?, ? ";

    array_push($query, $offset);

    array_push($query, $params['page_size']);

    $cnt = $this->queryCount($cntQuery);

    $result = $this->modelInst()->queryRows($sql, $query);

    return [ 'list' => $result, 'total' => $cnt ];

  }

  /**
   * 用户账号密码登录
   *
   * @param string $account
   * @param string $password
   *
   * @return 
   */
  public function loginViaPassword($account, $password) {

    /**
     * 校验账号密码
     */
    $auth = $this->acctCheck($account, $password);
  
    if ($auth) {

      /**
       * 校验通过
       */
      $member = $this->findOne(array($this->_acctName => $account));

      return $this->createSession($member['id'], 'member_auth');

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

  /**
   * 用户注册
   *
   * @param string $account
   * @param string $password
   *
   * @return
   */
  public function register($account, $password = null) {

    if (empty($account)) {

      throw new LogException($this->_err->RGEPTACCTMSG, $this->_err->RGEPTACCTCODE);
    
    }
  
    return $this->createAuth($account, $password);
  
  }

  /**
   * 编辑用户信息
   *
   * @param int $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function editMember($id, $data) {

    if ($this->update($id, $data)) {

      $member = $this->findOne($id);

      if ($member[$this->_auth]) {
      
        RedisClient::set('member_auth', $member[$this->_auth], $member);

        $key = md5("member_detail_{$id}");

        RedisClient::set('member_info', $key, '');

      }

      return true;

    } else {
    
      return false;
    
    }
  
  }

  /**
   * 修改密码
   *
   * @param string $oldPassword
   * @param string $newPassword
   *
   * @return boolean true/false
   */
  public function updatePassword($memberId, $oldPassword, $newPassword) {

    $member = $this->findOne($memberId);

    if (!$member[$this->_secret]) {

      /**
       * 用户第一次设置密码
       */

      return $this->editSecret($member[$this->_acctName], $newPassword);
    
    } else {

      /**
       * 用户修改密码
       */
      if ($this->acctCheck($member[$this->_acctName], $oldPassword)) {
      
        return $this->editSecret($member[$this->_acctName], $newPassword);
      
      } else {

        /**
         * 旧密码输入错误，抛出异常
         */
      
        throw new LogException($this->_err->WOLDPASSMSG, $this->_err->WOLDPASSCODE);
      
      }
    
    }
  
  }

  /**
   * 判断账户名是否存在
   *
   * @param string $account
   *
   * @return boolean true/false
   */
  public function existAccount($account) {
  
    if ($this->findOne(array($this->_acctName => $account))) {
    
      return true;
    
    } else {
    
      return false;
    
    }
  
  }

  /**
   * 微信小程序登录
   * @desc 微信小程序登录
   *
   * @param string appName
   * @param string code
   *
   * @return 
   */
  public function wechatMiniLogin($appName, $code, $options, $scene, $deviceType, $deviceInfo, $ipAddress, $lat, $lng) {
  
    $wxApp = new WechatAppSv($appName);

    $wxInfo = $wxApp->getOpenId($code);

    if ($wxInfo->errcode) {
    
      return $wxInfo->errmsg;
    
    }

    if ($wxInfo->unionid) {

      $auth = $this->findOne([ 'wx_unionid' => $wxInfo->unionid ]);

    } else {
    
      $auth = $this->findOne([ 'wx_mnopenid' => $wxInfo->openid ]);
    
    }

    $mllSv = new MemberLoginLogSv();

    $op = json_decode($options, true);

    if ($auth) {
    
      $session = $this->createSession($auth['id'], 'member_auth'); 

      $session['session_key'] = $wxInfo->session_key;

      $mllSv->create($auth['id'], 1, 0, $op, $scene, $deviceType, $deviceInfo, $ipAddress, $lat, $lng);

      return $session;
    
    } else {
    
      $result = $this->createAuthByWxMiniOpenId($wxInfo->openid, $wxInfo->unionid);

      $userInfo = [];

      /**
       * 判断用户来源
       */

      if ($op['scene']) {

        $prefix = substr($op['scene'], 0, 3);

        $key = str_replace($prefix, '', $op['scene']);

        if ($prefix == 'shc') {

          $userInfo['share_code'] = $key;

          $userInfo['resource_type'] = 3;

        } elseif ($prefix == 'rid') {

          $userInfo['resource_id'] = $key;

          $userInfo['resource_type'] = 4;

        } elseif ($prefix == 'shp') {

          $userInfo['resource_id'] = $key;

          $userInfo['resource_type'] = 5;

        }

      } elseif ($op['share_code']) {

        $userInfo['share_code'] = $op['share_code'];

        $userInfo['resource_type'] = 2;

      } elseif ($op['sales_code']) {

        $sale = $this->findOne(['sales_code' => $op['sales_code']]);

        $userInfo['resource_id'] = $sale['id'];

      } else {

        $userInfo['resource_type'] = 1;

      }

      if ($userInfo['share_code']) {

        $shareAction = new ShareActionSv();

        $share = $shareAction->findOne([ 'share_code' => $op['share_code'] ]);

        $userInfo['resource_id'] = $share['member_id'];

        $userInfo['share_type'] = $share['type'];

      }

      if (!empty($userInfo)) {
      
        $this->update($result, $userInfo);
      
      }

      if ($result) {
      
        $session = $this->createSession($result, 'member_auth');

        $session['session_key'] = $wxInfo->session_key;

        $mllSv->create($result, 1, 1, $op, $scene, $deviceType, $deviceInfo, $ipAddress, $lat, $lng);

        return $session;
      
      }
    
    }
  
  }

  /**
   * 解密绑定手机号
   * @desc 解密绑定手机号
   *
   * @return string
   */
  public function bindEncryptedData($params) {

    $wxApp = new WechatAppSv($params['app_name']);
  
    $result = $wxApp->wechatDecryptedData($params['session_key'], $params['encryptedData'], $params['iv']);

    $this->update($params['member_id'], [ 'mobile' => $result->phoneNumber ]);

    return $result->phoneNumber;
  
  }

  /**
   * 查询用户数量统计数据
   * @desc 查询用户数量统计数据
   *
   * @return array data
   */
  public function countMemberData() {

    $d = date('Y-m-d');
  
    $total = $this->queryCount([]);  

    $today = $this->queryCount([ 'created_at' => "gt|{$d}" ]);

    return [ 'total' => $total, 'today' => $today ];
  
  }

  /**
   * 查询会员是否绑定手机号
   *
   */
  public function checkMemberPhone($data) {
  
    $member = $this->findOne($data['member_id']);

    return $member['mobile'] ? $member['mobile'] : false;
  
  }

  /**
   * 查询一段时间内注册的有效用户（授权微信信息）
   * @desc 查询一段时间内注册的用户数量
   *
   * @return 
   */
  public function countNewMember($start, $end) {

    $model = new \App\Model\Member();

    $sql = "select COUNT(1) AS new_cnt from member where created_at between ? and ? AND portrait IS NOT NULL";

    $params = [ $start, $end ];

    $result = $model->orm()->queryRows($sql, $params);

    return $result[0]['new_cnt'];

  }

  /**
   * 查询一段时间内活跃的用户数量（按登陆来算）
   * @desc 查询一段时间内活跃的用户数量（按登陆来算）
   *
   * @return int num
   */
  public function countActiveMember($start, $end) {

    $model = new \App\Model\MemberLoginLog();

    $sql = "select COUNT(distinct member_id) AS act_cnt from member_login_log where login_at between ? and ? ";

    $params = [ $start, $end ];

    $result = $model->orm()->queryRows($sql, $params);

    return $result[0]['act_cnt'];

  }

  /**
   * 查询绑定了手机号的用户数量
   * @desc 查询绑定了手机号的用户数量
   *
   * @return int num
   */
  public function countMobileBindMember() {

    $model = new \App\Model\Member();

    $sql = "select COUNT(1) AS bm_cnt FROM member WHERE mobile IS NOT NULL";

    $result = $model->orm()->queryRows($sql, $params);

    return $result[0]['bm_cnt'];

  }

  public function count($data) {

    $query = [];

    if (isset($data['resource_type'])) {

      $query['resource_type'] = $data['resource_type'];

    }
    if (isset($data['share_type'])) {

      $query['share_type'] = $data['share_type'];

    }
    if (isset($data['resource_id'])) {

      $query['resource_id'] = $data['resource_id'];

    }
    if (isset($data['sex'])) {

      $query['sex'] = $data['sex'];

    }

    return $this->queryCount($query);

  }

  public function getDetail($options) {

    $id = $options['id'];

    $key = md5("member_detail_{$id}");

    $detail = RedisClient::get('member_infos', $key);

    if ($detail && $detail->expire_at > time()) {

      return $detail;

    } else {

      $detail = $this->findOne($id);

      $mlSv = new MemberLabelSv();

      $mls = $mlSv->getAll([ 'member_id' => $id ]);

      $info = [

        'id' => $id,

        'member_name' => $detail['member_name'],

        'member_head' => $detail['portrait'],

        'sex' => $detail['sex'],

        'mobile' => $detail['mobile'],

        'city' => $detail['wx_city'],

        'province' => $detail['wx_province'],

        'favorite_num' => $detail['favorite_num'],

        'birth_date' => $detail['birth_date'],

        'signature' => $detail['signature'],

        'sales_person' => $detail['sales_person'],

        'sales_code' => $detail['sales_code'],

        'labels' => $mls

      ];

      RedisClient::set('member_infos', $key, $info);

      return $info;

    }

  }

}
