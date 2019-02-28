<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 会员反馈
 *
 * @author Meroc Chen
 */
class MemberAdviseSv extends BaseService {

  use CurdSv;

  /**
   * 新增会员反馈
   *
   * @param array data
   *
   * @return int id
   */
  public function create($data) {
  
    $newAdvise = [
    
      'member_id' => $data['member_id'],
      'advise' => $data['advise'],
      'created_at' => date('Y-m-d H:i:s')
    
    ];

    return $this->add($newAdvise);
  
  }

  /**
   * 查询反馈列表
   *
   * @param array data
   *
   * @return array list
   */
  public function listQuery($data) {
  
    $vmai = new VMemberAdviseInfoSv();

    $query = [];

    if (isset($data['member_name'])) {
    
      $query['member_name'] = $data['member_name'];
    
    }
    if (isset($data['sex'])) {
    
      $query['sex'] = $data['sex'];
    
    }
  
    return $vmai->queryList($query, $data['fields'], $data['order'], $data['page'], $data['page_size']);

  }

}
