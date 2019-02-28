<?php
namespace App\Api;

/**
 * 1.4 用户关注接口
 */
class MemberFavorite extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'focus_id' => 'focus_id|int|true||被关注人id',
				'member_id' => 'member_id|int|true||会员id'

			],

			'cancel' => [

				'focus_id' => 'focus_id|int|true||被关注人id',
				'member_id' => 'member_id|int|true||会员id'

			],

			'getList' => [

				'focus_id' => 'focus_id|int|true||被关注人id',
				'member_id' => 'member_id|int|true||会员id',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|20|每页条数' 

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
	 * 取消关注
	 * @desc 取消关注
	 *
	 * @return int id
	 */
	public function cancel() {

		return $this->dm->cancel($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 获取关注列表
	 * @desc 获取关注列表
	 *
	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

}