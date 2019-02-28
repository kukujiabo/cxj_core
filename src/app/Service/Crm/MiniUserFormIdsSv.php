<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;

class MiniUserFormIdsSv extends BaseService {
	
	use CurdSv;

	public function create($options) {

		$newData = [

			'get_type' => $options['get_type'],

			'member_id' => $options['member_id'],

			'form_id' => $options['form_id'],

			'expire_at' => time() + 604800,

			'created_at' => date('Y-m-d H:i:s')

		];

		return $this->add($newData);

	}	

	public function getList($options) {



	}

	public function getLastOne($options) {

		$sql = "SELECT id, form_id FROM mini_user_form_ids WHERE expire_at < ? ORDER BY id ASC LIMIT 1";

		$query = [ time() ];

		$list = $this->modelInst()->queryRows($sql, $query);

		return $list[0];

	}

	public function getDetail($options) {



	}

}