<?php
namespace App\Service\Privilege;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 系统服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-08
 */
class ServiceSv extends BaseService {

  use CurdSv;

  /**
   * 添加服务
   *
   * @param string $name
   * @param string $title
   * @param string $desc
   * @param string $state
   * @param string $auth
   * @param string $dev
   * @param string $pic
   *
   * @return int $id
   */
  public function addService($name, $title, $desc='', $state=1, $auth=1, $dev=0, $pic = '') {
  
    $newServie = [

      'service_name' => $name,

      'service_title' => $title,

      'description' => $desc,

      'state' => $state,

      'pic' => $pic,

      'is_dev' => $dev,

      'in_auth' => $auth

      'created_at' => date('Y-m-d H:i:s')

    ];

    return $this->add($newService);
  
  }


}
