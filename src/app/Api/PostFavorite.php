<?php
namespace App\Api;

/**
 * 6.4 帖子点赞接口
 */
class PostFavorite extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',

				'post_id' => 'post_id|int|true||帖子id'

			],


			'cancel' => [

				'member_id' => 'member_id|int|true||会员id',

				'post_id' => 'post_id|int|true||帖子id'

			],

			'getList' => [

				'member_id' => 'member_id|int|false||会员id',

				'post_id' => 'post_id|int|false||帖子id',

				'order' => 'order|string|false||排序',

				'page' => 'page|int|false|1|页码',

				'page_size' => 'page_size|int|false|12|每页条数'

			]

		]);

	}

	/**
	 * 新增点赞
	 * @desc 新增点赞
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 取消点赞
	 * @desc 取消点赞
	 *
	 * @return int num
	 */
	public function cancel() {

		return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 获取点赞列表
	 * @desc 获取点赞列表
	 *
	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

}