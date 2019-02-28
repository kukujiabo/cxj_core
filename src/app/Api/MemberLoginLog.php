<?php
namespace App\Api;

/**
 * 1.3 用户登录日志接口
 *
 */
class MemberLoginLog extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'getInfoList' => [

				'member_name' => 'member_name|string|false||会员昵称',
				'fields' => 'fields|string|false||字段',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|20|每页条数'

			]

		]);

	}

	/**
	 * 查询日志列表
	 * @desc 查询日志列表
	 *
	 * @return array list
	 */
	public function getInfoList() {

		return $this->dm->getInfoList($this->retriveRuleParams(__FUNCTION__));

	}

}