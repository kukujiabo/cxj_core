<?php
namespace App\Domain;

use App\Service\CMS\TopicSv;

class TopicDm {

	protected $_tpsv;

	public function __construct() {

		return $this->_tpsv = new TopicSv();

	}
	
	public function create($data) {

		return $this->_tpsv->create($data);

	}

	public function edit($data) {

		return $this->_tpsv->edit($data);

	}

	public function remove($data) {

		return $this->_tpsv->remove($data['id']);

	}

	public function getList($data) {

		return $this->_tpsv->getList($data);

	}

	public function getDetail($data) {

		return $this->_tpsv->getDetail($data);

	}

}