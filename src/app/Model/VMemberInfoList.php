<?php
namespace App\Model;

class VMemberInfoList extends BaseModel {

  protected $_queryOptionRule = [
  
    'member_name' => 'like',

    'created_at' => 'range'
  
  ];


}
