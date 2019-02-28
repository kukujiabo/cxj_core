<?php
namespace App\Domain;

use App\Service\CMS\LabelSv;

class LabelDm {

	protected $_labSv;

	public function __construct() {

		$this->_labSv = new LabelSv();

	}
	
	public function getAll($options) {

		return $this->_labSv->getAll($options);

	}

}