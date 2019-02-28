<?php
namespace App\Api;

/**
 * 7.1 粉丝接口
 */
class Fans extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [
				'member_id' => 'member_id|int|true||会员id',
				'focus_id' => 'focus_id|int|true||关注人id'
			],

			'getList' => [
				'member_id' => 'member_id|int|false||会员id',
				'focus_id' => 'focus_id|int|false||关注人id',
				'fields' => 'fields|string|false||字段',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|10|每页条数'
			]

		]);

	}

	/**
	 * 新增关注
	 * @desc 新增关注
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 查询列表
	 * @desc 查询列表
	 *
	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

}