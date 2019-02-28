<?php
namespace App\Api;

/**
 * 8.2 会员个人标签接口
 */
class MemberLabel extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'batchCreate' => [

				'member_id' => 'member_id|int|true||会员id',

				'label_ids' => 'label_ids|string|true|标签id'

			],

			'getAll' => [

				'member_id' => 'member_id|int|false||会员id',

				'label_id' => 'label_id|int|false||标签id'

			]

		]);

	}

	/**
	 * 新增个人标签
	 * @desc 新增个人标签
	 *
	 * @return int num
	 */
	public function batchCreate() {

		return $this->dm->batchCreate($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 查询全部标签
	 * @desc 查询全部标签
	 *
	 * @return array data
	 */
	public function getAll() {

		return $this->dm->getAll($this->retriveRuleParams(__FUNCTION__));

	}

}