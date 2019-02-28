<?php
namespace App\Domain;

use App\Service\Message\SmsSv;

class SmsDm {

	protected $_smsv;

	public function __construct() {

		$this->_smsv = new SmsSv();

	}

	public function sendVerify($data) {

		return $this->_smsv->sendVerify($data['mobile']);

	}

}