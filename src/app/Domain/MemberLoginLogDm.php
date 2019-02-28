<?php
namespace App\Domain;

use App\Service\Crm\MemberLoginLogSv;

class MemberLoginLogDm {

  protected $_mlsv;

  public function __construct() {
  
    $this->_mlsv = new MemberLoginLogSv();
  
  }
	
	public function getInfoList($data) {

		return $this->_mlsv->getInfoList($data);

	}

}