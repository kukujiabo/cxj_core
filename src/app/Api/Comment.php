<?php
namespace App\Api;

/**
 * 6.1 评论接口
 */
class Comment extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',
				'module' => 'module|int|true||所属模块',
				'reply_to' => 'reply_to|int|true||回复评论',
				'object_id' => 'object_id|int|true||评论对象id',
				'root_id' => 'root_id|int|false||原始评论id',
				'content' => 'content|string|true||评论内容',
				'status' => 'status|int|false||评论状态',
				'imgs' => 'imgs|string|false||评论图片'

			],

			'getList' => [

				'member_id' => 'member_id|int|false||会员id',
				'self_id' => 'self_id|int|false||访问会员id',
				'module' => 'module|int|false||所属模块',
				'object_id' => 'object_id|int|false||评论对象id',
				'favorite_member_id' => 'favorite_member_id|int|false||点赞人id',
				'root_id' => 'root_id|int|false||原始评论id',
				'status' => 'status|int|false||评论状态',
				'forbid' => 'forbid|int|false||是否禁止',
				'fields' => 'fields|string|false||查询字段	',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|10|每页条数'

			],

			'remove' => [

				'id' => 'id|int|true||删除id'

			],

			'getDetail' => [

				'id' => 'id|int|true||删除id'

			]

		]);

	}

	/**
	 * 新增评论
	 * @desc 新增评论
	 *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 评论列表
	 * @desc 评论列表
	 *
	 * @return array data
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 删除评论
	 * @desc 删除评论
	 *
	 * @return int NUM
	 */
	public function remove() {

		return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 查询评论详情
	 * @desc 查询评论详情
	 *
	 * @return int NUM
	 */
	public function getDetail() {

		return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));

	}

}