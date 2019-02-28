<?php
namespace App\Api;

/**
 * 6.3 帖子接口
 */
class Post extends BaseApi {
	
	public function getRules() {

		return $this->rules([

			'create' => [

				'member_id' => 'member_id|int|true||会员id',
				'module' => 'module|int|true||所属模块',
				'object_id' => 'object_id|int|true||评论对象id',
				'content' => 'content|string|true||评论内容',
				'status' => 'status|int|true||评论状态',
				'imgs' => 'imgs|string|false||评论图片'

			],

			'getList' => [

				'module' => 'module|int|false||所属模块',
				'topic_info' => 'topic_info|int|false||是否需要话题内容',
				'object_id' => 'object_id|int|false||评论对象id',
				'favorite_member_id' => 'favorite_member_id|int|false||点赞人id',
				'status' => 'status|int|false||评论状态',
				'forbid' => 'forbid|int|false||是否禁止',
				'fields' => 'fields|string|false||查询字段	',
				'order' => 'order|string|false||排序',
				'page' => 'page|int|false|1|页码',
				'page_size' => 'page_size|int|false|10|每页条数'

			],

			'getDetail' => [

				'id' => 'id|int|true||查询详情'

			],

			'remove' => [

				'id' => 'id|int|true||查询详情'

			]

		]);

	}

	/**
	 * 新增帖子
	 * @desc 新增帖子
   *
	 * @return int id
	 */
	public function create() {

		return $this->dm->create($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 帖子列表
	 * @desc 帖子列表
   *
	 * @return array list
	 */
	public function getList() {

		return $this->dm->getList($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 帖子详情
	 * @desc 帖子详情
   *
	 * @return array data
	 */
	public function getDetail() {

		return $this->dm->getDetail($this->retriveRuleParams(__FUNCTION__));

	}

	/**
	 * 删除帖子
	 * @desc 删除帖子
   *
	 * @return int num
	 */
	public function remove() {

		return $this->dm->remove($this->retriveRuleParams(__FUNCTION__));

	}

}