<?php
namespace App\Domain;

use App\Service\Crm\MemberLabelSv;

class MemberLabelDm {

	protected $_mlsv;

	public function __construct() {

		$this->_mlsv = new MemberLabelSv();

	}
	
	public function batchCreate($options) {

		return $this->_mlsv->batchCreate($options);

	}

	public function getAll($options) {

		return $this->_mlsv->getAll($options);

	}

}