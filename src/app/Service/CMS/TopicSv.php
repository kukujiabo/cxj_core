<?php
namespace App\Service\CMS;

use App\Service\Crm\MemberSv;
use App\Service\Crm\MemberFavoriteSv;
use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Library\RedisClient;

class TopicSv extends BaseService {
	
	use CurdSv;

	/**
	 * 新建话题
	 *
	 * @param array data
   *
 	 * @return int id
	 */
	public function create($data) {

		$newData = [

			'member_id' => $data['member_id'],
			'title' => $data['title'],
			'content' => $data['content'],
			'cover' => $data['cover'],
			'status' => 1,
			'created_at' => date('Y-m-d H:i:s')

		];

		return $this->add($newData);

	}

	/**
	 * 编辑话题
	 *
	 * @param array data
   *
 	 * @return int id
	 */
	public function edit($options) {

		$id = $options['id'];

		$updateData = [];

		if ($options['title']) {

			$updateData['title'] = $options['title'];

		}
		if ($options['content']) {

			$updateData['content'] = $options['content'];

		}
		if ($options['cover']) {

			$updateData['cover'] = $options['cover'];
			
		}
		if ($options['status']) {

			$updateData['status'] = $options['status'];
			
		}

		$num = $this->update($id, $updateData);

		$key = md5("nc_topic_detail_{$id}");

		RedisClient::set('nc_topic_detail', $key, '');

		return $num;

	}

	/**
	 * 查询话题列表
	 *
	 * @param array data
   *
 	 * @return int id
	 */
	public function getList($options) {

		$query = [];

		$fieldArr = [
			"id" => "a.id as id",
			"member_id" => "a.member_id as member_id",
			"title" => "a.title as title",
			"content" => "a.content as content",
			"cover" => "a.cover as cover",
			"banner" => "a.banner as banner",
			"chat_num" => "a.chat_num as chat_num",
			"post_num" => "a.post_num as post_num",
			"created_at" => "a.created_at as created_at",
			"status" => "a.status as status",
			"member_name" => "b.member_name as member_name",
			"mobile" => "b.mobile as mobile",
			"member_head" => "b.portrait as member_head"
		];

		$selectedFields = [];

		if ($options['fields']) {

			$sfs = explode(',', $options['fields']);

			foreach($sfs as $sf) {

				if (array_key_exists($sf, $fieldArr)) {

					$selectedFields[$sf] = $fieldArr[$sf];

				}

			}

		} else {

			$selectedFields = $fieldArr;

		}

		$fields = implode(",", $selectedFields);

		/**
		 * 通过拼接sql查询
		 */
		$sql = " SELECT {$fields} FROM topic a JOIN member b ON a.member_id = b.id WHERE 1=1 ";

		if (isset($options['member_id'])) {

			$query[] = $options['member_id'];

			$sql .= " and a.member_id = ? ";

		}
		if (isset($options['title'])) {

			$query[] = $options['title'];

			$sql .= " and a.title like '%?%' "; 

		}
		if (isset($options['content'])) {

			$query[] = $options['content'];

			$sql .= " and a.content like '%?%' "; 			

		}	

		$offset = ($options['page'] - 1) * $options['page_size'];

		$order = $options['order'] ? $options['order'] : ' a.created_at DESC ';

		$sql .= " ORDER BY {$order} LIMIT {$offset}, {$options['page_size']} ";

		$list = $this->modelInst()->queryRows($sql, $query);

		$total = $this->queryCount($query, "");

		return [ 'list' => $list, 'total' => $total ];

	}

	/**
	 * 查询话题详情
	 *
	 * @param array data
   *
 	 * @return int id
	 */
	public function getDetail($options) {

		$key = md5("nc_topic_detail_{$options['id']}");

		$detail = RedisClient::get('nc_topic_detail', $key, true);

		if (!$detail || $detail['expire_at'] < time()) {

			$detail = $this->findOne($options['id']);

			$detail['expire_at'] = time() + 1800;

			RedisClient::set('nc_topic_detail', $key, $detail);

		}

		$msv = new MemberSv();

		$mfields = [
			'mobile',
			'favorite_num',
			'member_name',
			'portrait as member_head'
		];

		$detail['author'] = $msv->findOne($detail['member_id'], implode(',', $mfields));

		/**
		 * 关注话题和作者
		 */
		if ($options['favorite_member_id']) {

			$tfsv = new TopicFavoriteSv();

			$mfsv = new MemberFavoriteSv();

			$tf = $tfsv->findOne([ 

				'topic_id' => $options['id'], 

				'member_id' => $options['favorite_member_id']

			]);

      $mf = $mfsv->findOne([ 

      	'focus_id' => $detail['member_id'], 

      	'member_id' => $options['favorite_member_id']

      ]);

      if ($tf) {

      	$detail['is_favorite'] = 1;

      }
      
      if ($mf) {

      	$detail['author']['is_favorite'] = 1;

      }

		}

		return $detail;

	}

}