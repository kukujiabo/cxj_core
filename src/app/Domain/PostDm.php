<?php
namespace App\Domain;

use App\Service\CMS\PostSv;

class PostDm {

  protected $_psv;

  public function __construct() {
  
    $this->_psv = new PostSv();
  
  }
	
	public function create($options) {

		return $this->_psv->create($options);

	}

	public function getList($options) {

		return $this->_psv->getList($options);

	}

	public function getDetail($options) {

		return $this->_psv->getDetail($options);

	}

	public function remove($options) {

		return $this->_psv->remove($options);

	}

}