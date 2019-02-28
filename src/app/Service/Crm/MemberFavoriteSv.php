<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;
use App\Service\Crm\MemberSv;

class MemberFavoriteSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$old = $this->findOne([ 

			'member_id' => $options['member_id'], 

			'focus_id' => $options['focus_id']

		]);

		if ($old) {

			return 0;

		}

		$newData = [

			'member_id' => $options['member_id'],

			'focus_id' => $options['focus_id'],

			'created_at' => date('Y-m-d H:i:s')

		];

		$id = $this->add($newData);

		$msv = new MemberSv();

		$member = $msv->findOne($options['focus_id']);

		$msv->editMember($options['focus_id'], [ 'favorite_num' => $member['favorite_num'] + 1 ]);

		return $id;

	}

	public function getList($options) {

		$query = [];

		$cntQuery = [];

		$fieldArr = [
			'id' => 'a.id as id',
			'member_id' => 'a.member_id as member_id',
			'focus_id' => 'a.focus_id as focus_id',
			'member_name' => 'b.member_name as member_name',
			'member_head' => 'b.portrait as member_head',
			'member_favorite' => 'b.favorite_num as member_favorite',
			'focus_name' => 'c.member_name as focus_name',
			'focus_head' => 'c.portrait as focus_head',
			'focus_favorite' => 'c.favorite_num as focus_favorite',
			'created_at' => 'a.created_at as created_at'
		];

		$fields = implode(',', $fieldArr);

		$sql = " SELECT {$fields} FROM member_favorite a JOIN member b on a.member_id = b.id JOIN member c ON a.focus_id = c.id WHERE 1=1 ";

		if ($options['member_id']) {

			$query[] = $options['member_id'];

			$cntQuery['member_id'] = $options['member_id'];

			$sql .= " AND a.member_id = ? ";

		}
		if ($options['focus_id']) {

			$query[] = $options['focus_id'];

			$cntQuery['focus_id'] = $options['focus_id'];

			$sql .= " AND a.focus_id = ? ";

		}

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

		$cnt = $this->queryCount($cntQuery);

		$result = $this->modelInst()->queryRows($sql, $query);

		return [ 'list' => $result, 'total' => $cnt ];

	}

	public function cancel($options) {

		$old = $this->findOne([ 

			'member_id' => $options['member_id'], 

			'focus_id' => $options['focus_id'] 

		]);

		$num = $this->remove($old['id']);

		if ($num) {

			$msv = new MemberSv();

			$member = $msv->findOne($options['focus_id']);

			$msv->editMember($options['focus_id'], [ 'favorite_num' => $member['favorite_num'] - 1 ]);

		}

		return $num;

	}

}