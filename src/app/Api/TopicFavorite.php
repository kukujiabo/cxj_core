<?php
namespace App\Api;

/**
 * 5.2 话题关注接口
 *
 */
class TopicFavorite extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',
				'topic_id' => 'topic_id|int|true||话题id',
				'author_id' => 'author_id|int|true||作者id'

			],

			'cancel' => [

				'member_id' => 'member_id|int|true||会员id',
				'topic_id' => 'topic_id|int|true||话题id'		

			],

			'getList' => [

				'member_id' => 'member_id|int|false||会员id',
				'author_id' => 'author_id|int|false||发布者id',
				'topic_id' => 'topic_id|int|false||话题id',
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
	 * 查询关注列表
	 * @desc 查询关注列表
 	 *
 	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 取消关注
	 * @desc 取消关注
	 *
	 * @return int num
	 */
	public function cancel() {

		return $this->dm->cancel($this->retriveRuleParams(__FUNCTION__));

	}

}