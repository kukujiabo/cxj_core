<?php
namespace App\Api;

/**
 * 5.1 话题接口
 *
 */
class Topic extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',
				'title' => 'title|string|true||标题',
				'content' => 'content|string|true||内容',
				'cover' => 'cover|string|true||封面',
				'status' => 'status|int|true||状态'

			],

			'edit' => [

				'id' => 'id|int|true||话题id',
				'title' => 'title|string|false||标题',
				'content' => 'content|string|false||内容',
				'cover' => 'cover|string|false||封面',
				'status' => 'status|int|false||状态'

			],

			'getDetail' => [

				'id' => 'id|int|true||话题id',
				'favorite_member_id' => 'favorite_member_id|int|false||查询用户id'

			],

			'remove' => [

				'id' => 'id|int|true||话题id'

			],

			'getList' => [

				'member_id' => 'member_id|int|false||会员id',
				'title' => 'title|string|false||标题',
				'content' => 'content|string|false||内容',
				'fields' => 'fields|string|false||字段',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|10|每页条数'	

			]

		]);

	}

	/**
	 * 新增话题
	 * @desc 新增话题
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 新增话题
	 * @desc 新增话题
	 *
	 * @return int id
	 */
	public function edit() {

		return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 删除话题
	 * @desc 删除话题
	 *
	 * @return int id
	 */
	public function remove() {

		return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 话题详情
	 * @desc 话题详情
	 *
	 * @return array data
	 */
	public function getDetail() {

		return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 查询话题列表
	 * @desc 查询话题列表
	 *
	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

}