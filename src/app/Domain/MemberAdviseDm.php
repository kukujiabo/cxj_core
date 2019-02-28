<?php
namespace App\Domain;

use App\Service\Crm\MemberAdviseSv;

class MemberAdviseDm {

  protected $_masv;

  public function __construct() {
  
    $this->_masv = new MemberAdviseSv();
  
  }

  public function create($data) {
  
    return $this->_masv->create($data);
  
  }

  public function listQuery($data) {
  
    return $this->_masv->listQuery($data);
  
  }

}
