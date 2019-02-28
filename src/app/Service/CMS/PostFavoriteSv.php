<?php
namespace App\Service\CMS;

use App\Service\BaseService;
use Core\Service\CurdSv;

class PostFavoriteSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		/**
		 * 判断是否已经点赞
		 */
		$exist = $this->findOne([ 'member_id' => $options['member_id'], 'post_id' => $options['post_id'] ]);

		if ($exist) {

			return 0;

		}

		$newData = [

			"member_id" => $options['member_id'],

			"post_id" => $options['post_id'],

			"created_at" => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		if ($id) {

			$num = $this->queryCount([ 'post_id' => $options['post_id'] ]);

			$ptsv = new PostSv();

			$ptsv->edit([ 'id' => $options['post_id'], 'favorite_num' => $num ]);

		}

		return $id;

	}

	public function getList($options) {

		$query = [];

		$cntQuery = [];

		$fieldArr = [
			'id' => 'a.id as id',
			'member_id' => 'a.member_id as member_id',
			'post_id' => 'a.post_id as post_id',
			'module' => 'b.module as module',
			'content' => 'b.content as content',
			'deliver_at' => 'b.created_at as deliver_at',
			'object_id' => 'b.object_id as object_id',
			'member_name' => 'c.member_name',
			'member_head' => 'c.portrait as member_head',
			'mobile' => 'c.mobile as mobile',
			'created_at' => 'a.created_at'
		];

		$fields = implode(',', $fieldsArr);

		$sql = "SELECT {$fields} FROM post_favorite a JOIN post b ON a.post_id = b.id JOIN member c ON a.member_id = c.id  WHERE 1=1 ";

		if ($options['member_id']) {

			$sql .= " and a.member_id = ? ";

			$query['a.member_id'] = $options['member_id'];

			$cntQuery['member_id'] = $options['member_id'];

		}
		if ($options['post_id']) {

			$sql .= " and a.post_id = ? ";

			$query['a.post_id'] = $options['post_id'];

			$cntQuery['post_id'] = $options['post_id'];

		}

		$total = $this->queryCount($cntQuery);

		$list = $this->modelInst()->queryRows($sql, $query);

		return [ 'list' => $list, 'total' => $total ];

	}

	public function cancel($options) {

		$old = $this->findOne([ 

			'comment_id' => $options['comment_id'], 

			'member_id' => $options['member_id']

		]);

		$result = $this->remove($old['id']);

		if ($result) {

			$num = $this->queryCount([ 'comment_id' => $old['comment_id'] ]);

			$cmsv = new CommentSv();

			$cmsv->update($old['comment_id'], [ 'favorite_num' => $num ]);

			return $num;

		} else {

			return $result;

		}

	}

}