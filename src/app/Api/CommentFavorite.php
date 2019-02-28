<?php
namespace App\Api;

/**
 * 6.2 评论点赞接口
 */
class CommentFavorite extends BaseApi {
		
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',
				'comment_id' => 'comment_id|int|true||评论id'

			],

			'cancel' => [

				'member_id' => 'member_id|int|true||会员id',
				'comment_id' => 'comment_id|int|true||评论id'

			],

			'getList' => [

				'member_id' => 'member_id|int|false||会员id',
				'comment_id' => 'comment_id|int|false||评论id',
				'fields' => 'fields|string|false||字段',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false||每页条数'

			]

		]);

	}

	/**
	 * 新增评论点赞
	 * @desc 新增评论点赞
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 取消评论点赞
	 * @desc 取消评论点赞
	 *
	 * @return int id
	 */
	public function cancel() {

		return $this->dm->cancel($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 获取点赞评论
	 * @desc 获取点赞评论
	 *
	 * @return int id
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

}