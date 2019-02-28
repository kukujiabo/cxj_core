<?php
namespace App\Service\CMS;

use App\Service\BaseService;
use Core\Service\CurdSv;

class TopicFavoriteSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$newData = [

			'member_id' => $options['member_id'],
			'author_id' => $options['author_id'],
			'topic_id' => $options['topic_id'],
			'created_at' => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		$tsv = new TopicSv();

		$topic = $tsv->findOne($options['topic_id']);

		$tsv->edit($id, [ 'favorite_num' => $topic['favorite_num'] + 1 ]);

		return $id;

	}

	public function cancel($options) {

		$old = $this->findOne([ 

			'member_id' => $options['member_id'], 

			'topic_id' => $options['topic_id'] 

		]);

		$num = $this->remove($old['id']);

		if ($num) {

			$tsv = new TopicSv();

			$topic = $tsv->findOne($options['topic_id']);

			$tsv->edit($topic['id'], [ 'favorite_num' => $topic['favorite_num'] - 1 ]);

		}

		return $num;

	}

	public function getList($options) {

		$fieldsArr = [
			'a.id as id',
			'a.member_id as member_id',
			'a.topic_id as topic_id',
			'b.title as title',
			'b.content as content',
			'b.member_id as author_id',
			'c.member_name as member_name',
			'c.portrait as member_head',
			'd.member_name as author_name',
			'd.portrait as author_portrait',
			'a.created_at as created_at'
		];

		$fields = implode(',', $fieldsArr);

		$sql = "SELECT {$fields} FROM topic_favorite a JOIN member b ON a.member_id = b.id JOIN topic c ON a.topic_id = c.id JOIN member d ON c.member_id = d.id WHERE 1=1 ";

		$query = [];

		if ($options['member_id']) {

			$sql .= " AND a.member_id = ? ";

			$query[] = $options['member_id'];

		}
		if ($options['topic_id']) {

			$sql .= " AND a.topic_id = ? ";

			$query[] = $options['topic_id'];			

		}
		if ($options['author_id']) {

			$sql .= " AND c.member_id = ? ";

			$query[] = $options['author_id'];			

		}

		return $this->modelInst()->queryRows($sql, $query);

	}

}