<?php
namespace App\Service\CMS;

use App\Service\Crm\MemberSv;
use App\Service\Resource\ImageSv;
use App\Service\BaseService;
use App\Library\RedisClient;
use Core\Service\CurdSv;

class PostSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$newData = [

			'member_id' => $options['member_id'],
			'module' => $options['module'],
			'object_id' => $options['object_id'],
			'content' => $options['content'],
			'status' => $options['status'],
			'forbid' => 0,
			'created_at' => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		if ($id) {

			if ($options['imgs']) {

				$imgSv = new ImageSv();

				$imgs = json_decode($options['imgs'], true);

				$imgSv->batchCreate($imgs, 2, $id);

			}

			$tsv = new TopicSv();

			$topic = $tsv->findOne($options['object_id']);

			$tsv->edit([

				'id' => $options['object_id'],

				'post_num' => $topic['post_num'] + 1

			]);

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

		$key = md5("nc_post_detail_{$id}");

		RedisClient::set('nc_post_detail', $key, '');

		return $this->update($id, $updateData);

	}

	public function getList($options) {

		$query = [];

		$cntQuery = [];

		$fieldArr = [
			'id' => 'a.id as id',
			'member_id' => 'a.member_id as member_id',
			'module' => 'a.module as module',
			'object_id' => 'a.object_id as object_id',
			'content' => 'a.content as content',
			'status' => 'a.status as status',
			'forbid' => 'a.forbid as forbid',
			'favorite_num' => 'a.favorite_num as favorite_num',
			'chat_num' => 'a.chat_num as chat_num',
			'created_at' => 'a.created_at as created_at',
			'member_name' => 'b.member_name as member_name',
			'member_head' => 'b.portrait as member_head',
			'mobile' => 'b.mobile as mobile'
		];

		if ($options['favorite_member_id']) {

			$fieldArr['favorite_member_id'] = ' c.member_id as favorite_member_id ';

		}
		if ($options['topic_info']) {

			$fieldArr['topic_title'] = ' x.title as topic_title ';

			$fieldArr['topic_cover'] = ' x.cover as topic_cover ';

		}

		$fields = $options['fields'] ? $options['fields'] : implode(',', $fieldArr);

		/**
		 * 通过拼接sql查询
		 */
		$sql = " SELECT {$fields} FROM post a JOIN member b ON a.member_id = b.id ";

		if ($options['topic_info']) {

			$sql .= " JOIN topic x ON x.id = a.object_id ";

		}

		if ($options['favorite_member_id']) {

			$sql .= " LEFT JOIN post_favorite c ON a.id = c.post_id AND c.member_id = {$options['favorite_member_id']} ";

		}

		$sql .= " WHERE 1=1 ";

		if (isset($options['member_id'])) {

			$query['a.member_id'] = $options['member_id'];

			$cntQuery['member_id'] = $options['member_id'];

			$sql .= " and member_id = ? ";

		}
		if (isset($options['module'])) {

			$query['a.module'] = $options['module'];

			$cntQuery['module'] = $options['module'];

			$sql .= " and module = ? "; 

		}
		if (isset($options['object_id'])) {

			$query['a.object_id'] = $options['object_id'];

			$cntQuery['object_id'] = $options['object_id'];

			$sql .= " and object_id = ? "; 			

		}
		if (isset($options['content'])) {

			$query['a.content'] = $options['content'];

			$cntQuery['content'] = $options['content'];

			$sql .= " and content like %?% "; 			

		}
		if (isset($options['forbid'])) {

			$query['a.forbid'] = $options['forbid'];

			$cntQuery['forbid'] = $options['forbid'];

			$sql .= " and forbid  = ? "; 			

		}	

		$offset = ($options['page'] - 1) * $options['page_size'];

		$order = $options['order'] ? $options['order'] : ' a.created_at DESC ';

		$sql .= " ORDER BY {$order} LIMIT {$offset}, {$options['page_size']} ";

		$results = $this->modelInst()->queryRows($sql, $query);

		$cids = [];

		/**
		 * 查询评论所包含的图片
		 */
		foreach($results as $key => $result) {

			$results[$key]['imgs'] = [];

			$cids[] = $result['id'];

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

	public function getDetail($options) {

		$key = md5("nc_post_detail_{$options['id']}");

		try {

			$detail = RedisClient::get('nc_post_detail', $key, true);

		} catch (\Exception $e) {

			$detail = NULL;

		}

		if ($detail && $detail['expire_at'] > time()) {

			return $detail;

		} else {

			$post = $this->findOne($options['id']);

			$msv = new MemberSv();

			$member = $msv->findOne($post['member_id'], 'member_name,portrait as member_head, mobile');

			$post['member_info'] = $member;

			$imgSv = new ImageSv();

			$imgs = $imgSv->all([ 'module' => 2, 'relat_id' => $post['id'] ]);

			$post['imgs'] = $imgs;

			$post['expire_at'] = time() + 3600;

			RedisClient::set('nc_post_detail', $key, $post);

			return $post;

		}

	}

}