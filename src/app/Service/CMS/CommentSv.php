<?php
namespace App\Service\CMS;

use App\Service\Crm\MemberSv;
use App\Service\Resource\ImageSv;
use App\Service\BaseService;
use App\Library\RedisClient;
use Core\Service\CurdSv;

/**
 * 评论相关服务
 */
class CommentSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$newData = [

			'member_id' => $options['member_id'],
			'module' => $options['module'],
			'object_id' => $options['object_id'],
			'root_id' => $options['root_id'],
			'content' => $options['content'],
			'status' => $options['status'],
			'reply_to' => $options['reply_to'],
			'forbid' => 0,
			'created_at' => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		if ($options['imgs']) {

			$imgSv = new ImageSv();

			$imgs = json_decode($options['imgs'], true);

			$imgSv->batchCreate($imgs, 2, $id);

		}

		switch($options['module']) {

			case 1:  // 评论帖子

				$postSv = new PostSv();

				$post = $postSv->findOne($options['object_id']);

				$postSv->edit([ 

					"id" => $options['object_id'], 

					"chat_num" => $post['chat_num'] + 1 

				]);

				$topicSv = new TopicSv();

				$topic = $topicSv->findOne($post['object_id']);

				$topicSv->edit([

					"id" => $topic['id'],

					"chat_num" => $topic['chat_num'] + 1

				]);

				break;

		}

		return $id;

	}

	public function edit($options) {

		$id = $options['id'];

		$updateData = [];

		if ($options['content']) {

			$updateData['content'] = $options['content'];

		}
		if ($options['chat_num']) {

			$updateData['chat_num'] = $options['chat_num'];

		}
		if ($options['favorite_num']) {

			$updateData['favorite_num'] = $options['favorite_num'];

		}
		if ($options['forbid']) {

			$updateData['forbid'] = $options['forbid'];

		}

		$key = md5("nc_comment_detail_{$id}");

		RedisClient::set('nc_comment_detail', $key, '');

		return $this->update($id, $updateData);

	}

	public function getDetail($options) {

		$key = md5("nc_comment_detail_{$options['id']}");

		try {

			$detail = RedisClient::get('nc_comment_detail', $key, true);

		} catch (\Exception $e) {

			$detail = NULL;

		}

		if ($detail && $detail['expire_at'] > time()) {

			return $detail;

		} else {

			$comment = $this->findOne($options['id']);

			$msv = new MemberSv();

			$member = $msv->findOne($comment['member_id'], 'member_name,portrait,mobile');

			$comment['member_head'] = $member['portrait'];

			$comment['member_name'] = $member['member_name'];

			$comment['mobile'] = $member['mobile'];

			$imgSv = new ImageSv();

			$imgs = $imgSv->all([ 'module' => 2, 'relat_id' => $comment['id'] ]);

			$comment['imgs'] = $imgs;

			$comment['expire_at'] = time() + 3600;

			RedisClient::set('nc_comment_detail', $key, $comment);

			return $comment;

		}

	}

	public function getList($options) {

		$query = [];

		$cntQuery = [];

		$fieldArr = [
			'id' => 'a.id as id',
			'member_id' => 'a.member_id as member_id',
			'module' => 'a.module as module',
			'object_id' => 'a.object_id as object_id',
			'root_id' => 'a.root_id as root_id',
			'reply_to' => 'a.reply_to as reply_to',
			'content' => 'a.content as content',
			'status' => 'a.status as status',
			'forbid' => 'a.forbid as forbid',
			'favorite_num' => 'a.favorite_num as favorite_num',
			'chat_num' => 'a.chat_num as chat_num',
			'created_at' => 'a.created_at as created_at',
			'member_name' => 'b.member_name as member_name',
			'member_head' => 'b.portrait as member_head',
			'mobile' => 'b.mobile as mobile',
			'reply_name' => 'd.member_name as reply_name',
			'reply_member_id' => 'c.member_id as reply_member_id'
		];

		if ($options['favorite_member_id']) {

			$fieldArr['favorite_member_id'] = ' e.member_id as favorite_member_id ';

		}

		$fields = $options['fields'] ? $options['fields'] : implode(',', $fieldArr);

		/**
		 * 通过拼接sql查询
		 */
		$sql = " SELECT {$fields} FROM comments a JOIN member b ON a.member_id = b.id LEFT JOIN comments c on a.reply_to = c.id LEFT JOIN member d ON c.member_id = d.id ";

		if ($options['favorite_member_id']) {

			$sql .= " LEFT JOIN comment_favorite e ON a.id = e.comment_id ";

		}

		$sql .= " WHERE 1=1 ";

		if (isset($options['member_id'])) {

			$query['a.member_id'] = $options['member_id'];

			$cntQuery['member_id'] = $options['member_id'];

			$sql .= " and a.member_id = ? ";

		}
		if (isset($options['module'])) {

			$query['a.module'] = $options['module'];

			$cntQuery['module'] = $options['module'];

			$sql .= " and a.module = ? "; 

		}
		if (isset($options['object_id'])) {

			$query['a.object_id'] = $options['object_id'];

			$cntQuery['object_id'] = $options['object_id'];

			$sql .= " and a.object_id = ? "; 			

		}
		if (isset($options['root_id'])) {

			$query['a.root_id'] = $options['root_id'];

			$cntQuery['root_id'] = $options['root_id'];

			$sql .= " and a.root_id = ? "; 			

		}	
		if (isset($options['reply_to'])) {

			$query['a.reply_to'] = $options['reply_to'];

			$cntQuery['reply_to'] = $options['reply_to'];

			$sql .= " and a.reply_to = ? "; 			

		}
		if (isset($options['content'])) {
	
			$query['a.content'] = $options['content'];

			$cntQuery['content'] = $options['content'];

			$sql .= " and a.content like %?% "; 			

		}
		if (isset($options['forbid'])) {

			$query['a.forbid'] = $options['forbid'];

			$cntQuery['forbid'] = $options['forbid'];

			$sql .= " and a.forbid  = ? "; 			

		}	

		$offset = ($options['page'] - 1) * $options['page_size'];

		if ($options['order']) {

			$orders = explode(',', $options['order']);

			$orderStr = "";

			foreach($orders as $od) {

				$str = explode(' ', $od);

				$orderStr .= "a.{$str[0]} {$str[1]},";

			}

			$orderStr = substr($orderStr, 0, strlen($orderStr) - 1);

		}

		$order = $orderStr ? $orderStr : ' a.created_at DESC ';

		$sql .= " ORDER BY {$order} LIMIT {$offset}, {$options['page_size']} ";

		$results = $this->modelInst()->queryRows($sql, $query);

		$cids = [];

		/**
		 * 查询评论所包含的图片
		 */

		foreach($results as $key => $result) {

			$results[$key]['imgs'] = [];

			$cids[] = $result['id'];

			if ($options['self_id']) {

				if ($result['member_id'] == $options['self_id']) {

					$results[$key]['self'] = 1;

				}

			}

		}

		$imgSv = new ImageSv();

		$cimgs = $imgSv->all([ 'module' => 2, 'relat_id' => implode(',', $cids) ]);

		foreach($results as $key => $result) {

			foreach($cimgs as $cimg) {

				if ($result['id'] == $cimg['relat_id']) {

					$results[$key]['imgs'][] = $cimg;

				}

			}

		}

		$total = $this->queryCount($query); 

		return [ 'list' => $results, 'total' => $total ];

	}

}