<?php
namespace App\Domain;

use App\Service\Crm\FansSv;

class FansDm {

	protected $_fsSv;

	public function __construct() {

		$this->_fsSv = new FansSv();

	}
	
	public function create($options) {

		return $this->_fsSv->create($options);

	}

	public function getList($options) {

		return $this->_fsSv->getList($options);

	}

}