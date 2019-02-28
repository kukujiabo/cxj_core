<?php
namespace App\Domain;

use App\Service\CMS\PostFavoriteSv;

class PostFavoriteDm {

  protected $_pfsv;

  public function __construct() {

  	$this->_pfsv = new PostFavoriteSv();

  }
	
	public function create($options) {

		return $this->_pfsv->create($options);

	}

	public function getList($options) {

		return $this->_pfsv->getList($options);
		
	}

	public function cancel($options) {

		return $this->_pfsv->cancel($options);

	}

}