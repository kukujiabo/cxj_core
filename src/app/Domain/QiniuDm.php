<?php
namespace App\Domain;

use App\Service\Components\Qiniu\QiniuSv;

/**
 * 七牛云存储
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-06
 */
class QiniuDm {

  protected $_qsv;

  public function __construct() {
  
    $this->_qsv = new QiniuSv();
  
  }

  /**
   * 获取访问令牌
   *
   */
  public function getAccessToken($bucket) {
  
    return $this->_qsv->getAccessToken($bucket);
  
  }

  /**
   * 编辑配置信息
   */
  public function editConfig($accessKey, $accessSecret) {
  
    $res1 = $this->_qsv->editKey($accessKey);

    $res2 = $this->_qsv->editSecret($accessSecret);

    return $res1 || $res2;
  
  }


}
