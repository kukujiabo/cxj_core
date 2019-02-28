<?php
namespace App\Api;

/**
 * 1.5 用户小程序formid接口
 */
class MiniUserFormIds extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||用户id',

				'form_id' => 'form_id|string|true||form id',

				'get_type' => 'get_type|int|true||获取方式'

			],

			'getList' => [


			],

			'getLastOne' => [


			]

		]);

	}

	/**
	 * 新增 formId
	 * @desc 新增 formId
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 查询可用 formId
	 * @desc 查询可用 formId
	 *
	 * @return array data
	 */
	public function getLastOne() {

		return $this->dm->getLastOne($this->retriveRuleParams(__FUNCTION__));

	}

}