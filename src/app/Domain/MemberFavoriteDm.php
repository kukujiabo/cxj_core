<?php
namespace App\Domain;

use App\Service\Crm\MemberFavoriteSv;

class MemberFavoriteDm {
	
  protected $_mfSv;

  public function __construct() {
  
    $this->_mfSv = new MemberFavoriteSv();
  
  }


	public function create($options) {

		return $this->_mfSv->create($options);

	}

	public function getList($options) {

		return $this->_mfSv->getList($options);

	}

	public function cancel($options) {

		return $this->_mfSv->cancel($options);

	}

}