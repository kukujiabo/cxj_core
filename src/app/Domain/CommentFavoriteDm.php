<?php
namespace App\Domain;

use App\Service\CMS\CommentFavoriteSv;

class CommentFavoriteDm {
	
  protected $_cfsv;

  public function __construct() {
  
    $this->_cfsv = new CommentFavoriteSv();
  
  }

	public function create($options) {

		return $this->_cfsv->create($options);

	}
	
	public function cancel($options) {

		return $this->_cfsv->cancel($options);

	}

	public function getList($options) {

		return $this->_cfsv->getList($options);

	}

}