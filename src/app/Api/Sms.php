<?php
namespace App\Api;

/**
 * 3.1 短信接口 
 */
class Sms extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'sendVerify' => [

				'mobile' => 'mobile|string|true||手机号'

			]

		]);

	}

	/**
   * 发送验证码
   * @发送验证码
   *
   * @return 
   */
	public function sendVerify() {

		return $this->dm->sendVerify($this->retriveRuleParams(__FUNCTION__));

	}

}