<?php
namespace App\Service;

use Core\Service\Service;
use App\Exception\ErrorCode;
use App\Exception\LogException;

/**
 * 服务基类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-09-19
 */
class BaseService extends Service {

  /**
   * 本类实例，仅在需要返回单例时赋值
   */
  protected static $self;

  protected $_err;

  public function __construct() {

    parent::__construct();

    $this->_err = new ErrorCode();
  
  }

  /**
   * 静态调用时获取本类实例
   *
   * @param boolean $singleton
   *
   * @return class $self
   */
  protected static function inst($className, $args = array()) {

    $reflection = new \ReflectionClass($className);

    return $reflection->newInstanceArgs($args); 

  }

  /**
   * 读取请求token
   */
  protected function getSessionToken() {

    $token = \App\getHeader('X-TOKEN');
  
  }

  /**
   * 抛出指定的异常
   */
  protected function throwError($msg, $code) {
  
    throw new LogException($msg, $code); 
  
  }

}
