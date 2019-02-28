<?php
namespace App\Model;

class VShopList extends BaseModel {

  protected $_queryOptionRule = [

    'id' => 'in',
  
    'created_at' => 'range',

    'shop_name' => 'like'
  
  ];


}
