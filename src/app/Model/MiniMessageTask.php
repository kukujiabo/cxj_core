<?php
namespace App\Model;

class MiniMessageTask extends BaseModel {
	
  protected $_queryOptionRule = [
  
    'id' => 'in',

    'send_time' => 'range'
    
  ];
	
}