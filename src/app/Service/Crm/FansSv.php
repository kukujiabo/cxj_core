<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 粉丝服务
 */
class FansSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$newData = [

			'member_id' => $options['member_id'],
			'focus_id' => $options['focus_id'],
			'created_at' => date('Y-m-d H:i:s')

		];

		return $this->add($newData);

	}

	public function getList($options) {

		$query = [];

		$fieldArr = [
			'a.id as id',
			'a.member_id as member_id',
			'b.member_name as member_name',
			'b.portrait as member_portrait',
			'a.focus_id as focus_id',
			'c.member_name as focus_name',
			'c.portrait as focus_portrait',
			'a.created_at as created_at'
		];

		$fields = $options['fields'] ? $options['fields'] : implode(',', $fieldArr);

		/**
		 * 通过拼接sql查询
		 */
		$sql = " SELECT {$fields} FROM fans a JOIN member b ON a.member_id = b.id JOIN member c ON a.focus_id = c.id WHERE 1=1 ";

		if (isset($options['member_id'])) {

			$query[] = $options['member_id'];

			$sql .= " and a.member_id = ? ";

		}

		if (isset($options['focus_id'])) {

			$query[] = $options['focus_id'];

			$sql .= " and a.focus_id = ? "; 

		}

		$offset = ($options['page'] - 1) * $options['page_size'];

		$order = $options['order'] ? $options['order'] : ' a.created_at DESC ';

		$sql .= " ORDER BY {$order} LIMIT {$offset}, {$options['page_size']} ";

		return $this->modelInst()->queryRows($sql, $query);

	}

}