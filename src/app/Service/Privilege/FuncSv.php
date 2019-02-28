<?php
namespace App\Service\Privilege;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 功能函数服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-08
 */
class FuncSv extends BaseService {

  use CurdSv;

  /**
   * 添加功能函数
   *
   * @param int $svId
   * @param string $name
   * @param string title
   * @param string $description
   * @param int $state
   * @param string $pic
   * @param int $dev
   * @param int $auth
   *
   * @return int $id
   */
  public function addFunction($svId, $name, $title, $description='', $state=1, $pic='', $dev=0, $auth=1) {
  
    $newFunction = [
    
      'service_id' => $svId,

      'func_name' => $name,

      'func_title' => $title,

      'is_dev' => $dev,

      'in_auth' => $auth,

      'state' => $state,

      'pic' => $pic,

      'description' => $description,

      'created_at' => date('Y-m-d H:i:s'),
    
    ];  

    return $this->add($newFunction);
  
  }

}
