<?php
namespace App\Model;

/**
 * 会员
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-31
 */
class Member extends BaseModel {

  protected $_queryOptionRule = [
  
    'member_name' => 'like',

    'created_at' => 'range'
  
  ];

}
