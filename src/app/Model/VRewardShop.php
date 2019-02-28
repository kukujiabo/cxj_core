<?php
namespace App\Model;

/**
 * 赠品关联店铺视图模型
 *
 * @author Meroc Chen <398515393@qq.com> 2018-06-07
 */
class VRewardShop extends BaseModel {

  protected $_queryOptionRule = [
  
    'end_time' => 'range',

    'shop_id' => 'in'
  
  ];



}
