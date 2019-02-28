<?php
namespace App\Model;

/**
 * 【模型层】会员赠品
 *
 * @author Meroc Chen <398515393@qq.com> 2018-06-07
 */
class MemberReward extends BaseModel {

  protected $_queryOptionRule = [
  
    'id' => 'in',

    'checked_at' => 'range',

    'end_time' => 'range'
  
  ];

}
