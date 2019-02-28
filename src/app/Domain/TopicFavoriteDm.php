<?php
namespace App\Domain;

use App\Service\CMS\TopicFavoriteSv;

class TopicFavoriteDm {

	protected $_tpsv;
	
	public function __construct() {

		$this->_tpsv = new TopicFavoriteSv();

	}

	public function create($options) {

		return $this->_tpsv->create($options);

	}

	public function getList($options) {

		return $this->_tpsv->getList($options);

	}

	public function cancel($options) {

		return $this->_tpsv->cancel($options);

	}

}