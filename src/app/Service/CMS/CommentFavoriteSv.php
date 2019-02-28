<?php
namespace App\Service\CMS;

use App\Service\BaseService;
use Core\Service\CurdSv;

class CommentFavoriteSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		/**
		 * 判断是否已经点赞
		 */
		$exist = $this->findOne([ 

			'member_id' => $options['member_id'], 

			'comment_id' => $options['comment_id'] 

		]);

		if ($exist) {

			return 0;

		}

		$newData = [

			"comment_id" => $options['comment_id'],

			"member_id" => $options['member_id'],

			"created_at" => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		if ($id) {

			$num = $this->queryCount([ 'comment_id' => $options['comment_id'] ]);

			$cmsv = new CommentSv();

			$cmsv->edit([ 'id' => $options['comment_id'], 'favorite_num' => $num ]);

		}

		return $id;

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

	public function getList($options) {

		$query = [];

		$cntQuery = [];

		$fieldArr = [
			'id' => 'a.id as id',
			'member_id' => 'a.member_id as member_id',
			'comment_id' => 'a.comment_id as comment_id',
			'module' => 'b.module as module',
			'content' => 'b.content as content',
			'deliver_at' => 'b.created_at as deliver_at',
			'reply_to' => 'b.reply_to as reply_to',
			'object_id' => 'b.object_id as object_id',
			'root_id' => 'b.root_id as root_id',
			'member_name' => 'c.member_name',
			'member_head' => 'c.portrait as member_head',
			'mobile' => 'c.mobile as mobile',
			'created_at' => 'a.created_at'
		];

		$fields = implode(',', $fieldsArr);

		$sql = "SELECT {$fields} FROM comment_favorite a JOIN comment b ON a.comment_id = b.id JOIN member c ON a.member_id = c.id  WHERE 1=1 ";

		if ($options['member_id']) {

			$sql .= " and a.member_id = ? ";

			$query['a.member_id'] = $options['member_id'];

			$cntQuery['member_id'] = $options['member_id'];

		}
		if ($options['comment_id']) {

			$sql .= " and a.comment_id = ? ";

			$query['a.comment_id'] = $options['comment_id'];

			$cntQuery['comment_id'] = $options['comment_id'];

		}

		$total = $this->queryCount($cntQuery);

		$list = $this->modelInst()->queryRows($sql, $query);

		return [ 'list' => $list, 'total' => $total ];

	}

}