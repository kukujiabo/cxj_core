<?php
namespace App\Model;

/**
 * [模型层] 门店
 *
 * @author Meroc Chen <398515393@qq.com> 2018-06-05
 */
class Shop extends BaseModel {

  protected $_queryOptionsRule = [

    'id' => 'in',
  
    'created_at' => 'range',

    'shop_name' => 'like'
  
  ];

}
