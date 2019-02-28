<?php
namespace App\Domain;

use App\Service\Crm\MiniUserFormIdsSv;

class MiniUserFormIdsDm {

  protected $_mufsv;

  public function __construct() {
  
    $this->_mufsv = new MiniUserFormIdsSv();
  
  }
	
	public function create($options) {

		return $this->_mufsv->create($options);

	}

	public function getDetail($options) {

		return $this->_mufsv->getDetail($options);

	}

	public function getLastOne($options) {

		return $this->_mufsv->getLastOne($options);

	}

}